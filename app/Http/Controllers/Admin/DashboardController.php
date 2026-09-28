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

        $latestEbooks = Ebook::with('subject.class')->latest()->limit(5)->get();
        $popularEbooks = Ebook::with('subject.class')->withCount('accessLogs')->orderByDesc('access_logs_count')->limit(5)->get();
        $latestAccessLogs = AccessLog::with('ebook.subject.class')->latest('accessed_at')->limit(5)->get();
        $topClasses = ClassModel::query()
            ->withCount('subjects')
            ->withCount(['subjects as ebooks_count' => fn ($query) => $query
                ->where('subjects.is_active', true)
                ->join('ebooks', 'subjects.id', '=', 'ebooks.subject_id')
                ->where('ebooks.is_active', true)])
            ->where('is_active', true)
            ->orderByDesc('ebooks_count')
            ->limit(5)
            ->get();
        $topSubjects = Subject::query()
            ->with('class')
            ->where('is_active', true)
            ->withCount(['ebooks as access_count' => fn ($query) => $query
                ->join('access_logs', 'ebooks.id', '=', 'access_logs.ebook_id')
                ->where('ebooks.is_active', true)
                ->where('subjects.is_active', true)])
            ->orderByDesc('access_count')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestEbooks', 'popularEbooks', 'latestAccessLogs', 'topClasses', 'topSubjects'));
    }
}
