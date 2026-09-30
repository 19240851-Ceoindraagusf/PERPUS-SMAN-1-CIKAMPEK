<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Services\EbookFileCleanup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClassController extends Controller
{
    public function index(): View
    {
        $classes = ClassModel::withCount('subjects')
            ->orderByRaw("CASE WHEN name = 'X' THEN 1 WHEN name LIKE 'XI%' THEN 2 WHEN name LIKE 'XII%' THEN 3 ELSE 4 END")
            ->orderBy('name')
            ->paginate(10);

        return view('admin.classes.index', compact('classes'));
    }

    public function create(): View
    {
        return view('admin.classes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:classes,name'],
            'description' => ['nullable', 'string'],
        ]);

        ClassModel::create($validated);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(ClassModel $class): View
    {
        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, ClassModel $class): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:classes,name,'.$class->id],
            'description' => ['nullable', 'string'],
        ]);

        $class->update($validated);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Request $request, ClassModel $class, EbookFileCleanup $ebookFileCleanup): RedirectResponse
    {
        if (! $request->boolean('force_delete')) {
            return back()->withErrors([
                'delete' => 'Penghapusan kelas tidak diizinkan tanpa konfirmasi eksplisit.',
            ]);
        }

        $class->subjects()->with('ebooks')->get()->each(function ($subject) use ($ebookFileCleanup) {
            $subject->ebooks->each(fn ($ebook) => $ebookFileCleanup->delete($ebook));
            $subject->delete();
        });

        $class->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Kelas beserta mata pelajaran dan e-book terkait berhasil dihapus.');
    }
}
