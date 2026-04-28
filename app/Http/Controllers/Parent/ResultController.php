<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\ResultToken;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    /**
     * Step 1: Show all linked children to choose from
     */
    public function index()
    {
        $guardian = Auth::user()->guardian;
        if (!$guardian) return redirect()->route('dashboard');

        $children = $guardian->students()->with(['user', 'schoolClass'])->get();

        return view('dashboards.parent.results.index', compact('children'));
    }

    /**
     * Step 2: Show the PIN entry gateway for a specific child
     */
    public function gateway(Student $student)
    {
        // Security: Ensure this student belongs to this parent
        $guardian = Auth::user()->guardian;
        if (!$guardian->students->contains($student->id)) abort(403);

        $year = (int)date('Y');
        $sessions = [($year-1)."/".($year), $year."/".($year+1)];

        return view('dashboards.parent.results.gateway', compact('student', 'sessions'));
    }

    /**
     * Step 3: Process the scratch card
     */
    public function check(Request $request, Student $student)
    {
        $request->validate([
            'session' => 'required',
            'term' => 'required',
            'serial_number' => 'required',
            'pin' => 'required',
        ]);

        $token = ResultToken::where('serial_number', $request->serial_number)
            ->where('pin', $request->pin)
            ->where('school_id', Auth::user()->school_id)
            ->first();

        if (!$token) return back()->with('error', 'Invalid Serial Number or PIN.');

        if ($token->status === 'used' && $token->usage_count >= $token->usage_limit) {
            return back()->with('error', 'This scratch card has been exhausted.');
        }

        // Lock to this specific child
        if ($token->student_id !== null && $token->student_id !== $student->id) {
            return back()->with('error', 'This card is already linked to another student.');
        }

        // Lock to specific Term/Session
        if ($token->session !== null && ($token->session !== $request->session || $token->term !== $request->term)) {
            return back()->with('error', "This card is locked to {$token->term} {$token->session}.");
        }

        // First use logic
        if ($token->student_id === null) {
            $token->student_id = $student->id;
            $token->session = $request->session;
            $token->term = $request->term;
        }

        $token->usage_count += 1;
        if ($token->usage_count >= $token->usage_limit) $token->status = 'used';
        $token->save();

        return redirect()->route('parent.results.show', ['student' => $student->id, 'token' => $token->id]);
    }

    /**
     * Step 4: Display the Result
     */
    public function show(Student $student, ResultToken $token)
    {
        // Security checks
        $guardian = Auth::user()->guardian;
        if (!$guardian->students->contains($student->id) || $token->student_id !== $student->id) abort(403);

        $results = Result::where([
            'student_id' => $student->id,
            'term' => $token->term,
            'session' => $token->session,
            'is_published' => true
        ])->with('subject')->get();

        $school = Auth::user()->school;
        $student->load(['user', 'schoolClass']);

        return view('dashboards.parent.results.show', compact('student', 'school', 'token', 'results'));
    }
}