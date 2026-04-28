<?php

namespace App\Http\Controllers\Accountant;

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
        $user = Auth::user()->load('staff');
        return view('dashboards.accountant.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $staff = $user->staff;

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // 10MB
        ]);

        DB::transaction(function () use ($request, $user, $staff) {
            $user->update(['name' => $request->name]);

            $photoPath = $staff->photo;
            if ($request->hasFile('photo')) {
                if ($photoPath) {
                    Storage::disk('public')->delete($photoPath);
                }
                $photoPath = $request->file('photo')->store('staff/photos', 'public');
            }

            $staff->update([
                'phone' => $request->phone,
                'photo' => $photoPath,
            ]);
        });

        return back()->with('success', 'Finance profile updated successfully.');
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

        return back()->with('success', 'Account password changed successfully.');
    }
}