@extends('layouts.public')

@section('title', 'Perpustakaan Digital SMAN 1 Cikampek')
@section('meta_description', 'Temukan buku pelajaran dan materi digital SMAN 1 Cikampek untuk belajar kapan saja.')

@section('content')
<section class="hero py-5">
    <div class="hero-bg-shapes" aria-hidden="true"></div>
    <div class="container py-4 position-relative" style="z-index: 2;">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="eyebrow mb-2">Ruang belajar tanpa batas</p>
                <h1 class="display-5 fw-bold">Temukan ilmu,<br>mulai dari sini.</h1>
                <p class="lead mt-3 mb-0">Buku pelajaran dan materi digital SMAN 1 Cikampek, tersusun rapi untuk menemani proses belajarmu.</p>
                <form action="{{ route('home') }}" method="GET" class="hero-panel hero-search p-3 mt-4">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6 position-relative">
                            <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-lg pe-5" data-smart-search autocomplete="off" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="hero-search-suggestions" placeholder="Cari judul, mata pelajaran, atau penulis...">
                            <span class="search-shortcut-badge position-absolute end-0 top-50 translate-middle-y me-3 d-none d-md-inline-block">Ctrl K</span>
                            <div class="search-suggestions" id="hero-search-suggestions" data-search-suggestions role="listbox" hidden></div>
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
            <div class="col-lg-5 hero-collection ps-lg-4">
                <div class="hero-panel p-4 rounded-4 shadow-lg position-relative overflow-hidden" style="border: 1px solid rgba(255,255,255,0.22); background: rgba(255,255,255,0.12); backdrop-filter: blur(16px);">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="badge rounded-pill px-3 py-1 bg-white bg-opacity-25 text-white border border-white border-opacity-25 fw-semibold" style="font-size: 0.78rem;">
                            <i class="bi bi-shield-check me-1"></i> Kurikulum Merdeka
                        </span>
                        <span class="small text-white-50"><i class="bi bi-wifi me-1"></i> Akses 24 Jam</span>
                    </div>

                    <h2 class="h5 text-white fw-bold mb-3">E-Book Pembelajaran Digital</h2>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="hero-stat p-3 rounded-3" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-mortarboard text-warning fs-5"></i>
                                    <div class="h4 fw-bold mb-0 text-white">{{ $stats['classes'] }}</div>
                                </div>
                                <div class="small text-white-50">Tingkat Kelas</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat p-3 rounded-3" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-journal-bookmark text-info fs-5"></i>
                                    <div class="h4 fw-bold mb-0 text-white">{{ $stats['subjects'] }}</div>
                                </div>
                                <div class="small text-white-50">Mata Pelajaran</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat p-3 rounded-3" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-book text-success fs-5"></i>
                                    <div class="h4 fw-bold mb-0 text-white">{{ $stats['ebooks'] }}</div>
                                </div>
                                <div class="small text-white-50">Koleksi E-Book</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat p-3 rounded-3" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-eye text-primary fs-5"></i>
                                    <div class="h4 fw-bold mb-0 text-white">{{ $stats['reads'] }}</div>
                                </div>
                                <div class="small text-white-50">Sesi Dibaca</div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('library') }}" class="btn btn-light w-100 fw-bold rounded-pill py-2 shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <span>Jelajahi Semua Koleksi</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container pt-5" data-home-recent hidden>
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div class="section-title">
            <span class="badge px-3 py-2 rounded-pill mb-2" style="background: rgba(15, 107, 79, 0.12); color: var(--school-green); font-weight: 700; font-size: 0.78rem; letter-spacing: 0.05em; text-transform: uppercase;">
                <i class="bi bi-clock-history me-1"></i> Ruang Belajar Mandiri
            </span>
            <h2 class="h3 fw-bold mb-1">Lanjutkan Belajar</h2>
            <p class="text-muted mb-0">Lanjutkan membaca buku digital dari sesi terakhirmu pada perangkat ini.</p>
        </div>
        <a href="{{ route('favorites') }}" class="btn btn-outline-success rounded-pill px-4">
            <i class="bi bi-bookmark-heart me-1"></i> Semua Favorit & Riwayat
        </a>
    </div>
    <div class="row g-4" data-home-recent-list></div>
