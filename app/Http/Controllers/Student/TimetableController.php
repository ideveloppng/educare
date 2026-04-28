<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        $school_id = Auth::user()->school_id;
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        if (!$student->school_class_id) {
            return view('dashboards.student.timetable.index', ['timeSlots' => collect()]);
        }

        $timeSlots = Timetable::where('school_class_id', $student->school_class_id)
            ->select('start_time', 'end_time')
            ->distinct()
            ->orderBy('start_time')
            ->get();

        $rawTimetable = Timetable::where('school_class_id', $student->school_class_id)
            ->with(['subject', 'teacher.user'])
            ->get();

        $formattedTimetable = [];
        foreach ($rawTimetable as $t) {
            $timeKey = $t->start_time . '-' . $t->end_time;
            $formattedTimetable[$timeKey][$t->day] = $t;
        }

        return view('dashboards.student.timetable.index', compact('days', 'timeSlots', 'formattedTimetable'));
    }
}