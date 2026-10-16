<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\ClassModel;
use App\Models\Ebook;
use App\Models\Subject;
use App\Services\EbookMetadataExtractor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EbookController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'class_id' => ['nullable', 'integer', 'exists:classes,id'],
            'subject_id' => ['nullable', 'integer', 'exists:subjects,id'],
        ]);

        $selectedClassId = $validated['class_id'] ?? null;
        $selectedSubjectId = $validated['subject_id'] ?? null;
        $classOrder = "CASE WHEN name = 'X' THEN 1 WHEN name LIKE 'XI%' THEN 2 WHEN name LIKE 'XII%' THEN 3 ELSE 4 END";

        $ebooks = Ebook::query()
            ->with('subject.class')
            ->when($selectedClassId, fn ($query) => $query->whereHas('subject', fn ($subjectQuery) => $subjectQuery->where('class_id', $selectedClassId)))
            ->when($selectedSubjectId, fn ($query) => $query->where('subject_id', $selectedSubjectId))
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        $classes = ClassModel::query()
            ->orderByRaw($classOrder)
            ->orderBy('name')
            ->get();

        $subjects = Subject::query()
            ->with('class')
            ->when($selectedClassId, fn ($query) => $query->where('class_id', $selectedClassId))
            ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam', 'ips', 'ilmu pengetahuan sosial')")
            ->orderBy('name')
            ->get();

        return view('admin.ebooks.index', compact('ebooks', 'classes', 'subjects', 'selectedClassId', 'selectedSubjectId'));
    }

    public function create(): View
    {
        $classOrder = "CASE WHEN name = 'X' THEN 1 WHEN name LIKE 'XI%' THEN 2 WHEN name LIKE 'XII%' THEN 3 ELSE 4 END";
        $classes = ClassModel::orderByRaw($classOrder)->orderBy('name')->get();
        $subjects = Subject::with('class')
            ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam', 'ips', 'ilmu pengetahuan sosial')")
            ->orderBy('name')
            ->get();

        return view('admin.ebooks.create', compact('classes', 'subjects'));
    }

    public function store(Request $request, EbookMetadataExtractor $metadataExtractor): RedirectResponse
    {
        $validated = $request->validate([
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:102400'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'author' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'publication_year' => ['nullable', 'integer', 'between:1901,2155'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $subject = Subject::findOrFail($validated['subject_id']);
        $metadata = $metadataExtractor->extract($request->file('file'));

        $validated['is_active'] = $request->boolean('is_active');
        $validated['title'] = $metadataExtractor->titleForSelectedSubject($metadata['title'], $subject->name);
        $validated['author'] = $request->filled('author') ? trim($validated['author']) : $metadata['author'];
        $validated['publisher'] = $request->filled('publisher') ? trim($validated['publisher']) : $metadata['publisher'];
        $validated['publication_year'] = $request->filled('publication_year')
            ? $validated['publication_year']
            : $metadata['publication_year'];
        $validated['description'] = $metadata['description'];
        $validated['file_path'] = $request->file('file')->store('ebooks', 'public');

        if ($request->hasFile('cover')) {
            $validated['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        unset($validated['file'], $validated['cover']);

        $ebook = Ebook::create($validated);
        AuditLog::record('Create', 'Menambahkan e-book "' . $ebook->title . '"', $ebook);
        $subject->description = $metadataExtractor->buildSubjectDescription($subject->name, $metadata['title'], $metadata['description']);
        $subject->save();
        $this->spreadEbookToUmbrellaSubjects($ebook, $subject, $metadataExtractor);
        $this->syncGroupCoverForEbook($ebook, $ebook->cover_path);
        $this->syncSubjectStatus($ebook->subject_id);

        return redirect()->route('admin.ebooks.index')->with('success', 'E-book berhasil ditambahkan.');
    }

    public function edit(Ebook $ebook): View
    {
        $classOrder = "CASE WHEN name = 'X' THEN 1 WHEN name LIKE 'XI%' THEN 2 WHEN name LIKE 'XII%' THEN 3 ELSE 4 END";
        $classes = ClassModel::orderByRaw($classOrder)->orderBy('name')->get();
        $subjects = Subject::with('class')
            ->whereRaw("LOWER(name) NOT IN ('ipa', 'ilmu pengetahuan alam', 'ips', 'ilmu pengetahuan sosial')")
            ->orderBy('name')
            ->get();

        return view('admin.ebooks.edit', compact('ebook', 'classes', 'subjects'));
    }

    public function update(Request $request, Ebook $ebook, EbookMetadataExtractor $metadataExtractor): RedirectResponse
    {
        $validated = $request->validate([
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:102400'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'author' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'publication_year' => ['nullable', 'integer', 'between:1901,2155'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $subject = Subject::findOrFail($validated['subject_id']);

        if ($request->hasFile('file')) {
            $metadata = $metadataExtractor->extract($request->file('file'));

            $this->deleteStoredFileIfUnused($ebook->file_path, $ebook->id);

            $validated['title'] = $metadataExtractor->titleForSelectedSubject($metadata['title'], $subject->name);
            $validated['author'] = $request->filled('author') ? trim($validated['author']) : $metadata['author'];
            $validated['publisher'] = $request->filled('publisher') ? trim($validated['publisher']) : $metadata['publisher'];
            $validated['publication_year'] = $request->filled('publication_year')
                ? $validated['publication_year']
                : $metadata['publication_year'];
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
        AuditLog::record('Update', 'Memperbarui data e-book "' . $ebook->title . '"', $ebook);
        $this->syncGroupCoverForEbook($ebook, $ebook->cover_path);

        $updatedSubject = Subject::findOrFail($ebook->subject_id);
        if ($request->hasFile('file')) {
            $updatedSubject->description = $metadataExtractor->buildSubjectDescription(
                $updatedSubject->name,
                $validated['title'] ?? $ebook->title,
                $validated['description'] ?? $ebook->description,
            );
            $updatedSubject->save();
        }

        $this->syncSubjectStatus($oldSubjectId);
        $this->syncSubjectStatus($ebook->subject_id);

        $redirectParams = array_filter([
            'class_id' => $request->input('return_class_id') ?? $request->input('class_id'),
            'subject_id' => $request->input('return_subject_id') ?? $request->input('subject_id'),
        ]);

        return redirect()->route('admin.ebooks.index', $redirectParams)->with('success', 'E-book berhasil diperbarui.');
    }

    public function destroy(Request $request, Ebook $ebook): RedirectResponse
    {
        if (! $request->boolean('force_delete')) {
            return back()->withErrors([
                'delete' => 'Penghapusan ebook tidak diizinkan tanpa konfirmasi eksplisit.',
            ]);
        }

        $title = $ebook->title;
        $subjectId = $ebook->subject_id;

        $this->deleteStoredFileIfUnused($ebook->file_path, $ebook->id);
        $this->deleteStoredFileIfUnused($ebook->cover_path, $ebook->id, 'cover_path');

        $ebook->delete();
        AuditLog::record('Delete', 'Menghapus e-book "' . $title . '"');
        $this->syncSubjectStatus($subjectId);

        $redirectParams = array_filter([
            'class_id' => $request->input('return_class_id') ?? $request->input('class_id'),
            'subject_id' => $request->input('return_subject_id') ?? $request->input('subject_id'),
        ]);

        return redirect()->route('admin.ebooks.index', $redirectParams)->with('success', 'E-book berhasil dihapus.');
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

    /**
     * Sebarkan ebook ke sub-mapel cabang jika subject yang dipilih admin
     * adalah umbrella IPA/IPS (biasa maupun varian seperti "IPA Revisi").
     *
     * Contoh:
     *  - Subject "IPA"        → sebarkan ke "Kimia", "Fisika", "Biologi"
     *  - Subject "IPA Revisi" → sebarkan ke "IPA Revisi/Kimia", "IPA Revisi/Fisika", "IPA Revisi/Biologi"
     *  - Subject "IPS"        → sebarkan ke "Sosiologi", "Geografi", "Ekonomi"
     *  - Subject "IPS Revisi" → sebarkan ke "IPS Revisi/Sosiologi", "IPS Revisi/Geografi", "IPS Revisi/Ekonomi"
     *
     * Sub-mapel dibuat otomatis jika belum ada.
     */
    private function spreadEbookToUmbrellaSubjects(
        Ebook $ebook,
        Subject $subject,
        EbookMetadataExtractor $metadataExtractor,
    ): void {
        [$umbrellaPrefix, $branchNames] = $this->groupSubjectNamesForSharedCover($subject);

        if ($branchNames === []) {
            return;
        }

        $isVariant = $umbrellaPrefix !== null;

        foreach ($branchNames as $branchName) {
            // Nama sub-mapel: "Kimia" untuk IPA biasa, "IPA Revisi/Kimia" untuk varian
            $subjectName = $isVariant
                ? $umbrellaPrefix.'/'.$branchName
                : $branchName;

            $branchSubject = Subject::firstOrCreate(
                [
                    'class_id' => $subject->class_id,
                    'name'     => $subjectName,
                ],
                [
                    'code'        => null,
                    'description' => 'Mata pelajaran dibuat otomatis dari '.($umbrellaPrefix ?? ($subject->name)).'. Berisi materi '.$branchName.'.',
                    'is_active'   => false,
                ]
            );

            // Jangan duplikasi jika ebook sudah ada di sub-mapel ini
            $alreadyExists = Ebook::where('subject_id', $branchSubject->id)
                ->where('file_path', $ebook->file_path)
                ->exists();

            if ($alreadyExists) {
                continue;
            }

            $branchEbook = Ebook::create([
                'subject_id'       => $branchSubject->id,
                'title'            => $metadataExtractor->titleForSelectedSubject($ebook->title, $subjectName),
                'description'      => $ebook->description,
                'author'           => $ebook->author,
                'publisher'        => $ebook->publisher,
                'publication_year' => $ebook->publication_year,
                'file_path'        => $ebook->file_path,
                'cover_path'       => $ebook->cover_path,
                'is_active'        => $ebook->is_active,
            ]);

            $this->syncSubjectStatus($branchSubject->id);
        }
    }

    private function syncGroupCoverForEbook(Ebook $ebook, ?string $coverPath): void
    {
        if (! $coverPath || ! $ebook->subject_id) {
            return;
        }

        $subject = $ebook->subject()->first();

        if (! $subject) {
            return;
        }

        $matchPatterns = $this->sharedCoverMatchPatterns($subject);

        if ($matchPatterns === []) {
            return;
        }

        $subjectIds = Subject::query()
            ->where('class_id', $subject->class_id)
            ->where(function ($query) use ($matchPatterns) {
                foreach ($matchPatterns as $matchPattern) {
                    $query->orWhereRaw('LOWER(name) LIKE ?', ['%'.$matchPattern.'%']);
                }
            })
            ->pluck('id');

        if ($subjectIds->isEmpty()) {
            return;
        }

        Ebook::query()
            ->whereIn('subject_id', $subjectIds)
            ->update(['cover_path' => $coverPath]);
    }

    private function sharedCoverMatchPatterns(Subject $subject): array
    {
        [$umbrellaPrefix, $branchNames] = $this->groupSubjectNamesForSharedCover($subject);

        if ($branchNames === []) {
            return [];
        }

        $patterns = [];

        foreach ($branchNames as $branchName) {
            $normalized = mb_strtolower(trim($branchName));

            if ($normalized === '') {
                continue;
            }

            if ($umbrellaPrefix !== null) {
                // Grup revisi: hanya match sub-mapel dalam grup yang sama persis
                // Contoh: "IPA Revisi" -> hanya match "IPA Revisi/Fisika", "IPA Revisi / Kimia", dll.
                $prefix = mb_strtolower(trim($umbrellaPrefix));
                $patterns[] = $prefix.' / '.$normalized;
                $patterns[] = $prefix.'/'.$normalized;
                $patterns[] = $prefix.' '.$normalized;
            } else {
                // Grup IPA/IPS biasa: match nama cabang murni DAN dengan prefix IPA/IPS biasa
                $patterns[] = $normalized;
                $patterns[] = mb_strtolower('IPA / '.$branchName);
                $patterns[] = mb_strtolower('IPA/'.$branchName);
                $patterns[] = mb_strtolower('IPS / '.$branchName);
                $patterns[] = mb_strtolower('IPS/'.$branchName);
            }
        }

        return array_values(array_unique($patterns));
    }

    /**
     * Kembalikan [umbrellaPrefix, branchNames] untuk subject ini.
     *
     * - Jika subject adalah IPA/IPS biasa (nama persis "IPA" atau "IPS"),
     *   umbrellaPrefix = null dan branchNames berisi mapel cabang biasa.
     * - Jika subject adalah varian ("IPA Revisi", "IPS Revisi", dll.),
     *   umbrellaPrefix = nama subject itu sendiri, dan branchNames berisi
     *   nama cabang TANPA prefix (Fisika, Kimia, Biologi / Ekonomi, dst.).
     *   Cover akan disync hanya ke sub-mapel dalam grup itu
     *   ("IPA Revisi/Fisika", "IPA Revisi / Kimia", dst.).
     *
     * @return array{0: ?string, 1: string[]}
     */
    private function groupSubjectNamesForSharedCover(Subject $subject): array
    {
        $normalizedName = mb_strtolower(trim($subject->name));

        // Cek IPA varian ("ipa revisi", "ipa revisi 2013", dll.) — harus bukan persis "ipa"
        if (preg_match('/^ipa(?:\s|$)/u', $normalizedName) && $normalizedName !== 'ipa') {
            return [$subject->name, ['Biologi', 'Fisika', 'Kimia']];
        }

        // IPA biasa (persis "ipa" atau "ilmu pengetahuan alam")
        if ($normalizedName === 'ipa' || $normalizedName === 'ilmu pengetahuan alam') {
            return [null, ['Biologi', 'Fisika', 'Kimia']];
        }

        // Cek IPS varian ("ips revisi", "ips revisi 2013", dll.) — harus bukan persis "ips"
        if (preg_match('/^ips(?:\s|$)/u', $normalizedName) && $normalizedName !== 'ips') {
            return [$subject->name, ['Ekonomi', 'Geografi', 'Sosiologi']];
        }

        // IPS biasa (persis "ips" atau "ilmu pengetahuan sosial")
        if ($normalizedName === 'ips' || $normalizedName === 'ilmu pengetahuan sosial') {
            return [null, ['Ekonomi', 'Geografi', 'Sosiologi']];
        }

        // Mapel cabang memiliki cover masing-masing. Hanya ebook mapel
        // gabungan yang diawali IPA atau IPS yang boleh membagikan cover.
        return [null, []];
    }

    private function resolveSubjectFromMetadata(array $metadata): ?Subject
    {
        if ($metadata['subject']) {
            return $metadata['subject'];
        }

        if (! $metadata['class'] || ! $metadata['detected_subject_name']) {
            return null;
        }

        $description = $metadata['description'] ?: 'Mata pelajaran '.$metadata['detected_subject_name'].' yang berisi materi pembelajaran sesuai kurikulum.';

        $existing = Subject::findByClassAndName($metadata['class']->id, $metadata['detected_subject_name']);

        if ($existing) {
            return $existing;
        }

        return Subject::firstOrCreate(
            [
                'class_id' => $metadata['class']->id,
                'name' => $metadata['detected_subject_name'],
            ],
            [
                'code' => null,
                'description' => Str::limit($description, 500, ''),
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

            return collect(['Sosiologi', 'Geografi', 'Ekonomi'])
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
