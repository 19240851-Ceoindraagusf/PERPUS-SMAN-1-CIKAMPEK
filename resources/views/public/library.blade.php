@extends('layouts.public')

@section('title', 'Perpustakaan Digital')
@section('meta_description', 'Jelajahi katalog buku pelajaran digital SMAN 1 Cikampek berdasarkan kelas, mata pelajaran, penulis, dan tahun terbit.')

@section('content')
<section class="container py-5">
    <div class="section-title mb-4">
        <p class="eyebrow mb-1">Katalog pembelajaran</p>
        <h1 class="h3 mb-1">Temukan Buku dan Materi</h1>
        <p class="text-muted mb-0">Gunakan kata kunci atau filter untuk menemukan e-book yang sesuai.</p>
    </div>
    <form action="{{ route('library') }}" method="GET" class="search-panel mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-lg-4 position-relative">
                <label class="form-label small text-muted" for="q">Kata kunci</label>
                <input type="search" class="form-control" id="q" name="q" value="{{ $search }}" data-smart-search autocomplete="off" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="catalog-search-suggestions" placeholder="Contoh: Matematika, X, Biologi">
                <div class="search-suggestions" id="catalog-search-suggestions" data-search-suggestions role="listbox" hidden></div>
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
            <div class="col-lg-2">
                <label class="form-label small text-muted" for="year">Tahun terbit</label>
                <select class="form-select" id="year" name="year">
                    <option value="">Semua tahun</option>
                    @foreach($yearOptions as $year)
                        <option value="{{ $year }}" @selected((string) $selectedYear === (string) $year)>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <label class="form-label small text-muted" for="author">Penulis</label>
                <select class="form-select" id="author" name="author">
                    <option value="">Semua penulis</option>
                    @foreach($authorOptions as $author)
                        <option value="{{ $author }}" @selected($selectedAuthor === $author)>{{ $author }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <label class="form-label small text-muted" for="sort">Urutkan</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="newest" @selected($sort === 'newest')>Terbaru ditambahkan</option>
                    <option value="popular" @selected($sort === 'popular')>Paling sering dibaca</option>
                    <option value="title" @selected($sort === 'title')>Judul A–Z</option>
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
            @if($search || $selectedClass || $selectedSubject || $selectedYear || $selectedAuthor || $sort !== 'newest')
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
                    <h2 class="h4 mb-1">Koleksi E-Book</h2>
                    <p class="text-muted mb-0">Menampilkan {{ $matchedEbooks->total() }} buku{{ $search ? ' untuk “' . $search . '”' : '' }}.</p>
                </div>
            </div>
            <div class="row g-3">
                @foreach($matchedEbooks as $ebook)
                    <div class="col-md-6 col-lg-4">
                        <article class="collection-card info-card card h-100">
                            <div class="card-body d-flex gap-3">
                                <a href="{{ route('ebooks.show', $ebook) }}" class="book-row-cover">
                                    @include('public._book-cover', ['ebook' => $ebook])
                                </a>
                                <div class="min-w-0">
                                    <span class="badge badge-soft mb-2">Kelas {{ $ebook->subject->class->name ?? '-' }}</span>
                                    <h3 class="h6 mb-2"><a href="{{ route('ebooks.show', $ebook) }}" class="text-decoration-none text-dark">{{ $ebook->title }}</a></h3>
                                    <p class="text-muted small mb-2">{{ $ebook->author ?: 'Penulis belum diisi' }} · {{ $ebook->publication_year ?: 'Tahun belum diisi' }}</p>
                                    <a href="{{ route('ebooks.show', $ebook) }}" class="small fw-semibold text-decoration-none">Buka buku</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $matchedEbooks->onEachSide(1)->links() }}</div>
        </div>
    @else
        <div class="empty-state mb-5">
            <h2 class="h5">Buku tidak ditemukan</h2>
            @if($suggestedSearch)
                <p class="mb-2">Mungkin maksud Anda <a class="fw-semibold" href="{{ route('library', ['q' => $suggestedSearch]) }}">{{ $suggestedSearch }}</a>?</p>
            @endif
            <p class="text-muted mb-3">Coba gunakan kata kunci lebih singkat, hapus salah satu filter, atau jelajahi mata pelajaran populer.</p>
            <div class="d-flex justify-content-center flex-wrap gap-2 mb-3"><a class="btn btn-sm btn-outline-success" href="{{ route('library', ['q' => 'Matematika']) }}">Matematika</a><a class="btn btn-sm btn-outline-success" href="{{ route('library', ['q' => 'Bahasa Indonesia']) }}">Bahasa Indonesia</a><a class="btn btn-sm btn-outline-success" href="{{ route('library', ['q' => 'Biologi']) }}">Biologi</a></div>
            <a href="{{ route('library') }}" class="btn btn-outline-success">Reset katalog</a>
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
