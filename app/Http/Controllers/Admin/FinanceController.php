<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassFee;
use App\Models\Transaction; // Updated from Expense
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    /**
     * Finance Overview Dashboard
     */
    public function index()
    {
        $school_id = Auth::user()->school_id;

        // 1. Calculate Totals from the General Ledger (Transactions Table)
        $totalIncome = Transaction::where('school_id', $school_id)->where('type', 'income')->sum('amount');
        $totalExpenses = Transaction::where('school_id', $school_id)->where('type', 'expense')->sum('amount');
        
        // 2. Calculate Monthly Payroll commitment
        $monthlyPayroll = Teacher::where('school_id', $school_id)->sum('base_salary');

        // 3. Net Cashflow (Income - Expenses)
        $netCashflow = $totalIncome - $totalExpenses;

        // 4. Recent Ledger Activity
        $recentActivity = Transaction::where('school_id', $school_id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.admin.finance.index', compact(
            'totalExpenses', 
            'monthlyPayroll', 
            'totalIncome', 
            'netCashflow', 
            'recentActivity'
        ));
    }

    /**
     * Master List of Class Fees
     */
    public function classFees()
    {
        $school_id = Auth::user()->school_id;
        
        $classes = SchoolClass::where('school_id', $school_id)
            ->with('fees')
            ->get();

        return view('dashboards.admin.finance.fees', compact('classes'));
    }

    /**
     * Detailed Itemized Fees for a Specific Class
     */
    public function showFees(SchoolClass $class)
    {
        if ($class->school_id !== Auth::user()->school_id) abort(403);

        $class->load('fees');
        return view('dashboards.admin.finance.fees-show', compact('class'));
    }

    /**
     * Store a new fee item
     */
    public function storeFee(Request $request)
    {
        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0'
        ]);

        ClassFee::create([
            'school_id' => Auth::user()->school_id,
            'school_class_id' => $request->school_class_id,
            'title' => strtoupper($request->title),
            'amount' => $request->amount
        ]);

        return back()->with('success', 'Fee item added successfully.');
    }

    /**
     * Update an individual fee item
     */
    public function updateFeeItem(Request $request, ClassFee $fee)
    {
        if ($fee->school_id !== Auth::user()->school_id) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0'
        ]);

        $fee->update([
            'title' => strtoupper($request->title),
            'amount' => $request->amount
        ]);

        return back()->with('success', 'Fee item updated.');
    }

    /**
     * Delete a fee item
     */
    public function destroyFee(ClassFee $fee)
    {
        if ($fee->school_id !== Auth::user()->school_id) abort(403);
        $fee->delete();
        return back()->with('success', 'Fee item removed.');
    }

    /**
     * General Ledger View (Transactions)
     */
    public function ledger()
    {
        $transactions = Transaction::where('school_id', Auth::user()->school_id)
            ->latest()
            ->paginate(15);

        return view('dashboards.admin.finance.ledger', compact('transactions'));
    }

    /**
     * Staff Payroll Overview
     */
    public function payroll()
    {
        $school_id = auth()->user()->school_id;

        // Fetch all teachers for this school
        $teachers = \App\Models\Teacher::where('school_id', $school_id)
            ->with('user')
            ->latest()
            ->get();

        // Calculate total
        $totalPayroll = $teachers->sum('base_salary');

        return view('dashboards.admin.finance.payroll', compact('teachers', 'totalPayroll'));
    }
}