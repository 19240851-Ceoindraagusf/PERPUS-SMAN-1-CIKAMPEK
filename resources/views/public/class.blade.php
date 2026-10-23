@extends('layouts.public')

@section('title', 'Materi Kelas ' . $class->name)

@section('content')
@php
    $name = trim($class->name);
    $normalizedName = preg_replace('/\bX[lL]\b/i', 'XI', $name);
    $normalizedName = preg_replace('/\bX[lL]\s+/i', 'XI ', $normalizedName);
    $upperName = strtoupper($normalizedName);
    
    if (str_starts_with($upperName, 'XII') || str_contains($upperName, '12')) {
        $level = 'XII';
        $levelLabel = 'Tingkat XII • Kelas 12';
    } elseif (str_starts_with($upperName, 'XI') || str_contains($upperName, '11')) {
        $level = 'XI';
        $levelLabel = 'Tingkat XI • Kelas 11';
    } else {
        $level = 'X';
        $levelLabel = 'Tingkat X • Kelas 10';
    }

    $classIcon = 'bi-collection';
    $themeClass = 'class-theme-cyan';

    if ($level === 'X') {
        $themeClass = 'class-theme-emerald';
        $streamBadge = 'Fase E • Umum';
        $classIcon = 'bi-stars';
    } elseif ($level === 'XI') {
        if (str_contains($upperName, 'IPA') || str_contains($upperName, 'MIPA')) {
            $themeClass = 'class-theme-blue';
            $streamBadge = 'Fase F • MIPA';
            $classIcon = 'bi-lightning-charge';
        } elseif (str_contains($upperName, 'IPS') || str_contains($upperName, 'IIS')) {
            $themeClass = 'class-theme-amber';
            $streamBadge = 'Fase F • IPS';
            $classIcon = 'bi-globe-americas';
        } elseif (str_contains($upperName, 'BAHASA') || str_contains($upperName, 'IBB')) {
            $themeClass = 'class-theme-purple';
            $streamBadge = 'Fase F • Bahasa';
            $classIcon = 'bi-translate';
        } else {
            $themeClass = 'class-theme-cyan';
            $streamBadge = 'Fase F • Reguler';
            $classIcon = 'bi-layers';
        }
    } else {
        if (str_contains($upperName, 'IPA') || str_contains($upperName, 'MIPA')) {
            $themeClass = 'class-theme-indigo';
            $streamBadge = 'Tingkat Akhir • MIPA';
            $classIcon = 'bi-mortarboard';
        } elseif (str_contains($upperName, 'IPS') || str_contains($upperName, 'IIS')) {
            $themeClass = 'class-theme-orange';
            $streamBadge = 'Tingkat Akhir • IPS';
            $classIcon = 'bi-graph-up-arrow';
        } elseif (str_contains($upperName, 'BAHASA') || str_contains($upperName, 'IBB')) {
            $themeClass = 'class-theme-rose';
            $streamBadge = 'Tingkat Akhir • Bahasa';
            $classIcon = 'bi-feather';
        } else {
            $themeClass = 'class-theme-crimson';
            $streamBadge = 'Tingkat Akhir • Reguler';
            $classIcon = 'bi-mortarboard-fill';
        }
    }
