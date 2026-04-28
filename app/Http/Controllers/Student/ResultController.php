<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Result; // THE FIX: Explicitly import the Result Model
use App\Models\ResultToken;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    /**
     * Show the PIN Entry Gateway
     */
    public function index()
    {
        // Generate a list of sessions (Current, and 1 year back)
        $year = (int)date('Y');
        $sessions = [
            ($year-1)."/".($year),
            ($year)."/".($year+1),
        ];

        return view('dashboards.student.results.index', compact('sessions'));
    }

    /**
     * Process the Token and Redirect to Report Card
     */
    public function check(Request $request)
    {
        $request->validate([
            'session' => 'required|string',
            'term' => 'required|string',
            'serial_number' => 'required|string',
            'pin' => 'required|string',
        ]);

        $user = Auth::user();
        $student = $user->student;

        // 1. Find the token
        $token = ResultToken::where('serial_number', $request->serial_number)
            ->where('pin', $request->pin)
            ->where('school_id', $user->school_id)
            ->first();

        // 2. Validation Logic
        if (!$token) {
            return back()->with('error', 'Invalid Serial Number or PIN. Please check and try again.');
        }

        if ($token->status === 'expired' || ($token->status === 'used' && $token->usage_count >= $token->usage_limit)) {
            return back()->with('error', 'This scratch card has been exhausted.');
        }

        // 3. Locking Logic (First student to use it owns it)
        if ($token->student_id !== null && $token->student_id !== $student->id) {
            return back()->with('error', 'This token is already linked to another student record.');
        }

        // 4. Academic Scope Locking
        if ($token->session !== null || $token->term !== null) {
            if ($token->session !== $request->session || $token->term !== $request->term) {
                return back()->with('error', "This card is locked to {$token->term} {$token->session}.");
            }
        } else {
            // First use: Lock it
            $token->session = $request->session;
            $token->term = $request->term;
            $token->student_id = $student->id;
        }

        // 5. Increment usage
        $token->usage_count += 1;
        if ($token->usage_count >= $token->usage_limit) {
            $token->status = 'used';
        }
        $token->save();

        return redirect()->route('student.results.show', ['token' => $token->id]);
    }

    /**
     * Display the actual Report Card
     */
    public function show(Request $request, $tokenId)
    {
        $token = ResultToken::findOrFail($tokenId);

        // Security: Ensure the student viewing this is the one the token is locked to
        if ($token->student_id !== Auth::user()->student->id) {
            abort(403, 'Unauthorized access to this result.');
        }

        // Fetch Published Results only
        $results = Result::where([
            'student_id' => $token->student_id,
            'term' => $token->term,
            'session' => $token->session,
            'is_published' => true
        ])->with('subject')->get();

        $student = Auth::user()->student->load(['user', 'schoolClass']);
        $school = Auth::user()->school;

        return view('dashboards.student.results.show', compact('student', 'school', 'token', 'results'));
    }
}