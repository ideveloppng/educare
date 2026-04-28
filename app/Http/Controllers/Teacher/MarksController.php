<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\TeacherAssignment;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarksController extends Controller
{
    /**
     * Display the list of classes and subjects assigned to the teacher.
     * THIS FIXES THE UNDEFINED METHOD ERROR
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->teacher) {
            return redirect()->route('dashboard')->with('error', 'Teacher profile not found.');
        }

        // Fetch all workload assignments for this teacher
        $workload = TeacherAssignment::where('teacher_id', $user->teacher->id)
            ->with(['schoolClass', 'subject'])
            ->get();

        return view('dashboards.teacher.marks.index', compact('workload'));
    }

    /**
     * Show the spreadsheet for entering marks for a specific class/subject.
     */
    public function entry(SchoolClass $class, Subject $subject)
    {
        $school = Auth::user()->school;
        
        // Security: Ensure teacher is assigned to this specific pairing
        $isAssigned = TeacherAssignment::where('teacher_id', Auth::user()->teacher->id)
            ->where('school_class_id', $class->id)
            ->where('subject_id', $subject->id)
            ->exists();

        if (!$isAssigned) {
            abort(403, 'Unauthorized access to this class assessment.');
        }

        // Fetch all students in the class
        $students = Student::where('school_class_id', $class->id)
            ->with('user')
            ->get();

        // Fetch existing marks for the current term and session to pre-fill
        $existingResults = Result::where('school_class_id', $class->id)
            ->where('subject_id', $subject->id)
            ->where('term', $school->current_term)
            ->where('session', $school->current_session)
            ->get()
            ->keyBy('student_id');

        return view('dashboards.teacher.marks.entry', compact('class', 'subject', 'students', 'existingResults'));
    }

    /**
     * Save marks as draft (is_published = false)
     */
    public function store(Request $request, SchoolClass $class, Subject $subject)
    {
        $school = Auth::user()->school;
        $teacher = Auth::user()->teacher;

        $request->validate([
            'marks' => 'required|array',
        ]);

        foreach ($request->marks as $studentId => $scores) {
            // New 10/10/10/70 structure
            $ca1 = (float)($scores['ca1'] ?? 0);
            $ca2 = (float)($scores['ca2'] ?? 0);
            $ca3 = (float)($scores['ca3'] ?? 0);
            $exam = (float)($scores['exam'] ?? 0);
            
            $total = $ca1 + $ca2 + $ca3 + $exam;
            
            // Institutional Grading Logic
            $grade = 'F';
            if($total >= 70) $grade = 'A';
            elseif($total >= 60) $grade = 'B';
            elseif($total >= 50) $grade = 'C';
            elseif($total >= 45) $grade = 'D';
            elseif($total >= 40) $grade = 'E';

            Result::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $subject->id,
                    'term' => $school->current_term,
                    'session' => $school->current_session,
                ],
                [
                    'school_id' => $school->id,
                    'school_class_id' => $class->id,
                    'teacher_id' => $teacher->id,
                    'ca1' => $ca1,
                    'ca2' => $ca2,
                    'ca3' => $ca3,
                    'exam' => $exam,
                    'total' => $total,
                    'grade' => $grade,
                    'remarks' => strtoupper($scores['remarks'] ?? 'SATISFACTORY'),
                    // is_published remains false until publish() is called
                ]
            );
        }

        return back()->with('success', 'Marks and individual remarks saved as draft.');
    }

    /**
     * Finalize and publish results for students to see
     */
    public function publish(Request $request, SchoolClass $class, Subject $subject)
    {
        $school = Auth::user()->school;
        
        $results = Result::where([
            'school_class_id' => $class->id,
            'subject_id' => $subject->id,
            'teacher_id' => Auth::user()->teacher->id,
            'term' => $school->current_term,
            'session' => $school->current_session,
        ]);

        if ($results->count() === 0) {
            return back()->with('error', 'No marks found to publish.');
        }

        $results->update(['is_published' => true]);

        return redirect()->route('teacher.marks.index')->with('success', 'Results successfully released to students.');
    }
}