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
    public function home(): View
    {
        $classes = ClassModel::where('is_active', true)->orderBy('name')->get();

        return view('public.home', compact('classes'));
    }

    public function library(): View
    {
        $classes = ClassModel::where('is_active', true)->orderBy('name')->get();

        return view('public.library', compact('classes'));
    }

    public function class(ClassModel $class): View
    {
        $class->load(['subjects' => fn ($query) => $query->where('is_active', true)->orderBy('name')]);

        return view('public.class', compact('class'));
    }

    public function subject(ClassModel $class, Subject $subject): View
    {
        abort_unless($subject->class_id === $class->id, 404);

        $subject->load(['ebooks' => fn ($query) => $query->where('is_active', true)->latest()]);

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
