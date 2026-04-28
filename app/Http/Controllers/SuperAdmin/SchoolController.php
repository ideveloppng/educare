<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::latest()->paginate(10);
        return view('dashboards.super_admin.schools.index', compact('schools'));
    }

    public function create()
    {
        return view('dashboards.super_admin.schools.create');
    }

    // (Store method remains as previously written, ensure it handles logo)

    public function edit(School $school)
    {
        return view('dashboards.super_admin.schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|unique:schools,name,' . $school->id,
            'email' => 'required|email|unique:schools,email,' . $school->id,
            'phone' => 'required',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address', 'plan']);
        
        if ($request->hasFile('logo')) {
            if ($school->logo) { Storage::disk('public')->delete($school->logo); }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $school->update($data);

        return redirect()->route('schools.index')->with('success', 'School updated successfully.');
    }

    public function toggleStatus(School $school)
    {
        $school->status = ($school->status === 'active') ? 'suspended' : 'active';
        $school->save();

        return back()->with('success', 'School status changed to ' . $school->status);
    }

    public function destroy(School $school)
    {
        // Delete logo file if exists
        if ($school->logo) { Storage::disk('public')->delete($school->logo); }
        
        // This will also delete users due to 'onDelete(cascade)' in migration
        $school->delete();

        return redirect()->route('schools.index')->with('success', 'School and all associated data deleted.');
    }

    public function show(School $school)
    {
        // Fetch counts for all personas in this school
        $stats = [
            'students' => $school->students()->count(),
            'teachers' => $school->teachers()->count(),
            'staff'    => $school->staff()->count(),
            'parents'  => $school->guardians()->count(),
        ];

        // Fetch the school admin user details
        $admin = \App\Models\User::where('school_id', $school->id)
                    ->where('role', 'admin')
                    ->first();

        return view('dashboards.super_admin.schools.show', compact('school', 'stats', 'admin'));
    }
}