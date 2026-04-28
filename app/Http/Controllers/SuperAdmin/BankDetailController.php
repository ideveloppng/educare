<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use Illuminate\Http\Request;

class BankDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
            'account_name' => 'required|string|max:255',
        ]);

        BankDetail::create($request->all());
        return back()->with('success', 'Bank details added successfully.');
    }

    public function update(Request $request, BankDetail $bank)
    {
        $bank->update($request->all());
        return back()->with('success', 'Bank details updated.');
    }

    public function destroy(BankDetail $bank)
    {
        $bank->delete();
        return back()->with('success', 'Bank details removed.');
    }

    public function toggle(BankDetail $bank)
    {
        $bank->update(['is_active' => !$bank->is_active]);
        return back()->with('success', 'Status toggled.');
    }
}