<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\StudentPayment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeeCollectionController extends Controller
{
    public function index()
    {
        $school_id = Auth::user()->school_id;

        // Fetch all payments (Pending first, then by date)
        $payments = StudentPayment::where('school_id', $school_id)
            ->with(['student.user', 'student.schoolClass'])
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->latest()
            ->paginate(15);

        return view('dashboards.accountant.collections.index', compact('payments'));
    }

    public function verify(Request $request, StudentPayment $payment)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        if ($payment->school_id !== Auth::user()->school_id) abort(403);

        DB::transaction(function () use ($request, $payment) {
            $payment->update([
                'status' => $request->status,
                'admin_notes' => $request->admin_notes
            ]);

            // If approved, automatically record it in the General Ledger (Transactions)
            if ($request->status === 'approved') {
                Transaction::create([
                    'school_id' => $payment->school_id,
                    'type' => 'income',
                    'title' => "FEE PAYMENT: " . $payment->student->user->name,
                    'category' => 'Tuition Fees',
                    'amount' => $payment->amount,
                    'date' => now(),
                    'description' => "Verified reference: " . $payment->reference
                ]);
            }
        });

        return back()->with('success', 'Payment status updated and ledger synchronized.');
    }
}