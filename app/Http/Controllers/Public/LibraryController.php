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

        if ($request->query('q') !== null || $request->query('class') !== null) {
            $classFilter = $selectedClass !== ''
                ? ClassModel::where('is_active', true)->where('name', $selectedClass)->first()
                : null;

            if ($search !== '') {
                $ebookQuery = Ebook::query()
                    ->where('is_active', true)
                    ->where(function ($query) use ($search) {
                        $query->where('title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('author', 'like', "%{$search}%")
                            ->orWhere('publisher', 'like', "%{$search}%")
                            ->orWhereHas('subject', function ($subjectQuery) use ($search) {
                                $subjectQuery->where('name', 'like', "%{$search}%")
                                    ->orWhere('code', 'like', "%{$search}%");
                            });
                    });

                if ($classFilter) {
                    $ebookQuery->whereHas('subject', fn ($subjectQuery) => $subjectQuery->where('class_id', $classFilter->id));
                }

                $ebook = $ebookQuery->first();

                if ($ebook) {
                    return redirect()->route('ebooks.show', $ebook);
                }
            }

            if ($classFilter && $search === '') {
                return redirect()->route('classes.show', $classFilter);
            }

            return redirect()->route('library', ['q' => $search, 'class' => $selectedClass]);
        }

        $classes = ClassModel::where('is_active', true)
            ->withCount([
                'subjects' => fn ($query) => $query
                    ->where('is_active', true)
                    ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam')"),
                'subjects as ebooks_count' => fn ($query) => $query
                    ->where('subjects.is_active', true)
                    ->whereRaw("LOWER(subjects.name) NOT IN ('ipa', 'ilmu pengetahuan alam')")
                    ->join('ebooks', 'subjects.id', '=', 'ebooks.subject_id')
                    ->where('ebooks.is_active', true),
            ])
            ->orderBy('name')
            ->get();

        $stats = [
            'classes' => $classes->count(),
            'subjects' => Subject::where('is_active', true)
                ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam')")
                ->count(),
            'ebooks' => Ebook::where('is_active', true)->count(),
            'accesses' => AccessLog::count(),
        ];

        $latestEbooks = Ebook::with('subject.class')
            ->where('is_active', true)
            ->latest()
            ->limit(4)
            ->get();

        return view('public.home', compact('classes', 'stats', 'latestEbooks'));
    }

    public function library(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $selectedClass = $request->query('class');

        $classes = ClassModel::where('is_active', true)
            ->withCount([
                'subjects' => fn ($query) => $query
                    ->where('is_active', true)
                    ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam')"),
                'subjects as ebooks_count' => fn ($query) => $query
                    ->where('subjects.is_active', true)
                    ->whereRaw("LOWER(subjects.name) NOT IN ('ipa', 'ilmu pengetahuan alam')")
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
            ->orderBy('name')
            ->get();

        $classOptions = ClassModel::where('is_active', true)->orderBy('name')->pluck('name');

        return view('public.library', compact('classes', 'classOptions', 'search', 'selectedClass'));
    }

    public function class(Request $request, ClassModel $class): View
    {
        $search = trim((string) $request->query('q', ''));

        $class->load(['subjects' => fn ($query) => $query
            ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam')")
            ->where(function ($query) {
                $query->where('is_active', true);

                foreach (Subject::scienceBranchNames() as $subjectName) {
                    $query->orWhereRaw('LOWER(name) = ?', [$subjectName]);
                }
            })
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
            ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam')")
            ->count();

        return view('public.class', compact('class', 'search', 'totalSubjects'));
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
        $ebook->load('subject.class');

        AccessLog::create([
            'ebook_id' => $ebook->id,
            'accessed_at' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return view('public.ebook', compact('ebook'));
    }

    public function download(Ebook $ebook): RedirectResponse
    {
        abort_unless($ebook->file_path && Storage::disk('public')->exists($ebook->file_path), 404);

        return redirect(Storage::url($ebook->file_path));
    }
}
