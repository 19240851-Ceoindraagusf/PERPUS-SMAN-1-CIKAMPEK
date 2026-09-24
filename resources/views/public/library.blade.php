@extends('layouts.public')

@section('title', 'Perpustakaan Digital')

@section('content')
<section class="container py-5">
    <div class="section-title mb-4">
        <h1 class="h3 mb-1">Perpustakaan Digital</h1>
        <p class="text-muted mb-0">Cari kelas, mata pelajaran, atau e-book yang dibutuhkan.</p>
    </div>
    <form action="{{ route('library') }}" method="GET" class="search-panel mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-lg">
                <label class="form-label small text-muted" for="q">Kata kunci</label>
                <input type="search" class="form-control" id="q" name="q" value="{{ $search }}" placeholder="Contoh: Matematika, X, Biologi">
            </div>
            <div class="col-lg-3">
                <label class="form-label small text-muted" for="class">Kelas</label>
                <select class="form-select" id="class" name="class">
                    <option value="">Semua kelas</option>
                    @foreach($classOptions as $className)
                        <option value="{{ $className }}" @selected($selectedClass === $className)>Kelas {{ $className }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <label class="form-label small text-muted" for="subject">Mata pelajaran</label>
                <select class="form-select" id="subject" name="subject">
                    <option value="">Semua mata pelajaran</option>
                    @foreach($subjectOptions as $subjectName)
                        <option value="{{ $subjectName }}" @selected($selectedSubject === $subjectName)>{{ $subjectName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-auto">
                <button class="btn btn-success" type="submit">Terapkan</button>
            </div>
            @if($search || $selectedClass || $selectedSubject)
                <div class="col-lg-auto">
                    <a class="btn btn-outline-secondary" href="{{ route('library') }}">Reset</a>
                </div>
            @endif
        </div>
    </form>
    <div class="row g-3">
        @forelse($classes as $class)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('classes.show', $class) }}" class="info-card card h-100 text-decoration-none text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <div class="icon-box">{{ $class->name }}</div>
                            <span class="badge badge-soft">{{ $class->ebooks_count }} e-book</span>
                        </div>
                        <h2 class="h4">Kelas {{ $class->name }}</h2>
                        <p class="text-muted mb-3">{{ $class->description ?: 'Koleksi materi pembelajaran digital.' }}</p>
                        <div class="small text-muted">{{ $class->subjects_count }} mata pelajaran aktif</div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">Data kelas belum tersedia.</div></div>
        @endforelse
    </div>
</section>
@endsection
