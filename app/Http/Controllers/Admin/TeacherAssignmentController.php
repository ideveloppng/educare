<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\TeacherAssignment;
use Illuminate\Http\Request;

class TeacherAssignmentController extends Controller
{
    public function index()
    {
        $school_id = auth()->user()->school_id;

        // Fetch current assignments with relationships
        $assignments = TeacherAssignment::whereHas('teacher', function($q) use ($school_id) {
            $q->where('school_id', $school_id);
        })->with(['teacher.user', 'schoolClass', 'subject'])->latest()->get();

        // Data for the assignment form
        $teachers = Teacher::where('school_id', $school_id)->with('user')->get();
        $classes = SchoolClass::where('school_id', $school_id)->get();
        $subjects = Subject::where('school_id', $school_id)->get();

        return view('dashboards.admin.teachers.assignments', compact('assignments', 'teachers', 'classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        // Prevent duplicate assignment
        $exists = TeacherAssignment::where([
            'teacher_id' => $request->teacher_id,
            'school_class_id' => $request->school_class_id,
            'subject_id' => $request->subject_id,
        ])->exists();

        if ($exists) {
            return back()->with('error', 'This assignment already exists.');
        }

        TeacherAssignment::create($request->all());

        return back()->with('success', 'Teacher assigned successfully.');
    }

    public function destroy(TeacherAssignment $assignment)
    {
        $assignment->delete();
        return back()->with('success', 'Assignment removed.');
    }
}