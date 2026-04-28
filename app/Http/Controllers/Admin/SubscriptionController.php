<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\SubscriptionPayment;
use App\Models\BankDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    /**
     * Display the subscription management page for the school admin.
     */
    public function index()
    {
        // 1. Get the authenticated school
        $school = Auth::user()->school;

        // 2. Fetch all active subscription plans
        $plans = Plan::where('is_active', true)->get();

        // 3. Fetch the active bank account set by Super Admin
        $activeBank = BankDetail::where('is_active', true)->first();
        
        // 4. Calculate remaining days (Check paid subscription first, fallback to trial)
        $expiryDate = $school->subscription_expires_at ?? $school->trial_ends_at;
        
        // diffInDays returns negative if the date has passed, so we handle it
        $daysLeft = now()->diffInDays($expiryDate, false);
        $daysLeft = $daysLeft < 0 ? 0 : $daysLeft;

        // 5. Fetch recent payment history for this specific school
        $payments = SubscriptionPayment::where('school_id', $school->id)
            ->with('plan')
            ->latest()
            ->take(5)
            ->get();

        // 6. Return view with all required variables
        return view('dashboards.admin.subscription.index', compact(
            'school', 
            'plans', 
            'activeBank', 
            'daysLeft', 
            'expiryDate', 
            'payments'
        ));
    }

    /**
     * Store a new subscription payment proof.
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'amount' => 'required|numeric',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // 10MB Limit
        ]);

        // Handle File Upload
        $path = $request->file('proof')->store('subscriptions/proofs', 'public');

        SubscriptionPayment::create([
            'school_id' => Auth::user()->school_id,
            'plan_id' => $request->plan_id,
            'amount' => $request->amount,
            'transaction_id' => 'SUB-' . strtoupper(Str::random(10)),
            'proof_of_payment' => $path,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your payment proof has been uploaded. The system owner will verify it and activate your plan shortly.');
    }
}