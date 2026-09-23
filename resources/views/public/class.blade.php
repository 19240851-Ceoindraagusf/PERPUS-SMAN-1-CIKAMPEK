@extends('layouts.public')

@section('title', 'Materi Kelas ' . $class->name)

@section('content')
<section class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('library') }}">Perpustakaan</a></li>
            <li class="breadcrumb-item active">Kelas {{ $class->name }}</li>
        </ol>
    </nav>
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Materi Pembelajaran Kelas {{ $class->name }}</h1>
            <p class="text-muted mb-0">{{ $totalSubjects }} mata pelajaran tersedia untuk kelas ini.</p>
        </div>
        <a href="{{ route('library') }}" class="btn btn-outline-success">Ganti Kelas</a>
    </div>
    <form action="{{ route('classes.show', $class) }}" method="GET" class="search-panel mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-lg">
                <label class="form-label small text-muted" for="q">Cari mata pelajaran</label>
                <input type="search" class="form-control" id="q" name="q" value="{{ $search }}" placeholder="Contoh: Bahasa Inggris, Matematika, Kimia">
            </div>
            <div class="col-lg-auto">
                <button class="btn btn-success" type="submit">Cari</button>
            </div>
            @if($search)
                <div class="col-lg-auto">
                    <a class="btn btn-outline-secondary" href="{{ route('classes.show', $class) }}">Reset</a>
                </div>
            @endif
        </div>
    </form>
    @if($search)
        <p class="text-muted small mb-3">Menampilkan {{ $class->subjects->count() }} hasil untuk "{{ $search }}".</p>
    @endif
    <div class="row g-3">
        @forelse($class->subjects as $subject)
            <div class="col-md-6 col-lg-4">
                <a class="info-card card h-100 text-decoration-none text-dark" href="{{ route('subjects.show', [$class, $subject]) }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <div class="icon-box">{{ strtoupper(substr($subject->name, 0, 1)) }}</div>
                            <span class="badge badge-soft">{{ $subject->ebooks_count }} e-book</span>
                        </div>
                        <h2 class="h5">{{ $subject->name }}</h2>
                        <p class="text-muted mb-0">{{ $subject->description ?: 'Materi dan referensi pembelajaran.' }}</p>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">{{ $search ? 'Mata pelajaran tidak ditemukan. Coba kata kunci lain.' : 'Mata pelajaran belum tersedia.' }}</div></div>
        @endforelse
    </div>
</section>
@endsection
