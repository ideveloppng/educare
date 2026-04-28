<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/* Import Models */
use App\Models\Notice;
use App\Models\StudentPayment;

class ParentDashboardController extends Controller
{
    /**
     * Display the Parent Analytics Dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $school = $user->school;
        
        // 1. Fetch the guardian profile linked to this user
        $guardian = $user->guardian;

        // 2. If the guardian record is missing entirely
        if (!$guardian) {
            return view('dashboards.parent.index', [
                'children' => collect(),
                'notices' => collect(),
                'familyBalance' => 0,
                'noProfile' => true 
            ]);
        }

        // 3. Fetch children through the pivot table with relationships
        $children = $guardian->students()->with(['user', 'schoolClass.fees'])->get();

        // 4. Calculate Financial Analytics (Family Balance)
        $grandTotalBill = 0;
        $grandTotalPaid = 0;

        foreach ($children as $child) {
            // Sum all fees for the child's class
            $grandTotalBill += $child->schoolClass->fees->sum('amount');
            
            // Sum all approved payments for this child in current session
            $grandTotalPaid += StudentPayment::where('student_id', $child->id)
                ->where('school_id', $school->id)
                ->where('status', 'approved')
                ->where('session', $school->current_session)
                ->sum('amount');
        }

        $familyBalance = $grandTotalBill - $grandTotalPaid;

        // 5. Fetch Recent School Notices
        $notices = Notice::where('school_id', $school->id)
            ->whereIn('target_audience', ['all', 'parents'])
            ->latest()
            ->take(3)
            ->get();

        // 6. Check if guardian exists but has 0 children linked
        $noChildrenLinked = $children->isEmpty();

        return view('dashboards.parent.index', compact(
            'children', 
            'familyBalance', 
            'notices', 
            'noChildrenLinked'
        ));
    }
}