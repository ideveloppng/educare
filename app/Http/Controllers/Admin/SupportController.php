<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportContact;

class SupportController extends Controller
{
    public function index()
    {
        $contacts = SupportContact::where('is_active', true)->get();
        return view('dashboards.admin.support.index', compact('contacts'));
    }
}