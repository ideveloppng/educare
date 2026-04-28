<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\TeacherAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * Display a listing of assignments created by the teacher.
     * THIS FIXES THE UNDEFINED METHOD ERROR
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ensure the teacher profile exists
        if (!$user->teacher) {
            return redirect()->route('dashboard')->with('error', 'Teacher profile not found.');
        }

        $assignments = Assignment::where('teacher_id', $user->teacher->id)
            ->with(['schoolClass', 'subject'])
            ->withCount('submissions')
            ->latest()
            ->paginate(10);

        return view('dashboards.teacher.assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new assignment.
     */
    public function create()
    {
        $teacher = Auth::user()->teacher;

        // Fetch classes and subjects specifically assigned to this teacher by the Admin
        $workload = TeacherAssignment::where('teacher_id', $teacher->id)
            ->with(['schoolClass', 'subject'])
            ->get();

        return view('dashboards.teacher.assignments.create', compact('workload'));
    }

    /**
     * Store a newly created assignment in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'workload_id' => 'required|exists:teacher_assignments,id', 
            'due_date' => 'required|after:today',
            'max_score' => 'required|integer|min:1',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:10240', // 10MB Max
        ]);

        $workload = TeacherAssignment::findOrFail($request->workload_id);
        
        $filePath = null;
        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('assignments/resources', 'public');
        }

        Assignment::create([
            'school_id' => Auth::user()->school_id,
            'teacher_id' => Auth::user()->teacher->id,
            'school_class_id' => $workload->school_class_id,
            'subject_id' => $workload->subject_id,
            'title' => strtoupper($request->title),
            'description' => $request->description,
            'due_date' => $request->due_date,
            'max_score' => $request->max_score,
            'file_path' => $filePath,
        ]);

        return redirect()->route('teacher.assignments.index')->with('success', 'New assignment published to class.');
    }

    /**
     * Display submissions for a specific assignment.
     */
    public function submissions(Assignment $assignment)
    {
        // Security check: Ensure teacher owns this assignment
        if ($assignment->teacher_id !== Auth::user()->teacher->id) {
            abort(403, 'Unauthorized access.');
        }

        $submissions = $assignment->submissions()
            ->with(['student.user'])
            ->latest()
            ->get();
        
        return view('dashboards.teacher.assignments.submissions', compact('assignment', 'submissions'));
    }

    /**
     * Update the grade and feedback for a student submission.
     */
    public function grade(Request $request, AssignmentSubmission $submission)
    {
        $assignment = $submission->assignment;

        $request->validate([
            'grade' => "required|numeric|min:0|max:{$assignment->max_score}",
            'feedback' => 'nullable|string'
        ]);

        $submission->update([
            'grade' => $request->grade,
            'teacher_feedback' => $request->feedback,
            'status' => 'graded'
        ]);

        return back()->with('success', 'Student assessment updated.');
    }
}