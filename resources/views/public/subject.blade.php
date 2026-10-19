@extends('layouts.public')

@section('title', 'Mata Pelajaran ' . $subject->name . ' - Kelas ' . $class->name)
@section('meta_description', 'Koleksi e-book dan buku teks digital untuk mata pelajaran ' . $subject->name . ' Kelas ' . $class->name . ' SMAN 1 Cikampek.')

@section('content')
@php
    $norm = strtolower($subject->name);
    
    // Categorize cluster, theme, and icon
    if (str_contains($norm, 'matematika')) {
        $cluster = 'Matematika & Logika';
        $subTheme = 'subject-theme-blue';
        $subIcon = 'bi-calculator-fill';
    } elseif (str_contains($norm, 'fisika')) {
        $cluster = 'Sains & Fisika';
        $subTheme = 'subject-theme-cyan';
        $subIcon = 'bi-lightning-charge-fill';
    } elseif (str_contains($norm, 'kimia')) {
        $cluster = 'Sains & Kimia';
        $subTheme = 'subject-theme-teal';
        $subIcon = 'bi-radioactive';
    } elseif (str_contains($norm, 'biologi')) {
        $cluster = 'Sains & Hayati';
        $subTheme = 'subject-theme-emerald';
        $subIcon = 'bi-flower1';
    } elseif (str_contains($norm, 'ipa') || str_contains($norm, 'sains')) {
        $cluster = 'Ilmu Pengetahuan Alam';
        $subTheme = 'subject-theme-blue';
        $subIcon = 'bi-flask';
    } elseif (str_contains($norm, 'inggris')) {
        $cluster = 'Bahasa Inggris & Asing';
        $subTheme = 'subject-theme-emerald';
        $subIcon = 'bi-translate';
    } elseif (str_contains($norm, 'indonesia')) {
        $cluster = 'Bahasa & Sastra Indonesia';
        $subTheme = 'subject-theme-emerald';
        $subIcon = 'bi-book-half';
    } elseif (str_contains($norm, 'sunda') || str_contains($norm, 'daerah') || str_contains($norm, 'jawa')) {
        $cluster = 'Muatan Lokal & Bahasa Daerah';
        $subTheme = 'subject-theme-emerald';
        $subIcon = 'bi-chat-heart-fill';
    } elseif (str_contains($norm, 'sejarah')) {
        $cluster = 'Sejarah & Peradaban';
        $subTheme = 'subject-theme-amber';
        $subIcon = 'bi-hourglass-split';
    } elseif (str_contains($norm, 'geografi')) {
        $cluster = 'Geografi & Kebumian';
        $subTheme = 'subject-theme-amber';
        $subIcon = 'bi-globe-asia-australia';
    } elseif (str_contains($norm, 'sosiologi')) {
        $cluster = 'Sosiologi & Antropologi';
        $subTheme = 'subject-theme-amber';
        $subIcon = 'bi-people-fill';
    } elseif (str_contains($norm, 'ekonomi') || str_contains($norm, 'akuntansi')) {
        $cluster = 'Ekonomi & Finansial';
        $subTheme = 'subject-theme-amber';
        $subIcon = 'bi-graph-up-arrow';
    } elseif (str_contains($norm, 'pancasila') || str_contains($norm, 'ppkn') || str_contains($norm, 'kewarganegaraan')) {
        $cluster = 'Pancasila & Kebangsaan';
        $subTheme = 'subject-theme-crimson';
        $subIcon = 'bi-shield-fill-check';
    } elseif (str_contains($norm, 'agama') || str_contains($norm, 'islam') || str_contains($norm, 'kristen') || str_contains($norm, 'katolik')) {
        $cluster = 'Agama & Budi Pekerti';
        $subTheme = 'subject-theme-purple';
        $subIcon = 'bi-moon-stars-fill';
    } elseif (str_contains($norm, 'seni') || str_contains($norm, 'budaya') || str_contains($norm, 'musik') || str_contains($norm, 'rupa')) {
        $cluster = 'Seni & Kebudayaan';
        $subTheme = 'subject-theme-rose';
        $subIcon = 'bi-palette-fill';
    } elseif (str_contains($norm, 'pjok') || str_contains($norm, 'penjas') || str_contains($norm, 'olahraga')) {
        $cluster = 'Pendidikan Jasmani & Kesehatan';
        $subTheme = 'subject-theme-orange';
        $subIcon = 'bi-heart-pulse-fill';
    } elseif (str_contains($norm, 'informatika') || str_contains($norm, 'tik') || str_contains($norm, 'komputer')) {
        $cluster = 'Informatika & Teknologi';
        $subTheme = 'subject-theme-indigo';
        $subIcon = 'bi-laptop-fill';
    } elseif (str_contains($norm, 'prakarya') || str_contains($norm, 'pkwu') || str_contains($norm, 'kewirausahaan')) {
        $cluster = 'Prakarya & Kewirausahaan';
        $subTheme = 'subject-theme-orange';
        $subIcon = 'bi-tools';
    } else {
        $cluster = 'Mata Pelajaran Kurikulum';
        $subTheme = 'subject-theme-blue';
        $subIcon = 'bi-mortarboard-fill';
    }
@endphp

