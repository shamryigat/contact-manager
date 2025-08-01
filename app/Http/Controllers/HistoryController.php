<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class HistoryController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::where('user_id', auth()->id())
            ->latest()
            ->paginate(10); // pagination

        return view('history.activity-history', compact('logs'));
    }
}
