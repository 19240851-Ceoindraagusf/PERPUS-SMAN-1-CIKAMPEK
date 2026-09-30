<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use App\Models\ClassModel;
use App\Models\Ebook;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function home(Request $request): View|RedirectResponse
    {
        $search = trim((string) $request->query('q', ''));
        $selectedClass = trim((string) $request->query('class', ''));
        $classOrder = "CASE WHEN name = 'X' THEN 1 WHEN name LIKE 'XI%' THEN 2 WHEN name LIKE 'XII%' THEN 3 ELSE 4 END";

        if ($request->query('q') !== null || $request->query('class') !== null) {
            // A search should show every relevant title, not unexpectedly open the first match.
            return redirect()->route('library', array_filter([
                'q' => $search,
                'class' => $selectedClass,
            ], fn ($value) => $value !== ''));
        }

        $classes = ClassModel::where('is_active', true)
            ->withCount([
                'subjects' => fn ($query) => $query
                    ->where('is_active', true)
                    ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam', 'ips', 'ilmu pengetahuan sosial')"),
                'subjects as ebooks_count' => fn ($query) => $query
                    ->where('subjects.is_active', true)
                    ->whereRaw("LOWER(subjects.name) NOT IN ('ipa', 'ilmu pengetahuan alam', 'ips', 'ilmu pengetahuan sosial')")
                    ->join('ebooks', 'subjects.id', '=', 'ebooks.subject_id')
                    ->where('ebooks.is_active', true),
            ])
            ->orderByRaw($classOrder)
            ->orderBy('name')
            ->get();

        $stats = [
            'classes' => $classes->count(),
            'subjects' => Subject::where('is_active', true)
                ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam', 'ips', 'ilmu pengetahuan sosial')")
                ->count(),
            'ebooks' => Ebook::where('is_active', true)->count(),
            'accesses' => AccessLog::count(),
        ];

        $latestEbooks = Ebook::with('subject.class')
            ->where('is_active', true)
            ->latest()
            ->limit(4)
            ->get();

        $popularEbooks = Ebook::with('subject.class')
            ->where('is_active', true)
            ->withCount('accessLogs')
            ->orderByDesc('access_logs_count')
            ->latest()
            ->limit(4)
            ->get();

        $classOptions = ClassModel::where('is_active', true)
            ->orderByRaw($classOrder)
            ->orderBy('name')
            ->pluck('name');

        return view('public.home', compact('classes', 'stats', 'latestEbooks', 'popularEbooks', 'classOptions'));
    }

    public function library(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $selectedClass = $request->query('class');
        $selectedSubject = $request->query('subject');
        $selectedYear = $request->query('year');
        $selectedAuthor = $request->query('author');
        $sort = $request->query('sort', 'newest');
        $sort = in_array($sort, ['newest', 'popular', 'title'], true) ? $sort : 'newest';
        $classOrder = "CASE WHEN name = 'X' THEN 1 WHEN name LIKE 'XI%' THEN 2 WHEN name LIKE 'XII%' THEN 3 ELSE 4 END";
        $classFilter = $selectedClass
            ? ClassModel::where('is_active', true)->where('name', $selectedClass)->first()
            : null;

        $classes = ClassModel::where('is_active', true)
            ->withCount([
                'subjects' => fn ($query) => $query
                    ->where('is_active', true)
                    ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam', 'ips', 'ilmu pengetahuan sosial')"),
                'subjects as ebooks_count' => fn ($query) => $query
                    ->where('subjects.is_active', true)
                    ->whereRaw("LOWER(subjects.name) NOT IN ('ipa', 'ilmu pengetahuan alam', 'ips', 'ilmu pengetahuan sosial')")
                    ->join('ebooks', 'subjects.id', '=', 'ebooks.subject_id')
                    ->where('ebooks.is_active', true),
            ])
            ->when($selectedClass, fn ($query) => $query->where('name', $selectedClass))
            ->when($search, fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('subjects', fn ($subjectQuery) => $subjectQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhereHas('ebooks', fn ($ebookQuery) => $ebookQuery->where('title', 'like', "%{$search}%")));
            }))
            ->when($selectedSubject, fn ($query) => $query->whereHas('subjects', fn ($subjectQuery) => $subjectQuery
                ->where('is_active', true)
                ->where('name', $selectedSubject)))
            ->orderByRaw($classOrder)
            ->orderBy('name')
            ->get();

        $matchedEbooks = Ebook::query()
            ->with('subject.class')
            ->where('is_active', true)
            ->when($search, fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%")
                    ->orWhereHas('subject', fn ($subjectQuery) => $subjectQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%"));
            }))
            ->when($selectedClass, fn ($query) => $query->whereHas('subject', fn ($subjectQuery) => $subjectQuery->where('class_id', $classFilter?->id ?? 0)))
            ->when($selectedSubject, fn ($query) => $query->whereHas('subject', fn ($subjectQuery) => $subjectQuery->where('name', $selectedSubject)))
            ->when($selectedYear, fn ($query) => $query->where('publication_year', $selectedYear))
            ->when($selectedAuthor, fn ($query) => $query->where('author', $selectedAuthor))
            ->withCount('accessLogs')
            ->when($sort === 'popular', fn ($query) => $query->orderByDesc('access_logs_count')->latest())
            ->when($sort === 'title', fn ($query) => $query->orderBy('title'))
            ->when($sort === 'newest', fn ($query) => $query->latest())
            ->paginate(12)
            ->withQueryString();

        $classOptions = ClassModel::where('is_active', true)
            ->orderByRaw($classOrder)
            ->orderBy('name')
            ->pluck('name');

        $subjectOptions = Subject::query()
            ->when($classFilter, fn ($query) => $query->where('class_id', $classFilter->id))
            ->where('is_active', true)
            ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam', 'ips', 'ilmu pengetahuan sosial')")
            ->orderBy('name')
            ->pluck('name')
            ->unique()
            ->values();

        $yearOptions = Ebook::where('is_active', true)
            ->whereNotNull('publication_year')
            ->when($classFilter, fn ($query) => $query->whereHas('subject', fn ($subjectQuery) => $subjectQuery->where('class_id', $classFilter->id)))
            ->orderByDesc('publication_year')
            ->pluck('publication_year')
            ->unique()
            ->values();

        $authorOptions = Ebook::where('is_active', true)
            ->whereNotNull('author')
            ->where('author', '!=', '')
            ->when($classFilter, fn ($query) => $query->whereHas('subject', fn ($subjectQuery) => $subjectQuery->where('class_id', $classFilter->id)))
            ->orderBy('author')
            ->pluck('author')
            ->unique()
            ->values();

        return view('public.library', compact('classes', 'matchedEbooks', 'classOptions', 'subjectOptions', 'yearOptions', 'authorOptions', 'search', 'selectedClass', 'selectedSubject', 'selectedYear', 'selectedAuthor', 'sort'));
    }

    public function class(Request $request, ClassModel $class): View
    {
        $search = trim((string) $request->query('q', ''));
        $selectedSubject = $request->query('subject');

        $class->load(['subjects' => fn ($query) => $query
            ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam', 'ips', 'ilmu pengetahuan sosial')")
            ->where(function ($query) {
                $query->where('is_active', true);

                foreach (Subject::scienceBranchNames() as $subjectName) {
                    $query->orWhereRaw('LOWER(name) = ?', [$subjectName]);
                }
            })
            ->when($selectedSubject, fn ($subjectQuery) => $subjectQuery->where('name', $selectedSubject))
            ->when($search, fn ($subjectQuery) => $subjectQuery->where(function ($subjectQuery) use ($search) {
                $subjectQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('ebooks', fn ($ebookQuery) => $ebookQuery
                        ->where('is_active', true)
                        ->where(function ($ebookQuery) use ($search) {
                            $ebookQuery->where('title', 'like', "%{$search}%")
                                ->orWhere('description', 'like', "%{$search}%")
                                ->orWhere('author', 'like', "%{$search}%")
                                ->orWhere('publisher', 'like', "%{$search}%");
                        }));
            }))
            ->orderBy('name')]);

        $class->setRelation('subjects', $class->subjects
            ->map(function (Subject $subject) {
                $ebookCount = $subject->sharedEbooks()->where('is_active', true)->count();
                $subject->setAttribute('ebooks_count', $ebookCount);

                return $subject;
            })
            ->filter(fn (Subject $subject) => $subject->is_active || ($subject->isScienceBranch() && $subject->ebooks_count > 0))
            ->values());

        $totalSubjects = Subject::where('class_id', $class->id)
            ->where('is_active', true)
            ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam', 'ips', 'ilmu pengetahuan sosial')")
            ->count();

        $subjectOptions = Subject::where('class_id', $class->id)
            ->where('is_active', true)
            ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam', 'ips', 'ilmu pengetahuan sosial')")
            ->orderBy('name')
            ->pluck('name');

        return view('public.class', compact('class', 'search', 'selectedSubject', 'subjectOptions', 'totalSubjects'));
    }

    public function subject(Request $request, ClassModel $class, Subject $subject): View
    {
        abort_unless($subject->class_id === $class->id, 404);
        abort_if($subject->isScienceUmbrella(), 404);

        $ebooks = $subject->sharedEbooks()
            ->where('is_active', true)
            ->latest()
            ->get();

        $subject->setRelation('ebooks', $ebooks);

        return view('public.subject', compact('class', 'subject'));
    }

    public function ebook(Request $request, Ebook $ebook): View
    {
        abort_unless($ebook->is_active, 404);

        $ebook->load('subject.class')->loadCount('accessLogs');

        AccessLog::create([
            'ebook_id' => $ebook->id,
            'accessed_at' => now(),
            'ip_address' => $this->anonymizeIpAddress($request->ip()),
            'user_agent' => $request->userAgent(),
        ]);

        $relatedEbooks = Ebook::with('subject.class')
            ->where('is_active', true)
            ->where('id', '!=', $ebook->id)
            ->where('subject_id', $ebook->subject_id)
            ->latest()
            ->limit(4)
            ->get();

        return view('public.ebook', compact('ebook', 'relatedEbooks'));
    }

    public function reader(Ebook $ebook): View
    {
        abort_unless($ebook->is_active, 404);
        abort_unless($ebook->file_path && Storage::disk('public')->exists($ebook->file_path), 404);

        $ebook->load('subject.class');

        return view('public.reader', compact('ebook'));
    }

    public function download(Ebook $ebook): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        abort_unless($ebook->is_active, 404);
        abort_unless($ebook->file_path && Storage::disk('public')->exists($ebook->file_path), 404);

        $safeName = preg_replace('/[^A-Za-z0-9._-]+/', '-', $ebook->title ?: 'ebook');

        return response()->download(
            Storage::disk('public')->path($ebook->file_path),
            trim($safeName, '-').'.pdf',
            [
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-store, no-cache, must-revalidate',
                'Pragma' => 'no-cache',
            ]
        );
    }

    private function anonymizeIpAddress(?string $ipAddress): ?string
    {
        if (! $ipAddress || ! filter_var($ipAddress, FILTER_VALIDATE_IP)) {
            return null;
        }

        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $parts = explode('.', $ipAddress);
            $parts[3] = '0';

            return implode('.', $parts);
        }

        $packedAddress = inet_pton($ipAddress);

        if ($packedAddress === false) {
            return null;
        }

        return inet_ntop(substr($packedAddress, 0, 6).str_repeat("\0", 10));
    }
}
