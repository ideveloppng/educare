<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentPayment;
use App\Models\ClassFee;
use App\Models\SchoolBankDetail; // THE FIX: Import the Bank Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FeeController extends Controller
{
    /**
     * Display the Family Fees Overview
     */
    public function index()
    {
        $guardian = Auth::user()->guardian;
        if (!$guardian) return redirect()->route('dashboard');

        $school = Auth::user()->school;
        
        $children = $guardian->students()->with(['user', 'schoolClass.fees'])->get();

        $familyData = [];
        $grandTotalBill = 0;
        $grandTotalPaid = 0;

        foreach ($children as $child) {
            $childBill = $child->schoolClass->fees->sum('amount');
            $childPaid = StudentPayment::where('student_id', $child->id)
                ->where('session', $school->current_session)
                ->where('term', $school->current_term)
                ->where('status', 'approved')
                ->sum('amount');

            $familyData[] = [
                'student' => $child,
                'bill' => $childBill,
                'paid' => $childPaid,
                'balance' => $childBill - $childPaid
            ];

            $grandTotalBill += $childBill;
            $grandTotalPaid += $childPaid;
        }

        $grandBalance = $grandTotalBill - $grandTotalPaid;

        return view('dashboards.parent.fees.index', compact('familyData', 'grandTotalBill', 'grandTotalPaid', 'grandBalance'));
    }

    /**
     * Show the payment submission form for a specific child
     */
    public function pay(Student $student)
    {
        $guardian = Auth::user()->guardian;
        
        // Security: Ensure this student belongs to the parent
        if (!$guardian->students->contains($student->id)) {
            abort(403, 'Unauthorized access to student billing.');
        }

        // THE FIX: Fetch the active bank account for this school
        $activeBank = SchoolBankDetail::where('school_id', Auth::user()->school_id)
                        ->where('is_active', true)
                        ->first();

        return view('dashboards.parent.fees.pay', compact('student', 'activeBank'));
    }

    /**
     * Process the payment proof upload
     */
    public function submitPayment(Request $request, Student $student)
    {
        $guardian = Auth::user()->guardian;
        if (!$guardian->students->contains($student->id)) abort(403);

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $path = $request->file('proof')->store('payments/proofs', 'public');

        StudentPayment::create([
            'student_id' => $student->id,
            'school_id' => Auth::user()->school_id,
            'amount' => $request->amount,
            'session' => Auth::user()->school->current_session,
            'term' => Auth::user()->school->current_term,
            'reference' => 'PAR-' . strtoupper(Str::random(10)),
            'method' => 'bank_transfer',
            'proof_of_payment' => $path,
            'status' => 'pending'
        ]);

        return redirect()->route('parent.fees')->with('success', 'Payment proof submitted for verification.');
    }
}