@endphp
<section class="container py-5">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('library') }}">Perpustakaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('home') }}#pilih-kelas">Pilih Kelas</a></li>
            <li class="breadcrumb-item active">Kelas {{ $class->name }}</li>
        </ol>
    </nav>

    <div class="class-hero-banner {{ $themeClass }} mb-4 p-4 p-md-5 rounded-4 position-relative overflow-hidden">
        <div class="row align-items-center g-3 position-relative" style="z-index: 1;">
            <div class="col-lg-8">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="class-stream-pill"><i class="bi {{ $classIcon }} me-1"></i> {{ $streamBadge }}</span>
                    <span class="badge text-bg-light text-dark fw-semibold px-2 py-1">{{ $levelLabel }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2">Materi Pembelajaran Kelas {{ $class->name }}</h1>
                <p class="mb-0 opacity-90 lead fs-6">{{ $class->description ?: 'Koleksi lengkap mata pelajaran dan materi pembelajaran digital SMAN 1 Cikampek.' }}</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-inline-flex flex-column align-items-lg-end gap-2">
                    <div class="d-flex gap-2">
                        <span class="class-meta-chip"><i class="bi bi-book me-1"></i><strong>{{ $totalSubjects }}</strong> Mata Pelajaran</span>
                    </div>
                    <a href="{{ route('home') }}#pilih-kelas" class="btn btn-sm btn-outline-light mt-1"><i class="bi bi-arrow-left me-1"></i> Ganti Kelas Lain</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Search & Filter Mapel -->
    <div class="card border rounded-4 p-3 mb-4 shadow-sm bg-white">
        <form action="{{ route('classes.show', $class) }}" method="GET">
            <div class="row g-2 align-items-center">
                <div class="col-lg">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="search" class="form-control border-start-0 ps-0" id="q" name="q" value="{{ $search }}" placeholder="Cari mata pelajaran, topik materi, atau buku...">
                    </div>
                </div>
                <div class="col-lg-3">
                    <select class="form-select" id="subject" name="subject">
                        <option value="">Semua mata pelajaran</option>
                        @foreach($subjectOptions as $subjectName)
                            <option value="{{ $subjectName }}" @selected($selectedSubject === $subjectName)>{{ $subjectName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-auto d-flex gap-2">
                    <button class="btn btn-success px-4" type="submit">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    @if($search || $selectedSubject)
                        <a class="btn btn-outline-secondary" href="{{ route('classes.show', $class) }}">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Quick Cluster Filter Tabs -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-3 pt-3 border-top">
            <div class="class-filter-btn-group" role="tablist" aria-label="Filter Bidang Studi">
                <a href="{{ route('classes.show', $class) }}" class="class-filter-pill {{ !$selectedCluster ? 'active' : '' }} text-decoration-none" data-filter-subject="all" role="button" aria-pressed="{{ !$selectedCluster ? 'true' : 'false' }}">Semua Bidang</a>
                <a href="{{ route('classes.show', [$class, 'cluster' => 'sains']) }}" class="class-filter-pill {{ $selectedCluster === 'sains' ? 'active' : '' }} text-decoration-none" data-filter-subject="sains" role="button" aria-pressed="{{ $selectedCluster === 'sains' ? 'true' : 'false' }}">🔬 Sains & Eksakta</a>
                <a href="{{ route('classes.show', [$class, 'cluster' => 'bahasa']) }}" class="class-filter-pill {{ $selectedCluster === 'bahasa' ? 'active' : '' }} text-decoration-none" data-filter-subject="bahasa" role="button" aria-pressed="{{ $selectedCluster === 'bahasa' ? 'true' : 'false' }}">📖 Bahasa & Sastra</a>
                <a href="{{ route('classes.show', [$class, 'cluster' => 'sosial']) }}" class="class-filter-pill {{ $selectedCluster === 'sosial' ? 'active' : '' }} text-decoration-none" data-filter-subject="sosial" role="button" aria-pressed="{{ $selectedCluster === 'sosial' ? 'true' : 'false' }}">🌍 Sosial & Humaniora</a>
                <a href="{{ route('classes.show', [$class, 'cluster' => 'lainnya']) }}" class="class-filter-pill {{ $selectedCluster === 'lainnya' ? 'active' : '' }} text-decoration-none" data-filter-subject="lainnya" role="button" aria-pressed="{{ $selectedCluster === 'lainnya' ? 'true' : 'false' }}">🎨 Seni & Umum</a>
            </div>
            <span class="small text-muted">
                Menampilkan <strong>{{ $class->subjects->count() }}</strong> mata pelajaran {{ $selectedCluster ? 'pada bidang terpilih' : 'aktif' }}
            </span>
        </div>
    </div>

    @if($search || $selectedSubject)
        <p class="text-muted small mb-3">Menampilkan {{ $class->subjects->count() }} hasil{{ $search ? ' untuk "' . $search . '"' : '' }}{{ $selectedSubject ? ' pada ' . $selectedSubject : '' }}.</p>
    @endif

    <div class="row g-4" id="subjectGrid">
        @forelse($class->subjects as $subject)
            @include('public._subject_card', ['subject' => $subject, 'class' => $class])
        @empty
            <div class="col-12">
                <div class="empty-state p-5 text-center bg-white rounded-4 border">
                    <div class="saved-empty-icon mb-3 mx-auto" style="width: 60px; height: 60px; border-radius: 50%; background: rgba(15,107,79,0.1); color: var(--school-green); display: grid; place-items: center; font-size: 1.75rem;">
                        <i class="bi bi-journal-x"></i>
                    </div>
                    <h2 class="h5 fw-bold mb-1">{{ $search ? 'Mata pelajaran tidak ditemukan' : 'Mata pelajaran belum tersedia' }}</h2>
                    <p class="text-muted mb-3 mx-auto" style="max-width: 360px;">{{ $search ? 'Coba gunakan kata kunci pencarian yang lebih singkat.' : 'Silakan kembali lagi setelah koleksi mata pelajaran ditambahkan.' }}</p>
                    <a href="{{ route('classes.show', $class) }}" class="btn btn-outline-success rounded-pill px-4">Lihat Semua Mapel Kelas {{ $class->name }}</a>
                </div>
            </div>
        @endforelse
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterBtns = document.querySelectorAll('[data-filter-subject]');
        const subjectCols = document.querySelectorAll('.subject-card-col');

        const initialCluster = new URLSearchParams(window.location.search).get('cluster');
        if (initialCluster && [...filterBtns].some((button) => button.dataset.filterSubject === initialCluster)) {
            filterBtns.forEach((button) => {
                const active = button.dataset.filterSubject === initialCluster;
                button.classList.toggle('active', active);
                button.setAttribute('aria-pressed', String(active));
            });
            subjectCols.forEach((column) => {
                column.classList.toggle('is-hidden', column.dataset.subjectCluster !== initialCluster);
            });
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const target = btn.getAttribute('data-filter-subject');

                filterBtns.forEach(b => {
                    b.classList.remove('active');
                    b.setAttribute('aria-pressed', 'false');
                });
                btn.classList.add('active');
                btn.setAttribute('aria-pressed', 'true');

                subjectCols.forEach(col => {
                    const cluster = col.getAttribute('data-subject-cluster');
                    if (target === 'all' || cluster === target) {
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

                if (target === 'all') {
                    history.replaceState(null, '', window.location.pathname);
                } else {
                    history.replaceState(null, '', `${window.location.pathname}?cluster=${encodeURIComponent(target)}`);
                }
            });
        });
    });
</script>
@endpush
