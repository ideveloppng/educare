<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LedgerController extends Controller
{
    /**
     * Display the General Ledger with filters
     */
    public function index(Request $request)
    {
        $school_id = Auth::user()->school_id;

        $query = Transaction::where('school_id', $school_id);

        // Filter by Type (Income/Expense) if selected
        if ($request->type) {
            $query->where('type', $request->type);
        }

        $transactions = $query->latest()->paginate(15);

        // Calculate Totals for the header
        $income = Transaction::where('school_id', $school_id)->where('type', 'income')->sum('amount');
        $expense = Transaction::where('school_id', $school_id)->where('type', 'expense')->sum('amount');
        $balance = $income - $expense;

        return view('dashboards.accountant.ledger.index', compact('transactions', 'income', 'expense', 'balance'));
    }

    /**
     * Store a new transaction
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        Transaction::create([
            'school_id' => Auth::user()->school_id,
            'type' => $request->type,
            'title' => strtoupper($request->title),
            'category' => strtoupper($request->category),
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description
        ]);

        return back()->with('success', 'Transaction successfully recorded in ledger.');
    }

    /**
     * Delete a transaction
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->school_id !== Auth::user()->school_id) abort(403);
        
        $transaction->delete();
        return back()->with('success', 'Transaction removed from ledger.');
    }
}