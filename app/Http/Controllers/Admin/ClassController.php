<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function index()
    {
        // Only fetch classes belonging to the logged-in admin's school
        $classes = SchoolClass::where('school_id', Auth::user()->school_id)
            ->latest()
            ->get();
            
        return view('dashboards.admin.classes.index', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:255',
            'max_capacity' => 'required|integer|min:1',
        ]);

        \App\Models\SchoolClass::create([
            'school_id' => auth()->user()->school_id,
            'name' => $request->name,
            'section' => $request->section,
            'max_capacity' => $request->max_capacity,
        ]);

        return back()->with('success', 'New class created successfully.');
    }

    public function destroy(SchoolClass $class)
    {
        // Security check: Ensure the admin owns this class
        if ($class->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $class->delete();
        return back()->with('success', 'Class deleted successfully.');
    }
}