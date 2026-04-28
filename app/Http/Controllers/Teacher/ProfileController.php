<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('teacher');
        return view('dashboards.teacher.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:male,female',
            'qualification' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // 10MB
        ]);

        DB::transaction(function () use ($request, $user, $teacher) {
            // 1. Update Name in Users Table
            $user->update(['name' => $request->name]);

            // 2. Handle Photo Upload
            $photoPath = $teacher->photo;
            if ($request->hasFile('photo')) {
                if ($photoPath) {
                    Storage::disk('public')->delete($photoPath);
                }
                $photoPath = $request->file('photo')->store('teachers/photos', 'public');
            }

            // 3. Update Teacher Profile
            $teacher->update([
                'phone' => $request->phone,
                'gender' => $request->gender,
                'qualification' => strtoupper($request->qualification),
                'photo' => $photoPath,
            ]);
        });

        return back()->with('success', 'Professional profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Security password changed successfully.');
    }
}