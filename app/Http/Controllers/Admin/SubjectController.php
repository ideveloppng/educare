<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        $school_id = auth()->user()->school_id;

        // Fetch subjects with their linked classes
        $subjects = Subject::where('school_id', $school_id)
            ->with('classes')
            ->latest()
            ->get();

        // Fetch all classes so we can show them in the "Add Subject" form
        $classes = \App\Models\SchoolClass::where('school_id', $school_id)->get();

        return view('dashboards.admin.subjects.index', compact('subjects', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject_code' => 'nullable|string|max:50',
            'class_ids' => 'required|array', // Ensure at least one class is selected
        ]);

        $subject = Subject::create([
            'school_id' => auth()->user()->school_id,
            'name' => $request->name,
            'subject_code' => $request->subject_code,
        ]);

        // This links the subject to the selected classes in the pivot table
        $subject->classes()->attach($request->class_ids);

        return back()->with('success', 'Subject created and assigned to classes.');
    }

    public function destroy(Subject $subject)
    {
        if ($subject->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $subject->delete();
        return back()->with('success', 'Subject removed successfully.');
    }
}