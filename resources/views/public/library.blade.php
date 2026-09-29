@extends('layouts.public')

@section('title', 'Perpustakaan Digital')

@section('content')
<section class="container py-5">
    <div class="section-title mb-4">
        <p class="eyebrow mb-1">Katalog pembelajaran</p>
        <h1 class="h3 mb-1">Temukan Buku dan Materi</h1>
        <p class="text-muted mb-0">Gunakan kata kunci atau filter untuk menemukan e-book yang sesuai.</p>
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
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <span class="small text-muted me-1">Jelajahi cepat:</span>
        @foreach($classOptions as $className)
            <a href="{{ route('library', ['class' => $className]) }}" class="btn btn-sm {{ $selectedClass === $className ? 'btn-success' : 'btn-outline-success' }} rounded-pill px-3">Kelas {{ $className }}</a>
        @endforeach
    </div>
    @if($matchedEbooks->isNotEmpty())
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-end gap-3 mb-3">
                <div>
                    <h2 class="h4 mb-1">Hasil Pencarian</h2>
                    <p class="text-muted mb-0">Buku dan materi yang sesuai dengan kata kunci Anda.</p>
                </div>
            </div>
            <div class="row g-3">
                @foreach($matchedEbooks as $ebook)
                    <div class="col-md-6 col-lg-4">
                        <article class="collection-card info-card card h-100">
                            <div class="card-body d-flex gap-3">
                                <a href="{{ route('ebooks.show', $ebook) }}" class="book-row-cover">
                                    @if($ebook->cover_path)
                                        <img src="{{ asset('storage/' . $ebook->cover_path) }}" class="book-cover rounded" alt="Cover {{ $ebook->title }}">
                                    @else
                                        <div class="book-cover-placeholder rounded p-2"><small>E-BOOK</small><strong class="small">{{ $ebook->subject->name ?? 'Materi' }}</strong></div>
                                    @endif
                                </a>
                                <div class="min-w-0">
                                    <span class="badge badge-soft mb-2">Kelas {{ $ebook->subject->class->name ?? '-' }}</span>
                                    <h3 class="h6 mb-2"><a href="{{ route('ebooks.show', $ebook) }}" class="text-decoration-none text-dark">{{ $ebook->title }}</a></h3>
                                    <p class="text-muted small mb-2">{{ $ebook->author ?: 'Penulis belum diisi' }}</p>
                                    <a href="{{ route('ebooks.show', $ebook) }}" class="small fw-semibold text-decoration-none">Buka buku</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="row g-3">
        @forelse($classes as $class)
            <div class="col-md-6 col-lg-4 class-card">
                <a href="{{ route('classes.show', $class) }}" class="info-card card h-100 text-decoration-none text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <div class="icon-box">{{ $class->name }}</div>
                            <span class="badge badge-soft">{{ $class->ebooks_count }} e-book</span>
                        </div>
                        <h2 class="h4">Kelas {{ $class->name }}</h2>
                        <p class="text-muted mb-3">{{ $class->description ?: 'Koleksi materi pembelajaran digital.' }}</p>
                        <div class="d-flex align-items-center justify-content-between gap-2 mt-3"><div class="small text-muted">{{ $class->subjects_count }} mata pelajaran aktif</div><span class="small fw-semibold text-success">Buka koleksi →</span></div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">Data kelas belum tersedia.</div></div>
        @endforelse
    </div>
</section>
@endsection
