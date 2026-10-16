@extends('layouts.admin')

@section('title', 'Data Mata Pelajaran')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Data Mata Pelajaran</h1>
        <p class="text-muted small mb-0">Kelola kurikulum dan mata pelajaran untuk setiap tingkatan kelas.</p>
    </div>
    <a href="{{ route('admin.subjects.create') }}" class="btn btn-success fw-semibold px-4 py-2 rounded-pill shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Mata Pelajaran
    </a>
</div>

{{-- Filter Card --}}
<form method="GET" class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3 p-md-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label small text-muted fw-semibold mb-1" for="class_id">Filter Tingkat Kelas</label>
                <select name="class_id" id="class_id" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected((string) $selectedClassId === (string) $class->id)>
                            Kelas {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-success fw-semibold px-4 flex-grow-1">
                    <i class="bi bi-funnel me-1"></i> Terapkan
                </button>
                @if($selectedClassId)
                    <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-secondary px-3">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</form>

{{-- Table Card --}}
<div class="card border-0 shadow-sm rounded-4">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr class="text-uppercase text-muted" style="font-size: 0.78rem; letter-spacing: 0.05em; border-bottom: 2px solid #edf2f7;">
                    <th style="font-weight: 700; width: 30%; padding: 1rem;">MATA PELAJARAN</th>
                    <th style="font-weight: 700; width: 18%; padding: 1rem;">KELAS</th>
                    <th style="font-weight: 700; width: 15%; padding: 1rem;">KODE</th>
                    <th style="font-weight: 700; width: 14%; padding: 1rem;">E-BOOK</th>
                    <th style="font-weight: 700; width: 10%; padding: 1rem;">STATUS</th>
                    <th style="font-weight: 700; width: 13%; padding: 1rem;">AKSI</th>
                </tr>
            </thead>
            <tbody>
            @forelse($subjects as $subject)
                <tr style="border-bottom: 1px solid #f1f4f8;">
                    <td style="padding: 1rem;">
                        <span class="fw-bold text-dark fs-6 d-block">{{ $subject->name }}</span>
                    </td>
                    <td style="padding: 1rem;">
                        <span class="badge border border-primary-subtle bg-primary-subtle text-primary rounded-pill px-2 py-1">
                            Kelas {{ $subject->class->name ?? '-' }}
                        </span>
                    </td>
                    <td class="text-muted small" style="padding: 1rem;">
                        {{ $subject->code ?: '-' }}
                    </td>
                    <td style="padding: 1rem;">
                        <span class="badge border border-success-subtle bg-success-subtle text-success rounded-pill px-2 py-1">
                            <i class="bi bi-book me-1"></i> {{ $subject->ebooks_count }} E-Book
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        @if($subject->is_active)
                            <span class="badge border border-success-subtle bg-success-subtle text-success px-2 py-1 rounded" style="font-size: 0.75rem;">
                                Aktif
                            </span>
                        @else
                            <span class="badge border border-secondary-subtle bg-light text-secondary px-2 py-1 rounded" style="font-size: 0.75rem;">
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1rem;">
                        <div class="d-flex gap-1 align-items-center">
                            <a class="btn btn-sm btn-outline-success rounded px-2" href="{{ route('admin.subjects.edit', ['subject' => $subject, 'class_id' => request('class_id')]) }}" title="Edit Mapel">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.subjects.destroy', $subject) }}" onsubmit="return confirm('Hapus mata pelajaran ini? E-book terkait juga akan terhapus.');">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="force_delete" value="1">
                                @if(request('class_id'))
                                    <input type="hidden" name="return_class_id" value="{{ request('class_id') }}">
                                @endif
                                <button class="btn btn-sm btn-outline-danger rounded px-2" type="submit" title="Hapus Mapel">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-muted text-center py-5">Data mata pelajaran belum tersedia.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body border-top">{{ $subjects->links('vendor.pagination.bootstrap-5-simple') }}</div>
</div>
@endsection
