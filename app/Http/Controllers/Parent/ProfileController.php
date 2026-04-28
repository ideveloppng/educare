<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('guardian');
        return view('dashboards.parent.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $guardian = $user->guardian;

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:guardians,phone,' . $guardian->id,
            'occupation' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request, $user, $guardian) {
            // Update User Name
            $user->update(['name' => $request->name]);

            // Update Guardian Profile
            $guardian->update([
                'phone' => $request->phone,
                'occupation' => strtoupper($request->occupation),
                'address' => $request->address,
            ]);
        });

        return back()->with('success', 'Your profile has been updated successfully.');
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

        return back()->with('success', 'Your password has been changed successfully.');
    }
}