<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use App\Models\Ebook;
use Illuminate\View\View;

class AccessLogController extends Controller
{
    public function index(): View
    {
        $accessLogs = AccessLog::with('ebook')->latest('accessed_at')->paginate(15);
        $popularEbooks = Ebook::withCount('accessLogs')->orderByDesc('access_logs_count')->limit(10)->get();

        return view('admin.access-logs.index', compact('accessLogs', 'popularEbooks'));
    }
}
