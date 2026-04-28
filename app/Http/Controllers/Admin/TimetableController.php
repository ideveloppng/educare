<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::where('school_id', Auth::user()->school_id)->get();
        return view('dashboards.admin.timetables.index', compact('classes'));
    }

    public function manage(SchoolClass $class)
    {
        if ($class->school_id !== Auth::user()->school_id) abort(403);

        $school_id = Auth::user()->school_id;
        $subjects = Subject::where('school_id', $school_id)->get();
        $teachers = Teacher::where('school_id', $school_id)->with('user')->get();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $timeSlots = Timetable::where('school_class_id', $class->id)
            ->select('start_time', 'end_time')
            ->distinct()
            ->orderBy('start_time')
            ->get();

        $rawTimetable = Timetable::where('school_class_id', $class->id)
            ->with(['subject', 'teacher.user'])
            ->get();

        $formattedTimetable = [];
        foreach ($rawTimetable as $t) {
            $timeKey = $t->start_time . '-' . $t->end_time;
            $formattedTimetable[$timeKey][$t->day] = $t;
        }

        return view('dashboards.admin.timetables.manage', compact('class', 'subjects', 'teachers', 'days', 'timeSlots', 'formattedTimetable'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_class_id' => 'required',
            'type' => 'required|in:academic,activity',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'subject_id' => 'required_if:type,academic',
            'activity_name' => 'required_if:type,activity',
        ]);

        Timetable::create(array_merge($request->all(), [
            'school_id' => Auth::user()->school_id,
            'activity_name' => $request->type === 'activity' ? strtoupper($request->activity_name) : null,
        ]));

        return back()->with('success', 'New period added to timetable.');
    }

    public function update(Request $request, Timetable $timetable)
    {
        if ($timetable->school_id !== Auth::user()->school_id) abort(403);

        $request->validate([
            'type' => 'required|in:academic,activity',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $timetable->update(array_merge($request->all(), [
            'activity_name' => $request->type === 'activity' ? strtoupper($request->activity_name) : null,
            'subject_id' => $request->type === 'academic' ? $request->subject_id : null,
            'teacher_id' => $request->type === 'academic' ? $request->teacher_id : null,
        ]));

        return back()->with('success', 'Timetable slot updated.');
    }

    public function destroy(Timetable $timetable)
    {
        if ($timetable->school_id !== Auth::user()->school_id) abort(403);
        $timetable->delete();
        return back()->with('success', 'Period removed.');
    }

    /**
     * THE FIX: Updated print method to generate required table data
     */
    public function print(SchoolClass $class)
    {
        if ($class->school_id !== Auth::user()->school_id) abort(403);

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // 1. Get unique time rows
        $timeSlots = Timetable::where('school_class_id', $class->id)
            ->select('start_time', 'end_time')
            ->distinct()
            ->orderBy('start_time')
            ->get();

        // 2. Get all entries
        $rawTimetable = Timetable::where('school_class_id', $class->id)
            ->with(['subject', 'teacher.user'])
            ->get();

        // 3. Group by time-day key
        $formattedTimetable = [];
        foreach ($rawTimetable as $t) {
            $timeKey = $t->start_time . '-' . $t->end_time;
            $formattedTimetable[$timeKey][$t->day] = $t;
        }

        return view('dashboards.admin.timetables.print', compact('class', 'days', 'timeSlots', 'formattedTimetable'));
    }
}