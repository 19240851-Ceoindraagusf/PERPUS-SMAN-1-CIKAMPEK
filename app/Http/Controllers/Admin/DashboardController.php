<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use App\Models\ClassModel;
use App\Models\Ebook;
use App\Models\Subject;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'classes' => ClassModel::count(),
            'subjects' => Subject::count(),
            'ebooks' => Ebook::count(),
            'accesses' => AccessLog::count(),
        ];

        $latestEbooks = Ebook::with('subject')->latest()->limit(5)->get();
        $popularEbooks = Ebook::withCount('accessLogs')->orderByDesc('access_logs_count')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'latestEbooks', 'popularEbooks'));
    }
}
