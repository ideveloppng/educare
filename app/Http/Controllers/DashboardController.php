<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/* Models */
use App\Models\School;
use App\Models\User;
use App\Models\Teacher;
use App\Models\TeacherAssignment;
use App\Models\Student;
use App\Models\Notice;
use App\Models\ClassFee;
use App\Models\StudentPayment;
use App\Models\Transaction;
use App\Models\ChildLinkingRequest;
use App\Models\Timetable;
use App\Models\AssignmentSubmission;

class DashboardController extends Controller
{
    /**
     * Master Traffic Warden for the entire SaaS platform.
     */
    public function index()
    {
        $user = Auth::user();
        $school = $user->school;

        return match ($user->role) {
            'super_admin' => $this->superAdminDashboard(),
            'admin'       => $this->schoolAdminDashboard($user, $school),
            'teacher'     => $this->teacherDashboard($user, $school),
            'student'     => $this->studentDashboard($user, $school),
            'parent'      => $this->parentDashboard($user, $school),
            'accountant'  => redirect()->route('accountant.dashboard'),
            'librarian'   => view('dashboards.librarian.index'), // Placeholder
            default       => abort(403, 'Unauthorized Role'),
        };
    }

    /**
     * Logic for System Owner (Super Admin)
     */
    private function superAdminDashboard()
    {
        // 1. Total Institutions
        $schools = \App\Models\School::latest()->get();
        $totalSchools = $schools->count();

        // 2. Global Active Students (Count all students across all schools)
        $totalActiveStudents = \App\Models\Student::where('status', 'active')->count();

        // 3. Global Revenue (Sum of all approved subscription payments)
        $totalRevenue = \App\Models\SubscriptionPayment::where('status', 'approved')->sum('amount');

        // 4. System Health Data
        $nodesDown = \App\Models\School::where('status', 'suspended')->count();
        
        // 5. Recent System Activity (Mocking logs based on recent database events)
        $recentSchools = \App\Models\School::latest()->take(2)->get();
        $recentPayments = \App\Models\SubscriptionPayment::where('status', 'approved')->latest()->take(1)->get();

        return view('dashboards.super_admin', compact(
            'schools', 
            'totalSchools', 
            'totalActiveStudents', 
            'totalRevenue', 
            'nodesDown',
            'recentSchools',
            'recentPayments'
        ));
    }

    /**
     * Logic for School Principal (Admin)
     */
    private function schoolAdminDashboard($user, $school)
    {
        $school_id = $user->school_id;

        $totalStudents = Student::where('school_id', $school_id)->where('status', 'active')->count();
        $totalTeachers = Teacher::where('school_id', $school_id)->where('status', 'active')->count();
        $openCourses = TeacherAssignment::whereHas('teacher', function($q) use ($school_id) {
            $q->where('school_id', $school_id);
        })->count();
        
        // Pending Tasks logic
        $pendingPayments = StudentPayment::where('school_id', $school_id)->where('status', 'pending')->count();
        $pendingLinks = ChildLinkingRequest::where('school_id', $school_id)->where('status', 'pending')->count();
        $pendingTasks = $pendingPayments + $pendingLinks;

        // Finance Overview
        $totalCollected = StudentPayment::where('school_id', $school_id)
            ->where('status', 'approved')
            ->where('session', $school->current_session)
            ->sum('amount');

        $targetRevenue = 0;
        $classes = \App\Models\SchoolClass::where('school_id', $school_id)->withCount('students')->with('fees')->get();
        foreach($classes as $class) {
            $targetRevenue += ($class->students_count * $class->fees->sum('amount'));
        }
        $progressPercent = $targetRevenue > 0 ? round(($totalCollected / $targetRevenue) * 100) : 0;

        $recentAssignments = TeacherAssignment::whereHas('teacher', function($q) use ($school_id) {
            $q->where('school_id', $school_id);
        })->with(['teacher.user', 'subject', 'schoolClass'])->latest()->take(5)->get();

        return view('dashboards.admin', compact('totalStudents', 'totalTeachers', 'openCourses', 'pendingTasks', 'totalCollected', 'targetRevenue', 'progressPercent', 'recentAssignments', 'school'));
    }

    /**
     * Logic for Faculty Members (Teachers)
     */
    private function teacherDashboard($user, $school)
    {
        $teacher = $user->teacher;
        if (!$teacher) return view('dashboards.teacher.index', ['profileIncomplete' => true]);

        $today = now()->format('l');
        $currentTime = now()->format('H:i:s');

        // Stats
        $workload = TeacherAssignment::where('teacher_id', $teacher->id)->get();
        $assignedClassesCount = $workload->unique('school_class_id')->count();
        $assignedSubjectsCount = $workload->unique('subject_id')->count();
        $totalStudentsCount = Student::whereIn('school_class_id', $workload->pluck('school_class_id'))->where('status', 'active')->count();

        // Tasks
        $pendingTasks = AssignmentSubmission::whereHas('assignment', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->where('status', 'pending')->count();

        // Schedule Logic
        $todaySchedule = Timetable::where('teacher_id', $teacher->id)
            ->where('day', $today)
            ->with(['subject', 'schoolClass'])
            ->orderBy('start_time', 'asc')
            ->get();
        $nextSlot = $todaySchedule->where('start_time', '>', $currentTime)->first();

        $notices = Notice::where('school_id', $school->id)
            ->whereIn('target_audience', ['all', 'teachers', 'staff'])
            ->latest()->take(3)->get();

        return view('dashboards.teacher.index', compact('todaySchedule', 'assignedClassesCount', 'assignedSubjectsCount', 'totalStudentsCount', 'pendingTasks', 'nextSlot', 'notices'));
    }

    /**
     * Logic for Enrolled Learners (Students)
     */
    private function studentDashboard($user, $school)
    {
        $student = $user->student;
        if (!$student) return view('dashboards.student', ['profileIncomplete' => true]);

        $student->load('schoolClass');

        // Fees
        $classFeesTotal = ClassFee::where('school_class_id', $student->school_class_id)->sum('amount');
        $paidFeesTotal = StudentPayment::where('student_id', $student->id)->where('status', 'approved')->sum('amount');
        $balance = $classFeesTotal - $paidFeesTotal;

        // Directory & Notices
        $teachers = TeacherAssignment::where('school_class_id', $student->school_class_id)->with('teacher.user')->get()->unique('teacher_id')->take(3);
        $notices = Notice::where('school_id', $school->id)->whereIn('target_audience', ['all', 'students'])->latest()->take(3)->get();

        return view('dashboards.student', compact('student', 'balance', 'teachers', 'notices'));
    }

    /**
     * Logic for Guardians (Parents)
     */
    private function parentDashboard($user, $school)
    {
        $guardian = $user->guardian;
        if (!$guardian) return view('dashboards.parent.index', ['noProfile' => true]);

        $children = $guardian->students()->with(['user', 'schoolClass.fees'])->get();

        // Financial Calculation
        $grandTotalBill = 0;
        $grandTotalPaid = 0;
        foreach ($children as $child) {
            $grandTotalBill += $child->schoolClass->fees->sum('amount');
            $grandTotalPaid += StudentPayment::where('student_id', $child->id)->where('status', 'approved')->sum('amount');
        }
        $familyBalance = $grandTotalBill - $grandTotalPaid;

        $notices = Notice::where('school_id', $school->id)->whereIn('target_audience', ['all', 'parents'])->latest()->take(3)->get();

        return view('dashboards.parent.index', compact('children', 'familyBalance', 'notices'));
    }
}