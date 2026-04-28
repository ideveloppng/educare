<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherAssignment;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    /**
     * Display a listing of all classes assigned to the teacher.
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;

        // Fetch all assignments and group them by Class ID
        // This handles cases where a teacher teaches multiple subjects in one class
        $assignments = TeacherAssignment::where('teacher_id', $teacher->id)
            ->with(['schoolClass.students', 'subject'])
            ->get()
            ->groupBy('school_class_id');

        return view('dashboards.teacher.classes.index', compact('assignments'));
    }

    /**
     * Display students in a specific assigned class.
     */
    public function show(SchoolClass $class)
    {
        $teacher = Auth::user()->teacher;

        // Security: Check if teacher is assigned to this class
        $isAssigned = TeacherAssignment::where('teacher_id', $teacher->id)
            ->where('school_class_id', $class->id)
            ->exists();

        if (!$isAssigned) {
            abort(403, 'Unauthorized access to this class registry.');
        }

        $students = Student::where('school_class_id', $class->id)
            ->with('user')
            ->latest()
            ->get();

        return view('dashboards.teacher.classes.show', compact('class', 'students'));
    }
}