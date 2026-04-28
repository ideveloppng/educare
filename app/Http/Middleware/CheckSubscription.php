<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // 1. Super Admins have total access regardless of any school status
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        // 2. If the user is a School Admin, Teacher, or Student
        if ($user->school) {
            // Check the method we just added to the School Model
            if (!$user->school->hasActiveSubscription()) {
                
                // If the subscription is expired, and they aren't already on the billing page
                // We redirect them to pay
                if (!$request->is('billing*') && !$request->is('logout')) {
                    return redirect()->route('billing.index')->with('error', 'Your school trial or subscription has expired.');
                }
            }
        }

        return $next($request);
    }
}