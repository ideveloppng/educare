<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SupportContact;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        $contacts = SupportContact::latest()->get();
        return view('dashboards.super_admin.support.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required',
            'value' => 'required',
            'link' => 'required|url',
        ]);

        SupportContact::create($request->all());
        return back()->with('success', 'Support channel added successfully.');
    }

    public function update(Request $request, SupportContact $support)
    {
        $support->update($request->all());
        return back()->with('success', 'Support channel updated.');
    }

    public function destroy(SupportContact $support)
    {
        $support->delete();
        return back()->with('success', 'Support channel removed.');
    }
}