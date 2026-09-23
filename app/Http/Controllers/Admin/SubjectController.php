<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubjectController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'class_id' => ['nullable', 'integer', 'exists:classes,id'],
        ]);

        $selectedClassId = $validated['class_id'] ?? null;
        $classOrder = "CASE classes.name WHEN 'X' THEN 1 WHEN 'XI' THEN 2 WHEN 'XII' THEN 3 ELSE 4 END";

        $subjects = Subject::query()
            ->select('subjects.*')
            ->join('classes', 'classes.id', '=', 'subjects.class_id')
            ->with('class')
            ->withCount('ebooks')
            ->whereRaw("LOWER(subjects.name) NOT IN ('ipa', 'ilmu pengetahuan alam')")
            ->when($selectedClassId, fn ($query) => $query->where('subjects.class_id', $selectedClassId))
            ->orderByRaw($classOrder)
            ->orderBy('subjects.name')
            ->orderBy('subjects.id')
            ->paginate(10)
            ->withQueryString();

        $subjects->getCollection()->transform(function (Subject $subject) {
            if ($subject->isScienceBranch()) {
                $subject->setAttribute('ebooks_count', $subject->sharedEbooks()->count());
            }

            return $subject;
        });

        $classes = ClassModel::query()
            ->orderByRaw("CASE name WHEN 'X' THEN 1 WHEN 'XI' THEN 2 WHEN 'XII' THEN 3 ELSE 4 END")
            ->orderBy('name')
            ->get();

        return view('admin.subjects.index', compact('subjects', 'classes', 'selectedClassId'));
    }

    public function create(): View
    {
        $classes = ClassModel::where('is_active', true)->orderBy('name')->get();

        return view('admin.subjects.create', compact('classes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'class_id' => ['required', 'exists:classes,id'],
            'name' => ['required', 'string', 'max:150'],
            'code' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = false;

        Subject::create($validated);

        return redirect()->route('admin.subjects.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(Subject $subject): View
    {
        $classes = ClassModel::orderBy('name')->get();

        return view('admin.subjects.edit', compact('subject', 'classes'));
    }

    public function update(Request $request, Subject $subject): RedirectResponse
    {
        $validated = $request->validate([
            'class_id' => ['required', 'exists:classes,id'],
            'name' => ['required', 'string', 'max:150'],
            'code' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = $subject->ebooks()->where('is_active', true)->exists();

        $subject->update($validated);

        return redirect()->route('admin.subjects.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Subject $subject): RedirectResponse
    {
        $subject->delete();

        return redirect()->route('admin.subjects.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
