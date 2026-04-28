<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::where('school_id', auth()->user()->school_id)
            ->with('user')
            ->whereHas('user', function($q) {
                $q->whereIn('role', ['accountant', 'librarian']);
            })
            ->latest()->paginate(10);
            
        return view('dashboards.admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('dashboards.admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:accountant,librarian', // Selectable roles
            'phone' => 'required',
            'designation' => 'required|string',
            'base_salary' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request) {
            $school_id = auth()->user()->school_id;

            // 1. Create User with selected role
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('staff123'),
                'role' => $request->role, 
                'school_id' => $school_id,
            ]);

            // 2. Generate Staff ID
            $count = Staff::where('school_id', $school_id)->count() + 1;
            $staffId = "STF/" . date('Y') . "/" . str_pad($count, 3, '0', STR_PAD_LEFT);

            // 3. Create Profile
            Staff::create([
                'user_id' => $user->id,
                'school_id' => $school_id,
                'staff_id' => $staffId,
                'phone' => $request->phone,
                'designation' => strtoupper($request->designation),
                'employment_date' => $request->employment_date ?? now(),
                'base_salary' => $request->base_salary,
            ]);
        });

        return redirect()->route('admin.staff.index')->with('success', 'Non-academic staff member registered.');
    }
}