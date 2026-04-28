<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolBankDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    /**
     * Display the System Settings page.
     * Fetches current school data and its associated bank accounts.
     */
    public function index()
    {
        $school = Auth::user()->school;

        // EMERGENCY FIX: Generate registration key if it is missing in the database
        if (empty($school->reg_key)) {
            $school->reg_key = Str::random(32);
            $school->save();
        }

        // Fetch all bank accounts created by this school
        $banks = SchoolBankDetail::where('school_id', $school->id)
            ->latest()
            ->get();

        return view('dashboards.admin.settings.index', compact('school', 'banks'));
    }

    /**
     * Update Global Academic Timeline (Session & Term).
     */
    public function updateAcademic(Request $request)
    {
        $request->validate([
            'current_session' => 'required|string|max:255',
            'current_term' => 'required|string|max:255',
        ]);

        $school = Auth::user()->school;
        
        $school->update([
            'current_session' => $request->current_session,
            'current_term' => $request->current_term,
        ]);

        return back()->with('success', 'Academic settings have been updated across the system.');
    }

    /**
     * Update the visibility and availability of Self-Registration links.
     */
    public function updateRegStatus(Request $request)
    {
        $school = Auth::user()->school;

        // Note: HTML Checkboxes are only present in the request if they are checked.
        // We use $request->has() to determine if the status should be true or false.
        $school->update([
            'student_reg_active' => $request->has('student_reg_active'),
            'teacher_reg_active' => $request->has('teacher_reg_active'),
            'staff_reg_active' => $request->has('staff_reg_active'),
            'parent_reg_active' => $request->has('parent_reg_active'),
        ]);

        return back()->with('success', 'Self-registration permissions have been updated.');
    }

    /**
     * Store a new school bank account for fee collection.
     */
    public function storeBank(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|digits_between:10,12',
            'account_name' => 'required|string|max:255',
        ]);

        SchoolBankDetail::create([
            'school_id' => Auth::user()->school_id,
            'bank_name' => strtoupper($request->bank_name),
            'account_number' => $request->account_number,
            'account_name' => strtoupper($request->account_name),
            'is_active' => true,
        ]);

        return back()->with('success', 'New bank account added for fee collection.');
    }

    /**
     * Toggle the status of a specific bank account (Active/Inactive).
     */
    public function toggleBank(SchoolBankDetail $bank)
    {
        // Security check: Ensure the bank belongs to the admin's school
        if ($bank->school_id !== Auth::user()->school_id) {
            abort(403, 'Unauthorized action.');
        }

        $bank->update([
            'is_active' => !$bank->is_active
        ]);

        $status = $bank->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "The bank account has been $status.");
    }

    /**
     * Delete a specific school bank account.
     */
    public function destroyBank(SchoolBankDetail $bank)
    {
        // Security check
        if ($bank->school_id !== Auth::user()->school_id) {
            abort(403, 'Unauthorized action.');
        }

        $bank->delete();

        return back()->with('success', 'Bank account permanently removed.');
    }
}