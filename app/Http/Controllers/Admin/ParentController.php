<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    public function index()
    {
        $school_id = auth()->user()->school_id;
        $parents = Guardian::where('school_id', $school_id)
            ->with(['user', 'students.user'])
            ->latest()->paginate(15);

        return view('dashboards.admin.parents.index', compact('parents'));
    }

    public function create()
    {
        return view('dashboards.admin.parents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:guardians,phone',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('parent123'),
                'role' => 'parent',
                'school_id' => auth()->user()->school_id,
            ]);

            Guardian::create([
                'user_id' => $user->id,
                'school_id' => auth()->user()->school_id,
                'phone' => $request->phone,
                'occupation' => $request->occupation,
                'address' => $request->address,
            ]);
        });

        return redirect()->route('admin.parents')->with('success', 'Parent account created.');
    }

    public function linkStudent(Request $request, Guardian $parent)
    {
        $request->validate(['student_id' => 'required|exists:students,id']);
        
        // Prevent duplicate linking
        $parent->students()->syncWithoutDetaching([$request->student_id]);

        return back()->with('success', 'Child linked to parent successfully.');
    }

    public function showRequests()
    {
        $requests = \App\Models\ChildLinkingRequest::where('school_id', auth()->user()->school_id)
                    ->where('status', 'pending')
                    ->with('guardian.user')
                    ->latest()->get();
        return view('dashboards.admin.parents.requests', compact('requests'));
    }

    public function processRequest(Request $request, $id)
    {
        $linkReq = \App\Models\ChildLinkingRequest::findOrFail($id);
        $student = \App\Models\Student::where('admission_number', $linkReq->admission_number)->first();

        if ($request->action === 'approve') {
            $linkReq->guardian->students()->syncWithoutDetaching([$student->id]);
            $linkReq->update(['status' => 'approved']);
            return back()->with('success', 'Child successfully linked to parent.');
        }

        $linkReq->update(['status' => 'rejected', 'admin_notes' => $request->reason]);
        return back()->with('success', 'Request rejected.');
    }
}