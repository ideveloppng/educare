<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('student.schoolClass');
        return view('dashboards.student.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        $request->validate([
            'name' => 'required|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string|max:500',
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // 10MB
        ]);

        DB::transaction(function () use ($request, $user, $student) {
            // 1. Update Name in Users Table
            $user->update(['name' => $request->name]);

            // 2. Handle Photo Upload
            $photoPath = $student->student_photo;
            if ($request->hasFile('student_photo')) {
                // Delete old photo if it exists
                if ($photoPath) {
                    Storage::disk('public')->delete($photoPath);
                }
                $photoPath = $request->file('student_photo')->store('students/photos', 'public');
            }

            // 3. Update Student Profile
            $student->update([
                'parent_phone' => $request->parent_phone,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'student_photo' => $photoPath,
            ]);
        });

        return back()->with('success', 'Profile updated successfully.');
    }
}