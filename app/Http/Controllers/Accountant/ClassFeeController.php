<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Auth;

class ClassFeeController extends Controller
{
    /**
     * Display the official fee structure for the school
     */
    public function index()
    {
        $school_id = Auth::user()->school_id;

        // Fetch all classes with their specific fee items
        $classes = SchoolClass::where('school_id', $school_id)
            ->with('fees')
            ->get();

        return view('dashboards.accountant.fees.index', compact('classes'));
    }
}