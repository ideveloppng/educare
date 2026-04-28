<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payroll;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $school_id = Auth::user()->school_id;
        $month = $request->month ?? now()->format('F');
        $year = $request->year ?? now()->format('Y');

        // Fetch all staff and teachers with their base salaries
        // We join both tables to get a unified list
        $employees = User::where('school_id', $school_id)
            ->whereIn('role', ['teacher', 'accountant', 'librarian'])
            ->with(['teacher', 'staff'])
            ->get()
            ->map(function($user) use ($month, $year) {
                // Get salary from whichever profile exists
                $user->base_salary = $user->teacher ? $user->teacher->base_salary : ($user->staff ? $user->staff->base_salary : 0);
                
                // Check if already paid for this specific month
                $user->is_paid = Payroll::where('user_id', $user->id)
                    ->where('month', $month)
                    ->where('year', $year)
                    ->exists();
                return $user;
            });

        $totalPayroll = $employees->sum('base_salary');
        $paidAmount = Payroll::where('school_id', $school_id)->where('month', $month)->where('year', $year)->sum('amount');

        return view('dashboards.accountant.payroll.index', compact('employees', 'totalPayroll', 'paidAmount', 'month', 'year'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'month' => 'required',
            'year' => 'required',
            'gross_amount' => 'required|numeric',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            // Sum Allowances
            $totalAllowances = $request->housing + $request->feeding + $request->transport + $request->medical;
            
            // Sum Deductions
            $totalDeductions = $request->tax + $request->pension + $request->union + $request->cooperative;

            // Net Pay = (Gross + Allowances) - Deductions
            $netPay = ($request->gross_amount + $totalAllowances) - $totalDeductions;

            \App\Models\Payroll::create([
                'school_id' => auth()->user()->school_id,
                'user_id' => $request->user_id,
                'month' => $request->month,
                'year' => $request->year,
                'gross_amount' => $request->gross_amount,
                'tax_deduction' => $request->tax,
                'pension_deduction' => $request->pension,
                'union_dues' => $request->union,
                'cooperative_deduction' => $request->cooperative,
                'housing_allowance' => $request->housing,
                'feeding_allowance' => $request->feeding,
                'transport_allowance' => $request->transport,
                'medical_benefit' => $request->medical,
                'amount' => $netPay,
                'payment_date' => now(),
                'reference' => 'PAY-' . strtoupper(\Illuminate\Support\Str::random(10))
            ]);

            // Record in Ledger
            \App\Models\Transaction::create([
                'school_id' => auth()->user()->school_id,
                'type' => 'expense',
                'title' => "PAYROLL: " . \App\Models\User::find($request->user_id)->name,
                'category' => 'SALARIES',
                'amount' => $netPay,
                'date' => now(),
            ]);
        });

        return back()->with('success', 'Payslip generated successfully.');
    }
}