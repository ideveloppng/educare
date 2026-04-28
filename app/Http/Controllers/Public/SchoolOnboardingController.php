<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchoolOnboardingController extends Controller
{
    /**
     * Show the school registration form
     */
    public function showForm()
    {
        return view('auth.register-school');
    }

    /**
     * Handle the registration request
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255|unique:schools,name',
            'school_email' => 'required|email|unique:schools,email',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'logo' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Upload Logo if present
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('schools/logos', 'public');
            }

            // 2. Create the School with 30-Day Trial
            $school = School::create([
                'name' => $request->school_name,
                'slug' => Str::slug($request->school_name),
                'email' => $request->school_email,
                'logo' => $logoPath,
                'status' => 'active',
                'current_session' => date('Y') . '/' . (date('Y') + 1),
                'current_term' => 'First Term',
                'trial_ends_at' => now()->addDays(30), // AUTO TRIAL
            ]);

            // 3. Create the Primary Admin User
            User::create([
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->password),
                'role' => 'admin',
                'school_id' => $school->id,
            ]);
        });

        return redirect()->route('login')->with('success', 'Your school has been registered! You are now on a 30-day free trial. Please log in to continue.');
    }
}