<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\StudentPayment;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class AccountantDashboardController extends Controller
{
    public function index()
    {
        $school_id = Auth::user()->school_id;

        // Fetch data for the dashboard
        $totalIncome = Transaction::where('school_id', $school_id)->where('type', 'income')->sum('amount');
        $totalExpenses = Transaction::where('school_id', $school_id)->where('type', 'expense')->sum('amount');
        $pendingFees = StudentPayment::where('school_id', $school_id)->where('status', 'pending')->count();
        $monthlyPayroll = Teacher::where('school_id', $school_id)->sum('base_salary');

        return view('dashboards.accountant.index', compact('totalIncome', 'totalExpenses', 'pendingFees', 'monthlyPayroll'));
    }
}