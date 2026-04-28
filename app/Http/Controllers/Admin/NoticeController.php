<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::where('school_id', auth()->user()->school_id)
            ->latest()
            ->paginate(10);
            
        return view('dashboards.admin.notices.index', compact('notices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'required|in:all,students,teachers,parents,staff',
            'priority' => 'required|in:low,normal,high,urgent',
        ]);

        Notice::create([
            'school_id' => auth()->user()->school_id,
            'title' => strtoupper($request->title),
            'content' => $request->content,
            'target_audience' => $request->target_audience,
            'priority' => $request->priority,
        ]);

        return back()->with('success', 'Announcement published successfully.');
    }

    public function destroy(Notice $notice)
    {
        if ($notice->school_id !== auth()->user()->school_id) abort(403);
        $notice->delete();
        return back()->with('success', 'Announcement removed.');
    }
}