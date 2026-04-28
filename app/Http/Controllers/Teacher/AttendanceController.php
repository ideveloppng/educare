<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\TeacherAssignment;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display the list of classes assigned to the teacher for attendance.
     * THIS FIXES THE UNDEFINED METHOD ERROR
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ensure teacher profile exists
        if (!$user->teacher) {
            return redirect()->route('dashboard')->with('error', 'Teacher profile not found.');
        }

        // Get unique classes assigned to this teacher from the workload mapping
        $classes = TeacherAssignment::where('teacher_id', $user->teacher->id)
            ->with('schoolClass')
            ->get()
            ->pluck('schoolClass')
            ->unique('id');

        return view('dashboards.teacher.attendance.index', compact('classes'));
    }

    /**
     * Show the roll call form for a specific class for the current day.
     */
    public function take(SchoolClass $class)
    {
        $this->authorizeTeacher($class);

        // Fetch all students in this class
        $students = Student::where('school_class_id', $class->id)
            ->with('user')
            ->get();

        // Check if attendance was already recorded today to pre-fill the form
        $existingRecords = Attendance::where('school_class_id', $class->id)
            ->where('date', now()->toDateString())
            ->get()
            ->pluck('status', 'student_id');

        return view('dashboards.teacher.attendance.take', compact('class', 'students', 'existingRecords'));
    }

    /**
     * Store the daily attendance records.
     */
    public function store(Request $request, SchoolClass $class)
    {
        $this->authorizeTeacher($class);
        
        $request->validate([
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late',
        ]);

        $teacher = Auth::user()->teacher;
        $date = now()->toDateString();

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'school_class_id' => $class->id,
                    'student_id' => $studentId,
                    'date' => $date
                ],
                [
                    'school_id' => Auth::user()->school_id,
                    'teacher_id' => $teacher->id,
                    'status' => $status,
                ]
            );
        }

        return redirect()->route('teacher.attendance.index')->with('success', 'Daily attendance recorded successfully.');
    }

    /**
     * View attendance history for a specific class and date.
     */
    public function history(Request $request, SchoolClass $class)
    {
        $this->authorizeTeacher($class);

        // Default to today if no date is selected
        $date = $request->date ?? now()->toDateString();
        
        $attendance = Attendance::where('school_class_id', $class->id)
            ->where('date', $date)
            ->with('student.user')
            ->get();

        return view('dashboards.teacher.attendance.history', compact('class', 'attendance', 'date'));
    }

    /**
     * Print optimized view for a specific date.
     */
    public function print(Request $request, SchoolClass $class)
    {
        $this->authorizeTeacher($class);

        $date = $request->date ?? now()->toDateString();
        
        $attendance = Attendance::where('school_class_id', $class->id)
            ->where('date', $date)
            ->with('student.user')
            ->get();

        return view('dashboards.teacher.attendance.print', compact('class', 'attendance', 'date'));
    }

    /**
     * Private Security Method: Ensure teacher is assigned to the class they are trying to access.
     */
    private function authorizeTeacher(SchoolClass $class)
    {
        $isAssigned = TeacherAssignment::where('teacher_id', Auth::user()->teacher->id)
            ->where('school_class_id', $class->id)
            ->exists();

        if (!$isAssigned) {
            abort(403, 'Unauthorized access to this class register.');
        }
    }
}