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

        $weekStart = now()->subDays(6)->startOfDay();
        $accessesByDay = AccessLog::query()
            ->where('accessed_at', '>=', $weekStart)
            ->get()
            ->groupBy(fn (AccessLog $log) => optional($log->accessed_at)->format('Y-m-d'));
        $weeklyAccesses = collect(range(0, 6))->map(function (int $offset) use ($weekStart, $accessesByDay) {
            $date = $weekStart->copy()->addDays($offset);

            return [
                'label' => $date->locale('id')->isoFormat('ddd'),
                'count' => $accessesByDay->get($date->format('Y-m-d'), collect())->count(),
            ];
        });
        $collectionHealth = [
            'without_cover' => Ebook::where('is_active', true)->whereNull('cover_path')->count(),
            'without_description' => Ebook::where('is_active', true)->where(function ($query) {
                $query->whereNull('description')->orWhere('description', '');
            })->count(),
        ];

        return view('admin.dashboard', compact('stats', 'latestEbooks', 'popularEbooks', 'latestAccessLogs', 'topClasses', 'topSubjects', 'weeklyAccesses', 'collectionHealth'));
    }
}
