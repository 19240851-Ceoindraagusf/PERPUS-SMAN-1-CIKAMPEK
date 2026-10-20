@extends('layouts.admin')

@section('title', 'Data E-Book')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Data E-Book</h1>
        <p class="text-muted small mb-0">Kelola katalog modul dan buku pelajaran digital perpustakaan.</p>
    </div>
    <a href="{{ route('admin.ebooks.create') }}" class="btn btn-success fw-semibold px-4 py-2 rounded-pill shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah E-Book
    </a>
</div>

{{-- Filter Card --}}
<form method="GET" class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3 p-md-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small text-muted fw-semibold mb-1" for="class_id">Filter Kelas</label>
                <select name="class_id" id="class_id" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected((string) $selectedClassId === (string) $class->id)>
                            Kelas {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label small text-muted fw-semibold mb-1" for="subject_id">Filter Mata Pelajaran</label>
                <select name="subject_id" id="subject_id" class="form-select">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" @selected((string) $selectedSubjectId === (string) $subject->id)>
                            {{ $subject->name }} (Kelas {{ $subject->class->name ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-success fw-semibold px-4 flex-grow-1">
                    <i class="bi bi-funnel me-1"></i> Terapkan
                </button>
                @if($selectedClassId || $selectedSubjectId)
                    <a href="{{ route('admin.ebooks.index') }}" class="btn btn-outline-secondary px-3">
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
                    <th style="font-weight: 700; width: 6%; padding: 1rem;">COVER</th>
                    <th style="font-weight: 700; width: 28%; padding: 1rem;">JUDUL & MAPEL</th>
                    <th style="font-weight: 700; width: 18%; padding: 1rem;">PENULIS</th>
                    <th style="font-weight: 700; width: 18%; padding: 1rem;">PENERBIT</th>
                    <th style="font-weight: 700; width: 8%; padding: 1rem;">TAHUN</th>
                    <th style="font-weight: 700; width: 8%; padding: 1rem;">STATUS</th>
                    <th style="font-weight: 700; width: 14%; padding: 1rem;">AKSI</th>
                </tr>
            </thead>
            <tbody>
            @forelse($ebooks as $ebook)
                <tr style="border-bottom: 1px solid #f1f4f8;">
                    <td style="padding: 0.85rem 1rem;">
                        @if($ebook->cover_path)
                            <img src="{{ asset('storage/' . $ebook->cover_path) }}" alt="Cover" class="rounded shadow-sm" style="width: 44px; height: 58px; object-fit: cover; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.25)';" onmouseout="this.style.transform='scale(1)';">
                        @else
                            <div class="rounded shadow-sm d-flex align-items-center justify-content-center bg-light text-muted" style="width: 44px; height: 58px; font-size: 1.25rem;">
                                <i class="bi bi-book"></i>
                            </div>
                        @endif
                    </td>
                    <td style="padding: 0.85rem 1rem;">
                        <a href="{{ route('ebooks.show', $ebook) }}" class="fw-bold text-dark text-decoration-none d-block mb-1" target="_blank">
                            {{ $ebook->title }}
                        </a>
                        <div class="d-flex align-items-center gap-1">
                            <span class="badge border border-success-subtle bg-success-subtle text-success" style="font-size: 0.7rem;">Kelas {{ $ebook->subject->class->name ?? '-' }}</span>
                            <span class="small text-muted" style="font-size: 0.78rem;">{{ $ebook->subject->name ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="text-muted small" style="padding: 0.85rem 1rem;">
                        {{ \Illuminate\Support\Str::limit($ebook->author ?: '-', 45) }}
                    </td>
                    <td class="text-muted small" style="padding: 0.85rem 1rem;">
                        {{ \Illuminate\Support\Str::limit($ebook->publisher ?: '-', 45) }}
                    </td>
                    <td class="small" style="padding: 0.85rem 1rem;">
                        {{ $ebook->publication_year ?: '-' }}
                    </td>
                    <td style="padding: 0.85rem 1rem;">
                        @if($ebook->is_active)
                            <span class="badge border border-success-subtle bg-success-subtle text-success px-2 py-1 rounded" style="font-size: 0.75rem;">
                                Aktif
                            </span>
                        @else
                            <span class="badge border border-secondary-subtle bg-light text-secondary px-2 py-1 rounded" style="font-size: 0.75rem;">
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td style="padding: 0.85rem 1rem;">
                        <div class="d-flex gap-1 align-items-center">
                            @if($ebook->file_path)
                                <a class="btn btn-sm btn-outline-info rounded px-2" href="{{ asset('storage/' . $ebook->file_path) }}" target="_blank" rel="noopener noreferrer" title="Buka PDF">
                                    <i class="bi bi-eye"></i>
                                </a>
                            @endif
                            <a class="btn btn-sm btn-outline-success rounded px-2" href="{{ route('admin.ebooks.edit', ['ebook' => $ebook, 'class_id' => request('class_id'), 'subject_id' => request('subject_id')]) }}" title="Edit E-Book">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.ebooks.destroy', $ebook) }}" onsubmit="return confirm('Hapus e-book ini?');">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="force_delete" value="1">
                                @if(request('class_id') || request('subject_id'))
                                    <input type="hidden" name="return_class_id" value="{{ request('class_id') }}">
                                    <input type="hidden" name="return_subject_id" value="{{ request('subject_id') }}">
                                @endif
                                <button class="btn btn-sm btn-outline-danger rounded px-2" type="submit" title="Hapus E-Book">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center py-5"><div class="empty-state"><i class="bi bi-journal-x fs-2 text-success d-block mb-2"></i><strong class="d-block mb-1">Belum ada e-book pada pilihan ini</strong><span class="text-muted small">Ubah filter kelas atau mata pelajaran, atau tambahkan koleksi baru.</span></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body border-top">{{ $ebooks->links('vendor.pagination.bootstrap-5-simple') }}</div>
</div>
@endsection
