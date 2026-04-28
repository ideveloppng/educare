<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display the Student Registry (List)
     */
    public function index(Request $request)
    {
        $school_id = auth()->user()->school_id;
        
        // Query students belonging to this school with relationships
        $query = Student::where('school_id', $school_id)->with(['user', 'schoolClass']);
        
        // Filter by class if selected in the UI
        if ($request->class_id) {
            $query->where('school_class_id', $request->class_id);
        }

        $students = $query->latest()->paginate(15);
        $classes = SchoolClass::where('school_id', $school_id)->get();

        return view('dashboards.admin.students.index', compact('students', 'classes'));
    }

    /**
     * Show the Admission Form (THE MISSING METHOD)
     */
    public function create()
    {
        $classes = SchoolClass::where('school_id', auth()->user()->school_id)->get();
        return view('dashboards.admin.students.create', compact('classes'));
    }

    /**
     * Store a newly admitted student
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'school_class_id' => 'required|exists:school_classes,id',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // 10MB Max
        ]);

        DB::transaction(function () use ($request) {
            $school_id = auth()->user()->school_id;

            // 1. Handle Photo Upload
            $photoPath = null;
            if ($request->hasFile('student_photo')) {
                $photoPath = $request->file('student_photo')->store('students/photos', 'public');
            }

            // 2. Create User Account (Login credentials)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('student123'),
                'role' => 'student',
                'school_id' => $school_id,
            ]);

            // 3. Generate Unique Admission Number
            $count = Student::where('school_id', $school_id)->count() + 1;
            $adNo = "ADM/" . date('Y') . "/" . str_pad($count, 3, '0', STR_PAD_LEFT);

            // 4. Create Detailed Student Profile
            Student::create([
                'user_id' => $user->id,
                'school_id' => $school_id,
                'school_class_id' => $request->school_class_id,
                'admission_number' => $adNo,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'parent_phone' => $request->parent_phone,
                'address' => $request->address,
                'student_photo' => $photoPath,
            ]);
        });

        return redirect()->route('admin.students')->with('success', 'Student admitted successfully!');
    }

    /**
     * View Student Profile
     */
    public function show(Student $student)
    {
        if ($student->school_id !== auth()->user()->school_id) abort(403);
        return view('dashboards.admin.students.show', compact('student'));
    }

    /**
     * Show Edit Form
     */
    public function edit(Student $student)
    {
        if ($student->school_id !== auth()->user()->school_id) abort(403);
        $classes = SchoolClass::where('school_id', auth()->user()->school_id)->get();
        return view('dashboards.admin.students.edit', compact('student', 'classes'));
    }

    /**
     * Update Student Profile
     */
    public function update(Request $request, Student $student)
    {
        if ($student->school_id !== auth()->user()->school_id) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'school_class_id' => 'required|exists:school_classes,id',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        DB::transaction(function () use ($request, $student) {
            // Update User record
            $student->user->update(['name' => $request->name]);

            // Handle Photo Replacement
            $photoPath = $student->student_photo;
            if ($request->hasFile('student_photo')) {
                if ($photoPath) Storage::disk('public')->delete($photoPath);
                $photoPath = $request->file('student_photo')->store('students/photos', 'public');
            }

            // Update Profile record
            $student->update([
                'school_class_id' => $request->school_class_id,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'parent_phone' => $request->parent_phone,
                'address' => $request->address,
                'student_photo' => $photoPath,
            ]);
        });

        return redirect()->route('admin.students.show', $student)->with('success', 'Profile updated.');
    }

    /**
     * Suspend or Activate Student
     */
    public function toggleStatus(Student $student)
    {
        if ($student->school_id !== auth()->user()->school_id) abort(403);

        $student->status = ($student->status === 'active') ? 'suspended' : 'active';
        $student->save();

        return back()->with('success', 'Student access status updated.');
    }

    /**
     * Delete Student Permanently
     */
    public function destroy(Student $student)
    {
        if ($student->school_id !== auth()->user()->school_id) abort(403);

        if ($student->student_photo) {
            Storage::disk('public')->delete($student->student_photo);
        }

        // Deleting the user will cascade delete the student record
        $student->user->delete();

        return redirect()->route('admin.students')->with('success', 'Student removed from system.');
    }
}