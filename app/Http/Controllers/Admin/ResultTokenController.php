<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResultToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ResultTokenController extends Controller
{
    public function index()
    {
        $school_id = auth()->user()->school_id;
        $tokens = ResultToken::where('school_id', $school_id)->with('student.user')->latest()->paginate(20);
        $batches = ResultToken::where('school_id', $school_id)->select('batch_number', DB::raw('count(*) as total'))->groupBy('batch_number')->get();

        return view('dashboards.admin.tokens.index', compact('tokens', 'batches'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'count' => 'required|integer|min:1|max:100',
        ]);

        $school_id = auth()->user()->school_id;
        $batch = 'BCH-' . strtoupper(Str::random(6));

        for ($i = 0; $i < $request->count; $i++) {
            ResultToken::create([
                'school_id' => $school_id,
                'serial_number' => 'SN' . rand(1000, 9999) . rand(1000, 9999),
                'pin' => strtoupper(Str::random(12)),
                'batch_number' => $batch,
                'usage_limit' => 5,
            ]);
        }

        return back()->with('success', "Batch $batch generated successfully!");
    }

    public function print(Request $request)
    {
        $query = ResultToken::where('school_id', auth()->user()->school_id);
        
        if ($request->batch) {
            $query->where('batch_number', $request->batch);
        }

        $tokens = $query->get();
        return view('dashboards.admin.tokens.print', compact('tokens'));
    }
}