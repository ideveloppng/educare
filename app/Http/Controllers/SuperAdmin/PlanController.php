<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::latest()->get();
        return view('dashboards.super_admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('dashboards.super_admin.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:plans,name',
            'price' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Plan::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'duration_months' => $request->duration_months,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('super_admin.plans.index')->with('success', 'New subscription plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        return view('dashboards.super_admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:plans,name,' . $plan->id,
            'price' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $plan->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'duration_months' => $request->duration_months,
            'description' => $request->description,
        ]);

        return redirect()->route('super_admin.plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('super_admin.plans.index')->with('success', 'Plan deleted successfully.');
    }
}