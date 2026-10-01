<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use App\Models\ClassModel;
use App\Models\Ebook;
use App\Models\Subject;
use Illuminate\Support\Facades\Storage;
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

        $currentYear = (int) now()->format('Y');
        $auditItems = Ebook::with('subject.class')->get()->map(function (Ebook $ebook) use ($currentYear) {
            $issues = [];
            $author = trim((string) $ebook->author);

            if (! $ebook->file_path) {
                $issues[] = ['label' => 'PDF belum diunggah', 'level' => 'critical'];
            } elseif (! Storage::disk('public')->exists($ebook->file_path)) {
                $issues[] = ['label' => 'File PDF tidak ditemukan', 'level' => 'critical'];
            }
            if (! $ebook->cover_path) {
                $issues[] = ['label' => 'Cover belum ada', 'level' => 'warning'];
            }
            if ($author === '') {
                $issues[] = ['label' => 'Penulis belum diisi', 'level' => 'warning'];
            } elseif (mb_strlen($author) > 120 || str_contains(mb_strtoupper($author), 'DAFTAR ISI')) {
                $issues[] = ['label' => 'Penulis perlu diperiksa', 'level' => 'warning'];
            }
            if (trim((string) $ebook->publisher) === '') {
                $issues[] = ['label' => 'Penerbit belum diisi', 'level' => 'info'];
            }
            if (! $ebook->publication_year || $ebook->publication_year < 1945 || $ebook->publication_year > $currentYear + 1) {
                $issues[] = ['label' => 'Tahun terbit tidak valid', 'level' => 'info'];
            }
            if (trim((string) $ebook->description) === '') {
                $issues[] = ['label' => 'Deskripsi belum diisi', 'level' => 'info'];
            }

            $ebook->setAttribute('audit_issues', $issues);
            $ebook->setAttribute('audit_score', collect($issues)->sum(fn (array $issue) => match ($issue['level']) {
                'critical' => 4,
                'warning' => 2,
                default => 1,
            }));

            return $ebook;
        });

        $collectionAudit = [
            'total' => $auditItems->count(),
            'ready' => $auditItems->filter(fn (Ebook $ebook) => $ebook->audit_score === 0)->count(),
            'critical' => $auditItems->filter(fn (Ebook $ebook) => collect($ebook->audit_issues)->contains('level', 'critical'))->count(),
            'needs_review' => $auditItems->filter(fn (Ebook $ebook) => $ebook->audit_score > 0)->count(),
        ];
        $auditEbooks = $auditItems->filter(fn (Ebook $ebook) => $ebook->audit_score > 0)
            ->sortByDesc('audit_score')
            ->take(12)
            ->values();

        return view('admin.dashboard', compact('stats', 'latestEbooks', 'popularEbooks', 'latestAccessLogs', 'topClasses', 'topSubjects', 'weeklyAccesses', 'collectionHealth', 'collectionAudit', 'auditEbooks'));
    }
}