<section class="container py-4 py-md-5">
    <!-- Breadcrumb Nav -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('library') }}">Perpustakaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('classes.show', $class) }}">Kelas {{ $class->name }}</a></li>
            <li class="breadcrumb-item active">{{ $subject->name }}</li>
        </ol>
    </nav>

    <!-- Subject Hero Banner -->
    <div class="subject-hero-banner {{ $subTheme }} mb-5 p-4 p-md-5 rounded-4 position-relative">
        <div class="row align-items-center g-4 position-relative" style="z-index: 1;">
            <div class="col-lg-8">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="subject-cluster-badge">
                        <i class="bi {{ $subIcon }} me-1"></i> {{ $cluster }}
                    </span>
                    <span class="badge text-bg-light text-dark fw-semibold px-2 py-1">
                        Tingkat Kelas {{ $class->name }}
                    </span>
                </div>
                <h1 class="display-6 fw-bold mb-2">{{ $subject->name }}</h1>
                <p class="mb-0 opacity-90 lead fs-6">
                    {{ $subject->description ?: 'Koleksi lengkap buku teks pelajaran, referensi mandiri, dan materi digital mata pelajaran ' . $subject->name . ' SMAN 1 Cikampek.' }}
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-inline-flex flex-column align-items-lg-end gap-2">
                    <span class="subject-stat-pill">
                        <i class="bi bi-journal-bookmark-fill me-1"></i>
                        <strong>{{ $subject->ebooks->count() }}</strong> E-Book Tersedia
                    </span>
                    <a href="{{ route('classes.show', $class) }}" class="btn btn-sm btn-outline-light mt-1 rounded-pill px-3">
                        <i class="bi bi-arrow-left me-1"></i> Semua Mapel Kelas {{ $class->name }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- E-Book Grid Section -->
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <span class="badge px-3 py-2 rounded-pill mb-2" style="background: rgba(15, 107, 79, 0.12); color: var(--school-green); font-weight: 700; font-size: 0.78rem; letter-spacing: 0.05em; text-transform: uppercase;">
                <i class="bi bi-collection-fill me-1"></i> Katalog Materi Digital
            </span>
            <h2 class="h4 fw-bold mb-1">Daftar E-Book & Modul Pelajaran</h2>
            <p class="text-muted mb-0">Pilih buku yang ingin kamu baca secara daring atau simpan ke koleksi favoritmu.</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse($subject->ebooks as $ebook)
            <div class="col-md-6 col-lg-4">
                <article class="card h-100 border rounded-4 overflow-hidden shadow-sm d-flex flex-column" style="transition: transform .25s ease, box-shadow .25s ease;">
                    <div class="p-3 d-flex gap-3 flex-grow-1">
                        <a href="{{ route('ebooks.show', $ebook) }}" class="book-row-cover flex-shrink-0" style="width: 86px;">
                            @include('public._book-cover', ['ebook' => $ebook])
                        </a>
                        <div class="min-w-0 d-flex flex-column flex-grow-1">
                            <div class="d-flex align-items-center gap-1 mb-1">
                                <span class="badge badge-soft small">Kelas {{ $class->name }}</span>
                                <span class="badge text-bg-light border small text-muted">{{ $ebook->publication_year ?: 'Kurikulum' }}</span>
                            </div>
                            <h3 class="h6 fw-bold mb-1">
                                <a href="{{ route('ebooks.show', $ebook) }}" class="text-decoration-none text-dark d-block text-truncate" title="{{ $ebook->title }}">
                                    {{ $ebook->title }}
                                </a>
                            </h3>
                            <p class="small text-muted mb-2 text-truncate">
                                <i class="bi bi-person me-1"></i> {{ $ebook->author ?: 'SMAN 1 Cikampek' }}
                            </p>
                            @if($ebook->publisher)
                                <p class="small text-muted mb-0 text-truncate" style="font-size: 0.75rem;">
                                    <i class="bi bi-building me-1"></i> {{ $ebook->publisher }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top p-3 d-flex align-items-center justify-content-between gap-2">
                        <a href="{{ route('ebooks.reader', $ebook) }}" class="btn btn-sm btn-success d-inline-flex align-items-center gap-1 px-3">
                            <i class="bi bi-book-half"></i> <span>Baca E-Book</span>
                        </a>
                        <a href="{{ route('ebooks.show', $ebook) }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
                            <span>Detail</span> <i class="bi bi-chevron-right small"></i>
                        </a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state p-5 text-center bg-white rounded-4 border">
                    <div class="saved-empty-icon mb-3 mx-auto" style="width: 64px; height: 64px; border-radius: 50%; background: rgba(15,107,79,0.1); color: var(--school-green); display: grid; place-items: center; font-size: 1.85rem;">
                        <i class="bi bi-journal-x"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-1">E-Book Belum Tersedia</h3>
                    <p class="text-muted mb-3 mx-auto" style="max-width: 380px;">
                        Materi digital untuk mata pelajaran <strong>{{ $subject->name }}</strong> saat ini sedang dipersiapkan dan diunggah oleh pengelola perpustakaan.
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('classes.show', $class) }}" class="btn btn-outline-success rounded-pill px-3">
                            <i class="bi bi-arrow-left me-1"></i> Mapel Lain Kelas {{ $class->name }}
                        </a>
                        <a href="{{ route('library') }}" class="btn btn-success rounded-pill px-3">
                            <i class="bi bi-compass me-1"></i> Jelajahi Perpustakaan
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</section>
@endsection
