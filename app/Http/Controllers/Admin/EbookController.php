<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Ebook;
use App\Models\Subject;
use App\Services\EbookMetadataExtractor;
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

    public function store(Request $request, EbookMetadataExtractor $metadataExtractor): RedirectResponse
    {
        $validated = $request->validate([
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:102400'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $metadata = $metadataExtractor->extract($request->file('file'));
        $subjects = $this->resolveSubjectsFromMetadata($metadata);

        if ($subjects->isEmpty()) {
            return back()
                ->withErrors(['file' => 'Kelas dan mata pelajaran belum bisa dikenali dari PDF. Pastikan nama kelas dan mata pelajaran ada di nama file atau halaman awal PDF.'])
                ->withInput();
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['title'] = $metadata['title'];
        $validated['author'] = $metadata['author'];
        $validated['publisher'] = $metadata['publisher'];
        $validated['publication_year'] = $metadata['publication_year'];
        $validated['description'] = $metadata['description'];
        $validated['file_path'] = $request->file('file')->store('ebooks', 'public');

        if ($request->hasFile('cover')) {
            $validated['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        unset($validated['file'], $validated['cover']);

        foreach ($subjects as $subject) {
            $ebook = Ebook::create($validated + ['subject_id' => $subject->id]);
            $this->syncSubjectStatus($ebook->subject_id);
        }

        return redirect()->route('admin.ebooks.index')->with('success', 'E-book berhasil ditambahkan.');
    }

    public function edit(Ebook $ebook): View
    {
        $classes = ClassModel::orderBy('name')->get();
        $subjects = Subject::with('class')->orderBy('name')->get();

        return view('admin.ebooks.edit', compact('ebook', 'classes', 'subjects'));
    }

    public function update(Request $request, Ebook $ebook, EbookMetadataExtractor $metadataExtractor): RedirectResponse
    {
        $validated = $request->validate([
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:102400'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('file')) {
            $metadata = $metadataExtractor->extract($request->file('file'));
            $subject = $this->resolveSubjectFromMetadata($metadata);

            if (! $subject) {
                return back()
                    ->withErrors(['file' => 'Kelas dan mata pelajaran belum bisa dikenali dari PDF. Pastikan nama kelas dan mata pelajaran ada di nama file atau halaman awal PDF.'])
                    ->withInput();
            }

            $this->deleteStoredFileIfUnused($ebook->file_path, $ebook->id);

            $validated['subject_id'] = $subject->id;
            $validated['title'] = $metadata['title'];
            $validated['author'] = $metadata['author'];
            $validated['publisher'] = $metadata['publisher'];
            $validated['publication_year'] = $metadata['publication_year'];
            $validated['description'] = $metadata['description'];
            $validated['file_path'] = $request->file('file')->store('ebooks', 'public');
        }

        if ($request->hasFile('cover')) {
            $this->deleteStoredFileIfUnused($ebook->cover_path, $ebook->id, 'cover_path');

            $validated['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        unset($validated['file'], $validated['cover']);

        $oldSubjectId = $ebook->subject_id;

        $ebook->update($validated);

        $this->syncSubjectStatus($oldSubjectId);
        $this->syncSubjectStatus($ebook->subject_id);

        return redirect()->route('admin.ebooks.index')->with('success', 'E-book berhasil diperbarui.');
    }

    public function destroy(Ebook $ebook): RedirectResponse
    {
        $subjectId = $ebook->subject_id;

        $this->deleteStoredFileIfUnused($ebook->file_path, $ebook->id);
        $this->deleteStoredFileIfUnused($ebook->cover_path, $ebook->id, 'cover_path');

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

    private function resolveSubjectFromMetadata(array $metadata): ?Subject
    {
        if ($metadata['subject']) {
            return $metadata['subject'];
        }

        if (! $metadata['class'] || ! $metadata['detected_subject_name']) {
            return null;
        }

        return Subject::firstOrCreate(
            [
                'class_id' => $metadata['class']->id,
                'name' => $metadata['detected_subject_name'],
            ],
            [
                'code' => null,
                'description' => 'Mata pelajaran dibuat otomatis dari metadata PDF.',
                'is_active' => true,
            ]
        );
    }

    private function resolveSubjectsFromMetadata(array $metadata)
    {
        if (($metadata['detected_subject_name'] ?? null) === 'IPA') {
            if (! $metadata['class']) {
                return collect();
            }

            return collect(['Kimia', 'Fisika', 'Biologi'])
                ->map(fn (string $subjectName) => Subject::firstOrCreate(
                    [
                        'class_id' => $metadata['class']->id,
                        'name' => $subjectName,
                    ],
                    [
                        'code' => null,
                        'description' => 'Mata pelajaran dibuat otomatis dari metadata PDF IPA.',
                        'is_active' => false,
                    ]
                ));
        }

        if (($metadata['detected_subject_name'] ?? null) === 'IPS') {
            if (! $metadata['class']) {
                return collect();
            }

            return collect(['Sosiologi', 'Geologi', 'Ekonomi'])
                ->map(fn (string $subjectName) => Subject::firstOrCreate(
                    [
                        'class_id' => $metadata['class']->id,
                        'name' => $subjectName,
                    ],
                    [
                        'code' => null,
                        'description' => 'Mata pelajaran dibuat otomatis dari metadata PDF IPS.',
                        'is_active' => false,
                    ]
                ));
        }

        $subject = $this->resolveSubjectFromMetadata($metadata);

        return $subject ? collect([$subject]) : collect();
    }

    private function deleteStoredFileIfUnused(?string $path, int $currentEbookId, string $column = 'file_path'): void
    {
        if (! $path) {
            return;
        }

        $isUsedByAnotherEbook = Ebook::where($column, $path)
            ->where('id', '!=', $currentEbookId)
            ->exists();

        if (! $isUsedByAnotherEbook) {
            Storage::disk('public')->delete($path);
        }
    }
}
