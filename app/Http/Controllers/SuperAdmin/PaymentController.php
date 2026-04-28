<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPayment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index()
    {
        // Fetch all payments with school and plan info
        $payments = SubscriptionPayment::with(['school', 'plan'])->latest()->paginate(15);
        return view('dashboards.super_admin.payments.index', compact('payments'));
    }

    public function updateStatus(Request $request, SubscriptionPayment $payment)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string'
        ]);

        $school = $payment->school;
        $plan = $payment->plan;

        if ($request->status === 'approved' && $payment->status !== 'approved') {
            
            // 1. Determine the starting point for the extension
            // If current sub is still active, start from the future expiry. 
            // If expired, start from today.
            $currentExpiry = ($school->subscription_expires_at && $school->subscription_expires_at->isFuture()) 
                ? Carbon::parse($school->subscription_expires_at) 
                : now();

            // 2. Add the months from the plan (e.g., 3 months)
            $newExpiry = $currentExpiry->addMonths($plan->duration_months);

            // 3. Update the School record
            $school->update([
                'subscription_expires_at' => $newExpiry,
                'plan' => $plan->slug, // e.g., '1_year'
                'status' => 'active'
            ]);
        }

        // 4. Update the Payment record
        $payment->update([
            'status' => $request->status,
            'admin_notes' => $request->notes
        ]);

        return back()->with('success', 'Payment ' . ucfirst($request->status) . '. School subscription updated.');
    }
}