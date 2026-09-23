<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Ebook;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EbookController extends Controller
{
    public function index(): View
    {
        $ebooks = Ebook::with('subject.class')->latest()->paginate(10);

        return view('admin.ebooks.index', compact('ebooks'));
    }

    public function create(): View
    {
        $classes = ClassModel::orderBy('name')->get();
        $subjects = Subject::with('class')->orderBy('name')->get();

        return view('admin.ebooks.create', compact('classes', 'subjects'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'class_id' => ['required', 'exists:classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'author' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'publication_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'description' => ['nullable', 'string'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:102400'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $this->validateSubjectBelongsToClass($validated['subject_id'], $validated['class_id']);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['title'] = $this->titleFromUploadedFile($request->file('file'));
        $validated['file_path'] = $request->file('file')->store('ebooks', 'public');

        if ($request->hasFile('cover')) {
            $validated['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        unset($validated['file'], $validated['cover'], $validated['class_id']);

        $ebook = Ebook::create($validated);
        $this->syncSubjectStatus($ebook->subject_id);

        return redirect()->route('admin.ebooks.index')->with('success', 'E-book berhasil ditambahkan.');
    }

    public function edit(Ebook $ebook): View
    {
        $classes = ClassModel::orderBy('name')->get();
        $subjects = Subject::with('class')->orderBy('name')->get();

        return view('admin.ebooks.edit', compact('ebook', 'classes', 'subjects'));
    }

    public function update(Request $request, Ebook $ebook): RedirectResponse
    {
        $validated = $request->validate([
            'class_id' => ['required', 'exists:classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'author' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'publication_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'description' => ['nullable', 'string'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:102400'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $this->validateSubjectBelongsToClass($validated['subject_id'], $validated['class_id']);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('file')) {
            if ($ebook->file_path) {
                Storage::disk('public')->delete($ebook->file_path);
            }

            $validated['title'] = $this->titleFromUploadedFile($request->file('file'));
            $validated['file_path'] = $request->file('file')->store('ebooks', 'public');
        }

        if ($request->hasFile('cover')) {
            if ($ebook->cover_path) {
                Storage::disk('public')->delete($ebook->cover_path);
            }

            $validated['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        unset($validated['file'], $validated['cover'], $validated['class_id']);

        $oldSubjectId = $ebook->subject_id;

        $ebook->update($validated);

        $this->syncSubjectStatus($oldSubjectId);
        $this->syncSubjectStatus($ebook->subject_id);

        return redirect()->route('admin.ebooks.index')->with('success', 'E-book berhasil diperbarui.');
    }

    public function destroy(Ebook $ebook): RedirectResponse
    {
        $subjectId = $ebook->subject_id;

        if ($ebook->file_path) {
            Storage::disk('public')->delete($ebook->file_path);
        }

        if ($ebook->cover_path) {
            Storage::disk('public')->delete($ebook->cover_path);
        }

        $ebook->delete();
        $this->syncSubjectStatus($subjectId);

        return redirect()->route('admin.ebooks.index')->with('success', 'E-book berhasil dihapus.');
    }

    private function syncSubjectStatus(int $subjectId): void
    {
        $subject = Subject::find($subjectId);

        if (! $subject) {
            return;
        }

        $subject->update([
            'is_active' => $subject->ebooks()->where('is_active', true)->exists(),
        ]);
    }

    private function validateSubjectBelongsToClass(int $subjectId, int $classId): void
    {
        $isValid = Subject::where('id', $subjectId)
            ->where('class_id', $classId)
            ->exists();

        if (! $isValid) {
            back()
                ->withErrors(['subject_id' => 'Mata pelajaran tidak sesuai dengan kelas yang dipilih.'])
                ->withInput()
                ->throwResponse();
        }
    }

    private function titleFromUploadedFile($file): string
    {
        return pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    }
}
