@extends('layouts.public')

@section('title', 'Perpustakaan Digital SMAN 1 Cikampek')

@section('content')
<section class="hero py-5">
    <div class="container py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="eyebrow mb-2">Ruang belajar tanpa batas</p>
                <h1 class="display-5 fw-bold">Temukan ilmu,<br>mulai dari sini.</h1>
                <p class="lead mt-3 mb-0">Buku pelajaran dan materi digital SMAN 1 Cikampek, tersusun rapi untuk menemani proses belajarmu.</p>
                <form action="{{ route('home') }}" method="GET" class="hero-panel hero-search p-3 mt-4">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-lg" placeholder="Cari judul, mata pelajaran, atau penulis">
                        </div>
                        <div class="col-md-3">
                            <select name="class" class="form-select form-select-lg">
                                <option value="">Semua kelas</option>
                                @foreach($classOptions as $className)
                                    <option value="{{ $className }}" @selected(request('class') === $className)>Kelas {{ $className }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-light btn-lg w-100 fw-semibold" type="submit">Cari Koleksi</button>
                        </div>
                    </div>
                </form>
                <div class="d-flex flex-wrap align-items-center gap-2 mt-3">
                    <span class="small opacity-75 me-1">Pencarian cepat:</span>
                    @foreach(['Matematika', 'Bahasa Indonesia', 'Biologi'] as $quickSearch)
                        <a class="quick-chip" href="{{ route('library', ['q' => $quickSearch]) }}">{{ $quickSearch }}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-5 hero-collection ps-lg-5">
                <div class="ps-lg-2">
                    <div class="hero-visual">
                        <div class="hero-book hero-book-left"><small>SMAN 1</small><strong>Belajar<br>Lebih Mudah</strong><small>CIKAMPEK</small></div>
                        <div class="hero-book hero-book-main"><small>PERPUSTAKAAN</small><strong>Jelajahi<br>Pengetahuan</strong><small>KOLEKSI DIGITAL</small></div>
                        <div class="hero-book hero-book-right"><small>RUANG</small><strong>Baca.<br>Tumbuh.</strong><small>2026</small></div>
                    </div>
                    <p class="eyebrow mb-2 mt-2">Koleksi kami</p>
                    <h2 class="h5 mb-3">Pilih kelasmu, lalu mulai belajar.</h2>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="hero-stat"><div class="h4 fw-bold mb-0">{{ $stats['classes'] }}</div><div class="small opacity-75">Kelas aktif</div></div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat"><div class="h4 fw-bold mb-0">{{ $stats['subjects'] }}</div><div class="small opacity-75">Mata pelajaran</div></div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat"><div class="h4 fw-bold mb-0">{{ $stats['ebooks'] }}</div><div class="small opacity-75">E-book</div></div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat"><div class="h4 fw-bold mb-0">{{ $stats['accesses'] }}</div><div class="small opacity-75">Total akses</div></div>
                        </div>
                    </div>
                    <a href="{{ route('library') }}" class="btn btn-light mt-4">Jelajahi Semua Koleksi</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container pt-5" data-home-recent hidden>
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div class="section-title"><p class="eyebrow mb-1">Belajarmu</p><h2 class="h4 mb-1">Lanjutkan Belajar</h2><p class="text-muted mb-0">Buku yang terakhir kamu buka pada perangkat ini.</p></div>
        <a href="{{ route('favorites') }}" class="btn btn-outline-success">Lihat semua</a>
    </div>
    <div class="row g-3" data-home-recent-list></div>
</section>

<section class="container pt-5">
    <div class="study-banner">
        <div><p class="eyebrow mb-1">Koleksi pilihan</p><h2 class="h4 mb-2">Siapkan belajar lebih terarah</h2><p class="mb-0 text-muted">Gunakan filter kelas dan mata pelajaran untuk menemukan materi yang sesuai dengan kebutuhan belajarmu.</p></div>
        <a href="{{ route('library', ['sort' => 'popular']) }}" class="btn btn-success">Lihat buku populer</a>
    </div>
</section>

<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div class="section-title">
            <p class="eyebrow mb-1">Temukan materi</p>
            <h2 class="h4 mb-1">Pilih Kelas</h2>
            <p class="text-muted mb-0">Lanjutkan ke mata pelajaran dan buku digital untuk kelasmu.</p>
        </div>
        <a href="{{ route('library') }}" class="btn btn-outline-success">Lihat Semua</a>
    </div>
    <div class="row g-3">
        @forelse($classes as $class)
            <div class="col-md-6 col-lg-4 class-card">
                <a class="info-card card text-decoration-none text-dark h-100" href="{{ route('classes.show', $class) }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <div class="icon-box">{{ $class->name }}</div>
                            <span class="badge badge-soft">{{ $class->subjects_count }} mapel</span>
                        </div>
                        <h3 class="h5 mb-1">Kelas {{ $class->name }}</h3>
                        <p class="text-muted mb-3">{{ $class->description ?: 'Koleksi materi pembelajaran digital.' }}</p>
                        <div class="d-flex align-items-center justify-content-between gap-2 mt-3"><div class="small text-muted">{{ $class->ebooks_count }} e-book tersedia</div><span class="small fw-semibold text-success">Lihat mapel →</span></div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">Data kelas belum tersedia.</div></div>
        @endforelse
    </div>
</section>

<section class="container pb-5">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div class="section-title">
            <p class="eyebrow mb-1">Koleksi terbaru</p>
            <h2 class="h4 mb-1">E-Book Baru Ditambahkan</h2>
            <p class="text-muted mb-0">Buku digital yang siap dibaca atau diunduh.</p>
        </div>
    </div>
    <div class="row g-3">
        @forelse($latestEbooks as $ebook)
            <div class="col-6 col-md-4 col-lg-3">
                <article class="collection-card info-card card h-100">
                    <a class="text-decoration-none text-dark" href="{{ route('ebooks.show', $ebook) }}">
                        <div class="book-card-image">
                            <span class="badge text-bg-light text-success book-badge">Terbaru</span>
                            @include('public._book-cover', ['ebook' => $ebook])
                        </div>
                        <div class="card-body">
                            <span class="badge badge-soft mb-2">Kelas {{ $ebook->subject->class->name ?? '-' }}</span>
                            <h3 class="h6 book-title mb-2">{{ $ebook->title }}</h3>
                            <p class="book-meta text-muted small mb-0">{{ $ebook->author ?: 'Penulis belum diisi' }}<br>{{ $ebook->publication_year ?: 'Tahun belum diisi' }}</p>
                        </div>
                    </a>
                    <div class="card-footer book-card-footer"><a href="{{ route('ebooks.show', $ebook) }}" class="small fw-semibold text-decoration-none">Baca E-Book</a><span class="small text-muted">PDF</span></div>
                </article>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">E-book belum tersedia.</div></div>
        @endforelse
    </div>
</section>

<section class="container pb-5">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div class="section-title">
            <p class="eyebrow mb-1">Pilihan siswa</p>
            <h2 class="h4 mb-1">Paling Sering Dibaca</h2>
            <p class="text-muted mb-0">Koleksi yang paling banyak diakses oleh pembaca.</p>
        </div>
        <a href="{{ route('library') }}" class="btn btn-outline-success">Lihat Katalog</a>
    </div>
    <div class="row g-3">
        @forelse($popularEbooks as $ebook)
            <div class="col-6 col-md-4 col-lg-3">
                <article class="collection-card info-card card h-100">
                    <a class="text-decoration-none text-dark" href="{{ route('ebooks.show', $ebook) }}">
                        <div class="book-card-image">
                            <span class="badge text-bg-warning book-badge">Populer</span>
                            @include('public._book-cover', ['ebook' => $ebook])
                        </div>
                        <div class="card-body">
                            <span class="badge badge-soft mb-2">Kelas {{ $ebook->subject->class->name ?? '-' }}</span>
                            <h3 class="h6 book-title mb-2">{{ $ebook->title }}</h3>
                            <p class="book-meta text-muted small mb-0">{{ $ebook->author ?: 'Penulis belum diisi' }}<br>{{ $ebook->access_logs_count }} kali dibuka</p>
                        </div>
                    </a>
                    <div class="card-footer book-card-footer"><a href="{{ route('ebooks.show', $ebook) }}" class="small fw-semibold text-decoration-none">Baca E-Book</a><span class="small text-muted">PDF</span></div>
                </article>
            </div>
        @empty
            <div class="col-12"><div class="empty-state text-muted">Belum ada data bacaan populer.</div></div>
        @endforelse
    </div>
</section>
@endsection
