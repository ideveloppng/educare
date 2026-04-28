<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        
        // Fetch assignments for the student's class
        $assignments = Assignment::where('school_class_id', $student->school_class_id)
            ->with(['subject', 'submissions' => function($q) use ($student) {
                $q->where('student_id', $student->id);
            }])
            ->latest()->get();

        return view('dashboards.student.assignments.index', compact('assignments'));
    }

    public function submit(Request $request, Assignment $assignment)
    {
        $request->validate([
            'student_notes' => 'nullable|string',
            'attachment' => 'required|file|max:10240',
        ]);

        $path = $request->file('attachment')->store('assignments/submissions', 'public');

        AssignmentSubmission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'student_id' => auth()->user()->student->id],
            [
                'student_notes' => $request->student_notes,
                'file_path' => $path,
                'submitted_at' => now(),
                'status' => 'pending'
            ]
        );

        return back()->with('success', 'Assignment submitted successfully.');
    }
}