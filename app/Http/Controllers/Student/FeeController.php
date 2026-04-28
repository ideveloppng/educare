<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassFee;
use App\Models\StudentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FeeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;
        $school = $user->school;

        $classFees = ClassFee::where('school_class_id', $student->school_class_id)->get();
        $totalBill = $classFees->sum('amount');

        // Fetch only approved payments for the balance calculation
        $payments = StudentPayment::where('student_id', $student->id)
            ->where('session', $school->current_session)
            ->where('term', $school->current_term)
            ->latest()
            ->get();

        $totalPaid = $payments->where('status', 'approved')->sum('amount');
        $balance = $totalBill - $totalPaid;

        return view('dashboards.student.fees.index', compact('classFees', 'totalBill', 'payments', 'totalPaid', 'balance'));
    }

    public function pay()
    {
        $activeBank = \App\Models\SchoolBankDetail::where('school_id', auth()->user()->school_id)
                        ->where('is_active', true)->first();
        return view('dashboards.student.fees.pay', compact('activeBank'));
    }

    public function submitPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB Max
        ]);

        $user = Auth::user();
        
        // Handle File Upload
        $path = $request->file('proof')->store('payments/proofs', 'public');

        StudentPayment::create([
            'student_id' => $user->student->id,
            'school_id' => $user->school_id,
            'amount' => $request->amount,
            'session' => $user->school->current_session,
            'term' => $user->school->current_term,
            'reference' => 'PAY-' . strtoupper(Str::random(10)),
            'method' => 'bank_transfer',
            'proof_of_payment' => $path,
            'status' => 'pending'
        ]);

        return redirect()->route('student.fees')->with('success', 'Payment proof uploaded successfully. Awaiting verification.');
    }
}