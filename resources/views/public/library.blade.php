@extends('layouts.public')

@section('title', 'Perpustakaan Digital')
@section('meta_description', 'Jelajahi katalog buku pelajaran digital SMAN 1 Cikampek berdasarkan kelas, mata pelajaran, penulis, dan tahun terbit.')

@section('content')
<section class="container py-4 py-md-5">
    <!-- Hero Banner Perpustakaan -->
    <div class="library-hero-banner mb-4 mb-md-5">
        <div class="row align-items-center g-4 position-relative" style="z-index: 1;">
            <div class="col-lg-8">
                <span class="badge px-3 py-2 rounded-pill mb-3" style="background: rgba(255, 255, 255, 0.2); color: #fff; font-weight: 700; font-size: 0.8rem; letter-spacing: 0.05em; text-transform: uppercase; backdrop-filter: blur(4px);">
                    <i class="bi bi-book-half me-1 text-warning"></i> Perpustakaan Digital SMAN 1 Cikampek
                </span>
                <h1 class="display-6 fw-bold mb-2 text-white">Katalog & Koleksi E-Book</h1>
                <p class="lead fs-6 opacity-90 mb-0 text-white-50">
                    Akses ribuan materi pelajaran digital kurikulum merdeka, modul pengayaan, dan buku teks resmi yang dapat dibaca secara daring kapan saja.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-inline-flex flex-wrap gap-2 justify-content-lg-end">
                    <div class="favorites-hero-stat">
                        <i class="bi bi-journal-bookmark-fill fs-3 text-warning"></i>
                        <div class="text-start text-white">
                            <div class="stat-num">{{ $matchedEbooks->total() }}</div>
                            <div class="small opacity-75">Buku Ditemukan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel Pencarian & Filter Modern -->
    <div class="library-filter-panel p-4 mb-4">
        <form action="{{ route('library') }}" method="GET" class="search-panel">
            <div class="row g-3 align-items-end">
                <div class="col-lg-4 position-relative">
                    <label class="form-label small fw-semibold text-muted" for="q">
                        <i class="bi bi-search me-1 text-success"></i> Kata Kunci
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control border-start-0 ps-0" id="q" name="q" value="{{ $search }}" data-smart-search autocomplete="off" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="catalog-search-suggestions" placeholder="Contoh: Matematika, X, Biologi...">
                    </div>
                    <div class="search-suggestions" id="catalog-search-suggestions" data-search-suggestions role="listbox" hidden></div>
                </div>
                <div class="col-6 col-lg-2">
                    <label class="form-label small fw-semibold text-muted" for="class">
                        <i class="bi bi-grid-fill me-1 text-primary"></i> Kelas
                    </label>
                    <select class="form-select" id="class" name="class">
                        <option value="">Semua Kelas</option>
                        @foreach($classOptions as $className)
                            <option value="{{ $className }}" @selected($selectedClass === $className)>Kelas {{ $className }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-lg-3">
                    <label class="form-label small fw-semibold text-muted" for="subject">
                        <i class="bi bi-journal-text me-1 text-info"></i> Mata Pelajaran
                    </label>
                    <select class="form-select" id="subject" name="subject">
                        <option value="">Semua Mapel</option>
                        @foreach($subjectOptions as $subjectName)
                            <option value="{{ $subjectName }}" @selected($selectedSubject === $subjectName)>{{ $subjectName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-lg-3">
                    <label class="form-label small fw-semibold text-muted" for="sort">
                        <i class="bi bi-sort-down me-1 text-warning"></i> Urutkan
                    </label>
                    <select class="form-select" id="sort" name="sort">
                        <option value="newest" @selected($sort === 'newest')>Terbaru Ditambahkan</option>
                        <option value="popular" @selected($sort === 'popular')>Paling Sering Dibaca</option>
                        <option value="title" @selected($sort === 'title')>Judul A–Z</option>
                    </select>
                </div>
                <div class="col-6 col-lg-3">
                    <label class="form-label small fw-semibold text-muted" for="year">
                        <i class="bi bi-calendar3 me-1 text-secondary"></i> Tahun Terbit
                    </label>
                    <select class="form-select" id="year" name="year">
                        <option value="">Semua Tahun</option>
                        @foreach($yearOptions as $year)
                            <option value="{{ $year }}" @selected((string) $selectedYear === (string) $year)>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-lg-3">
                    <label class="form-label small fw-semibold text-muted" for="author">
                        <i class="bi bi-person me-1 text-danger"></i> Penulis
                    </label>
                    <select class="form-select" id="author" name="author">
                        <option value="">Semua Penulis</option>
                        @foreach($authorOptions as $author)
                            <option value="{{ $author }}" @selected($selectedAuthor === $author)>{{ $author }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-lg-6 d-flex flex-wrap align-items-center justify-content-lg-end gap-2 mt-3 mt-lg-0">
                    <button class="btn btn-success px-4 rounded-pill fw-semibold shadow-sm" type="submit">
                        <i class="bi bi-funnel-fill me-1"></i> Terapkan Filter
                    </button>
                    @if($search || $selectedClass || $selectedSubject || $selectedYear || $selectedAuthor || $sort !== 'newest')
                        <a class="btn btn-outline-danger rounded-pill px-3" href="{{ route('library') }}">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Chip Filter Aktif (Jika Ada) -->
    @if($search || $selectedClass || $selectedSubject || $selectedYear || $selectedAuthor || $sort !== 'newest')
        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
            <span class="small text-muted fw-semibold me-1"><i class="bi bi-funnel me-1"></i>Filter Aktif:</span>
            @if($search)
                <span class="active-filter-chip">
                    <span>Kata kunci: <strong>{{ $search }}</strong></span>
                </span>
            @endif
            @if($selectedClass)
                <span class="active-filter-chip">
                    <span>Kelas: <strong>{{ $selectedClass }}</strong></span>
                </span>
            @endif
            @if($selectedSubject)
                <span class="active-filter-chip">
                    <span>Mapel: <strong>{{ $selectedSubject }}</strong></span>
                </span>
            @endif
            @if($selectedYear)
                <span class="active-filter-chip">
                    <span>Tahun: <strong>{{ $selectedYear }}</strong></span>
                </span>
            @endif
            @if($selectedAuthor)
                <span class="active-filter-chip">
                    <span>Penulis: <strong>{{ $selectedAuthor }}</strong></span>
                </span>
            @endif
            @if($sort !== 'newest')
                <span class="active-filter-chip">
                    <span>Urutan: <strong>{{ $sort === 'popular' ? 'Terpopuler' : 'Judul A-Z' }}</strong></span>
                </span>
            @endif
            <a href="{{ route('library') }}" class="btn btn-sm btn-link text-danger p-0 text-decoration-none small ms-2 fw-semibold">
                <i class="bi bi-x-circle me-1"></i>Hapus Semua
            </a>
        </div>
    @endif

    <!-- Jelajahi Cepat Per Kelas -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <span class="badge px-3 py-2 rounded-pill" style="background: rgba(15, 107, 79, 0.1); color: var(--school-green); font-weight: 700; font-size: 0.78rem;">
            <i class="bi bi-lightning-charge-fill me-1"></i> Telusuri Cepat:
        </span>
        <a href="{{ route('library') }}" class="btn btn-sm {{ !$selectedClass ? 'btn-success' : 'btn-outline-success' }} rounded-pill px-3">
            Semua Kelas
        </a>
        @foreach($classOptions as $className)
            <a href="{{ route('library', ['class' => $className]) }}" class="btn btn-sm {{ $selectedClass === $className ? 'btn-success' : 'btn-outline-success' }} rounded-pill px-3">
                Kelas {{ $className }}
            </a>
        @endforeach
    </div>

    <!-- Koleksi E-Book Grid -->
    @if($matchedEbooks->isNotEmpty())
        <div class="mb-5">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                <div>
                    <span class="badge px-3 py-2 rounded-pill mb-2" style="background: rgba(15, 107, 79, 0.12); color: var(--school-green); font-weight: 700; font-size: 0.78rem; letter-spacing: 0.05em; text-transform: uppercase;">
                        <i class="bi bi-collection-fill me-1"></i> Katalog Buku Digital
                    </span>
                    <h2 class="h3 fw-bold mb-1">Koleksi E-Book & Modul</h2>
                    <p class="text-muted mb-0">
                        Menampilkan <strong>{{ $matchedEbooks->total() }}</strong> e-book{{ $search ? ' untuk pencarian “' . $search . '”' : '' }}.
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge text-bg-light border text-muted px-3 py-2 rounded-pill small">
                        <i class="bi bi-files me-1"></i> Halaman {{ $matchedEbooks->currentPage() }} dari {{ $matchedEbooks->lastPage() }}
                    </span>
                </div>
            </div>

            <div class="row g-4">
                @foreach($matchedEbooks as $ebook)
                    <div class="col-6 col-md-4 col-lg-3">
                        <article class="ebook-modern-card card h-100">
                            <div class="ebook-cover-wrapper position-relative">
                                @if($ebook->reads_count > 0)
                                    <span class="ebook-floating-badge badge-popular">
                                        <i class="bi bi-fire me-1"></i> {{ $ebook->reads_count }}x
                                    </span>
                                @else
                                    <span class="ebook-floating-badge badge-new">
                                        <i class="bi bi-stars me-1"></i> Baru
                                    </span>
                                @endif
                                <a href="{{ route('ebooks.show', $ebook) }}" class="d-block w-100 h-100" title="{{ $ebook->title }}">
                                    @include('public._book-cover', ['ebook' => $ebook])
                                </a>
                            </div>
                            <div class="ebook-card-content d-flex flex-column flex-grow-1 p-3">
                                <div class="d-flex flex-wrap align-items-center gap-1 mb-2">
                                    <span class="badge badge-soft">Kelas {{ $ebook->subject->class->name ?? '-' }}</span>
                                    <span class="badge text-bg-light border small text-muted text-truncate" style="max-width: 120px;">
                                        {{ $ebook->subject->name ?? 'Mapel' }}
                                    </span>
                                </div>
                                <h3 class="ebook-card-title h6 mb-1" title="{{ $ebook->title }}">
                                    <a href="{{ route('ebooks.show', $ebook) }}">{{ $ebook->title }}</a>
                                </h3>
                                <div class="ebook-card-meta small text-muted mb-3">
                                    <div class="text-truncate mb-1"><i class="bi bi-person me-1"></i> {{ $ebook->author ?: 'SMAN 1 Cikampek' }}</div>
                                    <div class="text-truncate"><i class="bi bi-calendar3 me-1"></i> {{ $ebook->publication_year ?: 'Kurikulum Merdeka' }}</div>
                                </div>
                                <div class="ebook-card-actions mt-auto pt-2 border-top d-flex align-items-center justify-content-between gap-2">
                                    <a href="{{ route('ebooks.reader', $ebook) }}" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold flex-grow-1 d-inline-flex align-items-center justify-content-center gap-1" title="Buka dan baca sekarang">
                                        <i class="bi bi-book-half"></i> <span>Baca</span>
                                    </a>
                                    <a href="{{ route('ebooks.show', $ebook) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-2" title="Detail & info lengkap">
                                        <i class="bi bi-info-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $matchedEbooks->onEachSide(1)->links() }}
            </div>
        </div>
    @else
        <div class="card p-4 p-md-5 text-center rounded-4 border shadow-sm mb-5">
            <div class="saved-empty-icon mb-3 mx-auto" style="width: 70px; height: 70px; border-radius: 50%; background: rgba(15,107,79,0.1); color: var(--school-green); display: grid; place-items: center; font-size: 2rem;">
                <i class="bi bi-journal-x"></i>
            </div>
            <h2 class="h4 fw-bold mb-2">Buku Tidak Ditemukan</h2>
            @if($suggestedSearch)
                <p class="mb-3">
                    Mungkin maksud Anda: 
                    <a class="badge bg-success-subtle text-success border border-success-subtle text-decoration-none px-3 py-2 fs-6" href="{{ route('library', ['q' => $suggestedSearch]) }}">
                        <i class="bi bi-search me-1"></i> {{ $suggestedSearch }}
                    </a>
                </p>
            @endif
            <p class="text-muted mb-4 mx-auto" style="max-width: 480px;">
                Coba gunakan kata kunci lebih singkat, hapus salah satu opsi filter, atau jelajahi mata pelajaran populer berikut:
            </p>
            <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
                <a class="btn btn-sm btn-outline-success rounded-pill px-3" href="{{ route('library', ['q' => 'Matematika']) }}">Matematika</a>
                <a class="btn btn-sm btn-outline-success rounded-pill px-3" href="{{ route('library', ['q' => 'Bahasa Indonesia']) }}">Bahasa Indonesia</a>
                <a class="btn btn-sm btn-outline-success rounded-pill px-3" href="{{ route('library', ['q' => 'Biologi']) }}">Biologi</a>
                <a class="btn btn-sm btn-outline-success rounded-pill px-3" href="{{ route('library', ['q' => 'Fisika']) }}">Fisika</a>
                <a class="btn btn-sm btn-outline-success rounded-pill px-3" href="{{ route('library', ['q' => 'Kimia']) }}">Kimia</a>
                <a class="btn btn-sm btn-outline-success rounded-pill px-3" href="{{ route('library', ['q' => 'Sejarah']) }}">Sejarah</a>
            </div>
            <div>
                <a href="{{ route('library') }}" class="btn btn-success rounded-pill px-4 fw-semibold shadow-sm">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Semua Filter
                </a>
            </div>
        </div>
    @endif

    <!-- Telusuri Per Tingkat Kelas -->
    <div class="mt-5 pt-3">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
            <div class="section-title">
                <span class="badge px-3 py-2 rounded-pill mb-2" style="background: rgba(15, 107, 79, 0.12); color: var(--school-green); font-weight: 700; font-size: 0.78rem; letter-spacing: 0.05em; text-transform: uppercase;">
                    <i class="bi bi-grid-fill me-1"></i> Telusuri Per Tingkat
                </span>
                <h2 class="h4 fw-bold mb-1">Pilih Kelas untuk Belajar</h2>
                <p class="text-muted mb-0">Jelajahi mata pelajaran terstruktur berdasarkan tingkatan dan peminatan kelas.</p>
            </div>
        </div>

        <div class="row g-4">
            @forelse($classes as $class)
                @include('public._class_card', ['class' => $class])
            @empty
                <div class="col-12"><div class="alert alert-info">Data kelas belum tersedia.</div></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
