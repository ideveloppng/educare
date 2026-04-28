<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $school_id = Auth::user()->school_id;
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // Fetch only academic slots assigned to this teacher OR general activities (Break/Assembly)
        $rawTimetable = Timetable::where('school_id', $school_id)
            ->where(function($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id)
                      ->orWhere('type', 'activity');
            })
            ->with(['subject', 'schoolClass'])
            ->get();

        $timeSlots = Timetable::where('school_id', $school_id)
            ->where(function($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id)
                      ->orWhere('type', 'activity');
            })
            ->select('start_time', 'end_time')
            ->distinct()
            ->orderBy('start_time')
            ->get();

        $formattedTimetable = [];
        foreach ($rawTimetable as $t) {
            $timeKey = $t->start_time . '-' . $t->end_time;
            $formattedTimetable[$timeKey][$t->day][] = $t; // Use array to handle same time on same day across different classes
        }

        return view('dashboards.teacher.timetable.index', compact('days', 'timeSlots', 'formattedTimetable'));
    }
}