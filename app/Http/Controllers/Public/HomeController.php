<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch active plans for the pricing section
        $plans = Plan::where('is_active', true)->orderBy('duration_months', 'asc')->get();
        return view('welcome', compact('plans'));
    }
}