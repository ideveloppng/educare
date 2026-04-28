<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    /**
     * Display the Faculty Directory (Registry)
     */
    public function index()
    {
        $school_id = auth()->user()->school_id;

        // Fetch teachers for this school with their linked user and assignments
        $teachers = Teacher::where('school_id', $school_id)
            ->with(['user', 'assignments.schoolClass', 'assignments.subject'])
            ->latest()
            ->paginate(10);
            
        return view('dashboards.admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the Staff Recruitment Form
     */
    public function create()
    {
        $school_id = auth()->user()->school_id;
        
        // Fetch academic data for initial reference if needed
        $classes = SchoolClass::where('school_id', $school_id)->get();
        $subjects = Subject::where('school_id', $school_id)->get();
        
        return view('dashboards.admin.teachers.create', compact('classes', 'subjects'));
    }

    /**
     * Store a newly recruited staff member
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:male,female',
            'qualification' => 'required|string|max:255',
            'employment_date' => 'required|date',
            'base_salary' => 'required|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // 10MB Max
        ]);

        DB::transaction(function () use ($request) {
            $school_id = auth()->user()->school_id;

            // 1. Handle Profile Photo Upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('teachers/photos', 'public');
            }

            // 2. Create the User Account for Portal Login
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('teacher123'), // Default password
                'role' => 'teacher',
                'school_id' => $school_id,
            ]);

            // 3. Generate a Unique Staff ID (Format: TCH/Year/Sequence)
            $count = Teacher::where('school_id', $school_id)->count() + 1;
            $staffId = "TCH/" . date('Y') . "/" . str_pad($count, 3, '0', STR_PAD_LEFT);

            // 4. Create the Teacher Profile
            Teacher::create([
                'user_id' => $user->id,
                'school_id' => $school_id,
                'staff_id' => $staffId,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'qualification' => $request->qualification,
                'employment_date' => $request->employment_date,
                'base_salary' => $request->base_salary,
                'photo' => $photoPath,
                'status' => 'active',
            ]);
        });

        return redirect()->route('admin.teachers')->with('success', 'Teacher registered successfully. Login credentials generated.');
    }

    /**
     * Display the detailed Faculty Member Profile
     */
    public function show(Teacher $teacher)
    {
        // Security: Ensure Admin only sees staff from their own school
        if ($teacher->school_id !== auth()->user()->school_id) {
            abort(403, 'Unauthorized access to faculty records.');
        }

        // Load assignments so we can show the workload in the profile view
        $teacher->load(['user', 'assignments.schoolClass', 'assignments.subject']);

        return view('dashboards.admin.teachers.show', compact('teacher'));
    }

    /**
     * Update Portal Access Status (Suspend/Activate)
     */
    public function toggleStatus(Teacher $teacher)
    {
        if ($teacher->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        // Flip the status
        $teacher->status = ($teacher->status === 'active') ? 'suspended' : 'active';
        $teacher->save();

        $message = ($teacher->status === 'active') 
            ? "Portal access restored for {$teacher->user->name}." 
            : "Access suspended for {$teacher->user->name}.";

        return back()->with('success', $message);
    }

    /**
     * Permanently remove a teacher from the registry
     */
    public function destroy(Teacher $teacher)
    {
        if ($teacher->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        // Remove the photo from storage if it exists
        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }

        // Delete the User record (the Teacher profile will cascade delete)
        $teacher->user->delete();

        return redirect()->route('admin.teachers')->with('success', 'Staff record and associated data permanently removed.');
    }
}