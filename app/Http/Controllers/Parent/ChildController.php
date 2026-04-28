<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
{
    public function index()
    {
        $guardian = Auth::user()->guardian;

        if (!$guardian) {
            return view('dashboards.parent.children.index', ['children' => collect()]);
        }

        // Fetch children with their class and basic relationships
        $children = $guardian->students()->with(['user', 'schoolClass'])->get();

        return view('dashboards.parent.children.index', compact('children'));
    }

    public function requestLink(Request $request)
    {
        $request->validate([
            'admission_number' => 'required|string',
        ]);

        $user = auth()->user();
        
        // Check if student exists in this school
        $student = \App\Models\Student::where('admission_number', $request->admission_number)
                    ->where('school_id', $user->school_id)
                    ->first();

        if (!$student) {
            return back()->with('error', 'No student found with that Admission Number in this school.');
        }

        // Check if already linked
        if ($user->guardian->students->contains($student->id)) {
            return back()->with('error', 'This child is already linked to your account.');
        }

        \App\Models\ChildLinkingRequest::create([
            'guardian_id' => $user->guardian->id,
            'school_id' => $user->school_id,
            'admission_number' => $request->admission_number,
            'student_name' => $student->user->name,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Linking request submitted. The Admin will verify and approve it shortly.');
    }
}