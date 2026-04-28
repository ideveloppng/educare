<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\TeacherAssignment;
use Illuminate\Support\Facades\Auth;

class TeacherDirectoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        // Security check: Ensure student has a class assigned
        if (!$student || !$student->school_class_id) {
            return view('dashboards.student.teachers.index', ['assignments' => collect()]);
        }

        // Fetch teachers assigned to the student's specific class arm
        $assignments = TeacherAssignment::where('school_class_id', $student->school_class_id)
            ->with(['teacher.user', 'subject'])
            ->get();

        return view('dashboards.student.teachers.index', compact('assignments'));
    }
}