</section>

<section class="container pt-5">
    <div class="study-banner-premium p-4 p-md-5 rounded-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 shadow-sm">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box text-white flex-shrink-0 shadow" style="width: 56px; height: 56px; border-radius: 16px; font-size: 1.6rem; background: linear-gradient(135deg, #0f6b4f, #10b981);">
                <i class="bi bi-compass-fill"></i>
            </div>
            <div>
                <span class="badge px-3 py-1 rounded-pill mb-1" style="background: rgba(15,107,79,0.12); color: var(--school-green); font-weight: 700; font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase;">
                    Koleksi Kurikulum Digital
                </span>
                <h2 class="h4 fw-bold mb-1">Siapkan Belajar Lebih Terarah & Efektif</h2>
                <p class="mb-0 text-muted">Gunakan filter tingkatan kelas dan mata pelajaran untuk menemukan materi e-book yang sesuai dengan kebutuhan belajarmu.</p>
            </div>
        </div>
        <a href="{{ route('library', ['sort' => 'popular']) }}" class="btn btn-success rounded-pill px-4 py-2 fw-semibold text-nowrap flex-shrink-0 shadow-sm">
            <i class="bi bi-fire me-1"></i> Lihat Buku Populer
        </a>
    </div>
</section>

<section class="container py-5" id="pilih-kelas">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div class="section-title">
            <span class="badge px-3 py-2 rounded-pill mb-2" style="background: rgba(15, 107, 79, 0.12); color: var(--school-green); font-weight: 700; font-size: 0.78rem; letter-spacing: 0.05em; text-transform: uppercase;">
                <i class="bi bi-grid-fill me-1"></i> Direktori Kurikulum
            </span>
            <h2 class="h3 fw-bold mb-1">Pilih Kelas</h2>
            <p class="text-muted mb-0">Temukan mata pelajaran dan buku digital kurikulum merdeka sesuai jenjang kelasmu.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="class-filter-btn-group" role="tablist" aria-label="Filter Tingkat Kelas">
                <button type="button" class="class-filter-pill active" data-filter-class="all">Semua</button>
                <button type="button" class="class-filter-pill" data-filter-class="X">Kelas X</button>
                <button type="button" class="class-filter-pill" data-filter-class="XI">Kelas XI</button>
                <button type="button" class="class-filter-pill" data-filter-class="XII">Kelas XII</button>
            </div>
            <a href="{{ route('library') }}" class="btn btn-outline-success d-none d-md-inline-flex align-items-center gap-1">
                <span>Semua Koleksi</span>
                <i class="bi bi-chevron-right small"></i>
            </a>
        </div>
    </div>
    <div class="row g-4" id="classGrid">
        @forelse($classes as $class)
            @include('public._class_card', ['class' => $class])
        @empty
            <div class="col-12"><div class="empty-state text-center"><div class="saved-empty-icon mb-3 mx-auto"><i class="bi bi-mortarboard"></i></div><h3 class="h5 fw-bold">Koleksi kelas sedang disiapkan</h3><p class="text-muted mb-3">Kelas dan materi akan muncul di sini setelah data perpustakaan diperbarui.</p><a class="btn btn-outline-success rounded-pill px-4" href="{{ route('library') }}">Jelajahi katalog</a></div></div>
        @endforelse
    </div>
</section>

<section class="container pb-5">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div class="section-title">
            <span class="badge px-3 py-2 rounded-pill mb-2" style="background: rgba(37, 99, 235, 0.12); color: #2563eb; font-weight: 700; font-size: 0.78rem; letter-spacing: 0.05em; text-transform: uppercase;">
                <i class="bi bi-sparkles me-1"></i> Rilisan Terbaru
            </span>
            <h2 class="h3 fw-bold mb-1">E-Book Baru Ditambahkan</h2>
            <p class="text-muted mb-0">Buku pelajaran digital dan materi kurikulum terbitan terbaru yang siap dipelajari.</p>
        </div>
        <a href="{{ route('library', ['sort' => 'newest']) }}" class="btn btn-outline-primary rounded-pill px-4">
            <span>Lihat Semua Terbaru</span> <i class="bi bi-arrow-right small ms-1"></i>
        </a>
    </div>
    <div class="row g-4">
        @forelse($latestEbooks as $ebook)
            <div class="col-6 col-md-4 col-lg-3">
                <article class="ebook-modern-card card h-100">
                    <div class="ebook-cover-wrapper position-relative">
                        <span class="ebook-floating-badge badge-new">
                            <i class="bi bi-stars me-1"></i> Baru
                        </span>
                        <a href="{{ route('ebooks.show', $ebook) }}" class="d-block w-100 h-100" title="{{ $ebook->title }}">
                            @include('public._book-cover', ['ebook' => $ebook])
                        </a>
                    </div>
                    <div class="ebook-card-content d-flex flex-column flex-grow-1 p-3">
                        <div class="d-flex flex-wrap align-items-center gap-1 mb-2">
                            <span class="badge badge-soft">Kelas {{ $ebook->subject->class->name ?? '-' }}</span>
                            <span class="badge text-bg-light border small text-muted text-truncate" style="max-width: 120px;">{{ $ebook->subject->name ?? 'Mapel' }}</span>
                        </div>
                        <h3 class="ebook-card-title h6 mb-1" title="{{ $ebook->title }}">
                            <a href="{{ route('ebooks.show', $ebook) }}">{{ $ebook->title }}</a>
                        </h3>
                        <div class="ebook-card-meta small text-muted mb-3">
                            <div class="text-truncate mb-1"><i class="bi bi-person me-1"></i> {{ $ebook->author ?: 'SMAN 1 Cikampek' }}</div>
                            <div class="text-truncate"><i class="bi bi-calendar3 me-1"></i> {{ $ebook->publication_year ?: 'Kurikulum Merdeka' }}</div>
                        </div>
                        <div class="ebook-card-actions mt-auto pt-2 border-top d-flex align-items-center justify-content-between gap-1">
                            <a href="{{ route('ebooks.reader', $ebook) }}" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold flex-grow-1 d-inline-flex align-items-center justify-content-center gap-1" title="Buka dan baca sekarang">
                                <i class="bi bi-book-half"></i> <span>Baca</span>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-1" style="width:32px;height:32px;" title="Simpan ke favorit" data-favorite-button data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}" data-ebook-cover="{{ $ebook->cover_path ? asset('storage/' . $ebook->cover_path) : '' }}" data-ebook-author="{{ $ebook->author ?: '' }}">
                                ♡
                            </button>
                            <a href="{{ route('ebooks.show', $ebook) }}" class="btn btn-sm btn-outline-secondary rounded-circle p-1" style="width:32px;height:32px;display:grid;place-items:center;" title="Detail lengkap">
                                <i class="bi bi-info-circle"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12"><div class="empty-state text-center"><div class="saved-empty-icon mb-3 mx-auto"><i class="bi bi-book"></i></div><h3 class="h5 fw-bold">E-book terbaru akan segera hadir</h3><p class="text-muted mb-3">Sementara itu, jelajahi seluruh koleksi perpustakaan.</p><a class="btn btn-outline-success rounded-pill px-4" href="{{ route('library') }}">Buka katalog</a></div></div>
        @endforelse
    </div>
</section>

<section class="container pb-5">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div class="section-title">
            <span class="badge px-3 py-2 rounded-pill mb-2" style="background: rgba(217, 119, 6, 0.12); color: #d97706; font-weight: 700; font-size: 0.78rem; letter-spacing: 0.05em; text-transform: uppercase;">
                <i class="bi bi-fire me-1"></i> Favorit Siswa
            </span>
            <h2 class="h3 fw-bold mb-1">Paling Sering Dibaca</h2>
            <p class="text-muted mb-0">Koleksi buku favorit yang paling banyak diakses dan dipelajari oleh pembaca.</p>
        </div>
        <a href="{{ route('library', ['sort' => 'popular']) }}" class="btn btn-outline-warning text-dark fw-semibold rounded-pill px-4">
            <span>Lihat Katalog Populer</span> <i class="bi bi-arrow-right small ms-1"></i>
        </a>
    </div>
    <div class="row g-4">
        @forelse($popularEbooks as $ebook)
            <div class="col-6 col-md-4 col-lg-3">
                <article class="ebook-modern-card card h-100">
                    <div class="ebook-cover-wrapper position-relative">
                        <span class="ebook-floating-badge badge-popular">
                            <i class="bi bi-fire me-1"></i> Populer
                        </span>
                        <a href="{{ route('ebooks.show', $ebook) }}" class="d-block w-100 h-100" title="{{ $ebook->title }}">
                            @include('public._book-cover', ['ebook' => $ebook])
                        </a>
                    </div>
                    <div class="ebook-card-content d-flex flex-column flex-grow-1 p-3">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-2">
                            <span class="badge badge-soft">Kelas {{ $ebook->subject->class->name ?? '-' }}</span>
                            <span class="badge rounded-pill text-bg-warning fw-bold text-dark" style="font-size: 0.72rem;">
                                <i class="bi bi-eye-fill me-1"></i> {{ $ebook->reads_count }}x
                            </span>
                        </div>
                        <h3 class="ebook-card-title h6 mb-1" title="{{ $ebook->title }}">
                            <a href="{{ route('ebooks.show', $ebook) }}">{{ $ebook->title }}</a>
                        </h3>
                        <div class="ebook-card-meta small text-muted mb-3">
                            <div class="text-truncate mb-1"><i class="bi bi-person me-1"></i> {{ $ebook->author ?: 'SMAN 1 Cikampek' }}</div>
                            <div class="text-truncate"><i class="bi bi-book me-1"></i> {{ $ebook->subject->name ?? 'Mata Pelajaran' }}</div>
                        </div>
                        <div class="ebook-card-actions mt-auto pt-2 border-top d-flex align-items-center justify-content-between gap-1">
                            <a href="{{ route('ebooks.reader', $ebook) }}" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold flex-grow-1 d-inline-flex align-items-center justify-content-center gap-1" title="Buka dan baca sekarang">
                                <i class="bi bi-book-half"></i> <span>Baca</span>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-1" style="width:32px;height:32px;" title="Simpan ke favorit" data-favorite-button data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}" data-ebook-cover="{{ $ebook->cover_path ? asset('storage/' . $ebook->cover_path) : '' }}" data-ebook-author="{{ $ebook->author ?: '' }}">
                                ♡
                            </button>
                            <a href="{{ route('ebooks.show', $ebook) }}" class="btn btn-sm btn-outline-secondary rounded-circle p-1" style="width:32px;height:32px;display:grid;place-items:center;" title="Detail lengkap">
                                <i class="bi bi-info-circle"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12"><div class="empty-state text-center"><div class="saved-empty-icon mb-3 mx-auto"><i class="bi bi-fire"></i></div><h3 class="h5 fw-bold">Belum ada bacaan populer</h3><p class="text-muted mb-0">Koleksi populer akan terbentuk seiring siswa membaca e-book.</p></div></div>
        @endforelse
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterButtons = document.querySelectorAll('[data-filter-class]');
        const classCols = document.querySelectorAll('.class-card-col');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const target = btn.getAttribute('data-filter-class');

                filterButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                classCols.forEach(col => {
                    const level = col.getAttribute('data-class-level');
                    if (target === 'all' || level === target) {
                        col.classList.remove('is-hidden');
                        col.style.opacity = '0';
                        col.style.transform = 'translateY(8px)';
                        requestAnimationFrame(() => {
                            col.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                            col.style.opacity = '1';
                            col.style.transform = 'translateY(0)';
                        });
                    } else {
                        col.classList.add('is-hidden');
                    }
                });
            });
        });
    });
</script>
@endpush
