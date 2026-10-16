@extends('layouts.admin')

@section('title', 'Data Kelas')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Data Kelas</h1>
        <p class="text-muted small mb-0">Kelola jenjang dan tingkatan kelas perpustakaan digital.</p>
    </div>
    <a href="{{ route('admin.classes.create') }}" class="btn btn-success fw-semibold px-4 py-2 rounded-pill shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kelas
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr class="text-uppercase text-muted" style="font-size: 0.78rem; letter-spacing: 0.05em; border-bottom: 2px solid #edf2f7;">
                    <th style="font-weight: 700; width: 25%; padding: 1rem;">NAMA KELAS</th>
                    <th style="font-weight: 700; width: 40%; padding: 1rem;">DESKRIPSI</th>
                    <th style="font-weight: 700; width: 20%; padding: 1rem;">MATA PELAJARAN</th>
                    <th style="font-weight: 700; width: 15%; padding: 1rem;">AKSI</th>
                </tr>
            </thead>
            <tbody>
            @forelse($classes as $class)
                <tr style="border-bottom: 1px solid #f1f4f8;">
                    <td style="padding: 1rem;">
                        <span class="fw-bold text-dark fs-6">Kelas {{ $class->name }}</span>
                    </td>
                    <td class="text-muted" style="padding: 1rem;">
                        {{ $class->description ?: '-' }}
                    </td>
                    <td style="padding: 1rem;">
                        <span class="badge border border-success-subtle bg-success-subtle text-success px-3 py-1 rounded-pill fw-semibold">
                            <i class="bi bi-journal-bookmark me-1"></i> {{ $class->subjects_count }} Mapel
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        <div class="d-flex gap-1 align-items-center">
                            <a class="btn btn-sm btn-outline-success rounded px-2" href="{{ route('admin.classes.edit', $class) }}" title="Edit Kelas">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" onsubmit="return confirm('Hapus kelas ini? Data mata pelajaran dan e-book terkait juga akan terhapus.');">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="force_delete" value="1">
                                <button class="btn btn-sm btn-outline-danger rounded px-2" type="submit" title="Hapus Kelas">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-muted text-center py-5">Data kelas belum tersedia.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body border-top">{{ $classes->links('vendor.pagination.bootstrap-5-simple') }}</div>
</div>
@endsection
