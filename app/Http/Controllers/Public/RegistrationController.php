<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Staff;
use App\Models\Guardian;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function showForm($role, $key)
    {
        $school = School::where('reg_key', $key)->firstOrFail();
        
        // Check if registration for this role is active
        $statusField = ($role == 'parent' ? 'parent' : $role) . '_reg_active';
        if (!$school->$statusField) {
            abort(403, "Public registration for " . strtoupper($role) . " is currently closed.");
        }

        $classes = SchoolClass::where('school_id', $school->id)->get();
        return view('auth.public-registration', compact('school', 'role', 'classes', 'key'));
    }

    public function store(Request $request, $role, $key)
    {
        $school = School::where('reg_key', $key)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'photo' => 'nullable|image|max:5120', // 5MB
        ]);

        DB::transaction(function () use ($request, $school, $role) {
            // 1. Create the User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $role,
                'school_id' => $school->id,
            ]);

            // 2. Handle Photo Upload
            $photoPath = $request->hasFile('photo') ? $request->file('photo')->store($role . 's/photos', 'public') : null;

            // 3. Create Specific Profile
            if ($role === 'student') {
                Student::create([
                    'user_id' => $user->id, 'school_id' => $school->id,
                    'school_class_id' => $request->school_class_id,
                    'admission_number' => 'REG-' . date('y') . rand(1000, 9999),
                    'gender' => $request->gender, 'date_of_birth' => $request->date_of_birth,
                    'address' => $request->address, 'student_photo' => $photoPath, 'status' => 'active'
                ]);
            } elseif ($role === 'teacher') {
                Teacher::create([
                    'user_id' => $user->id, 'school_id' => $school->id,
                    'staff_id' => 'T-REG-' . rand(100, 999),
                    'phone' => $request->phone, 'qualification' => $request->qualification,
                    'employment_date' => now(), 'base_salary' => 0, 'photo' => $photoPath, 'status' => 'active'
                ]);
            } elseif ($role === 'parent') {
                Guardian::create([
                    'user_id' => $user->id, 'school_id' => $school->id,
                    'phone' => $request->phone, 'occupation' => $request->occupation,
                    'address' => $request->address
                ]);
            } elseif ($role === 'staff' || $role === 'accountant' || $role === 'librarian') {
                Staff::create([
                    'user_id' => $user->id, 'school_id' => $school->id,
                    'staff_id' => 'S-REG-' . rand(100, 999),
                    'phone' => $request->phone, 'designation' => $request->designation ?? 'Support Staff',
                    'employment_date' => now(), 'base_salary' => 0, 'photo' => $photoPath, 'status' => 'active'
                ]);
            }
        });

        return redirect()->route('login')->with('success', 'Registration successful! Please log in to your new portal.');
    }
}