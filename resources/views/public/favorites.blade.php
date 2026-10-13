@extends('layouts.public')

@section('title', 'Koleksi Favorit & Riwayat Baca Saya')
@section('meta_description', 'Buku pelajaran dan materi digital yang disimpan dan terakhir dibuka pada Perpustakaan Digital SMAN 1 Cikampek.')

@section('content')
<section class="container py-4 py-md-5">
    <!-- Hero Banner Koleksi -->
    <div class="favorites-hero mb-4 mb-md-5">
        <div class="row align-items-center g-4 position-relative" style="z-index: 1;">
            <div class="col-lg-7">
                <span class="badge px-3 py-2 rounded-pill mb-3" style="background: rgba(255, 255, 255, 0.2); color: #fff; font-weight: 700; font-size: 0.8rem; letter-spacing: 0.05em; text-transform: uppercase; backdrop-filter: blur(4px);">
                    <i class="bi bi-bookmark-heart-fill me-1 text-warning"></i> Koleksi Belajar Pribadi
                </span>
                <h1 class="display-6 fw-bold mb-2 text-white">Favorit & Riwayat Baca</h1>
                <p class="lead fs-6 opacity-90 mb-0 text-white-50">
                    Buku yang kamu tandai dan buka tersimpan rapi pada browser ini. Lanjutkan belajarmu kapan saja dengan satu klik tanpa perlu mencari ulang.
                </p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <div class="favorites-hero-stat">
                        <i class="bi bi-heart-fill fs-3 text-danger"></i>
                        <div class="text-start text-white">
                            <div class="stat-num" id="heroFavCount">0</div>
                            <div class="small opacity-75">Buku Favorit</div>
                        </div>
                    </div>
                    <div class="favorites-hero-stat">
                        <i class="bi bi-clock-history fs-3 text-info"></i>
                        <div class="text-start text-white">
                            <div class="stat-num" id="heroRecentCount">0</div>
                            <div class="small opacity-75">Terakhir Dibuka</div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('library') }}" class="btn btn-light rounded-pill px-4 fw-semibold shadow-sm">
                        <i class="bi bi-compass me-1"></i> Jelajahi Katalog Buku
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar & Filter Tabs -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div class="class-filter-btn-group" role="tablist" aria-label="Tab Koleksi">
            <button type="button" class="class-filter-pill active" data-fav-tab="all">
                <i class="bi bi-grid me-1"></i> Semua Koleksi
            </button>
            <button type="button" class="class-filter-pill" data-fav-tab="favorites">
                <i class="bi bi-heart me-1 text-danger"></i> Buku Favorit (<span id="tabFavCount">0</span>)
            </button>
            <button type="button" class="class-filter-pill" data-fav-tab="recent">
                <i class="bi bi-clock me-1 text-primary"></i> Riwayat Baca (<span id="tabRecentCount">0</span>)
            </button>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" id="clearRecentBtn" title="Bersihkan riwayat bacaan">
                <i class="bi bi-trash3 me-1"></i> Bersihkan Riwayat
            </button>
        </div>
    </div>

    <!-- Main Content: Dua Panel -->
    <div class="row g-4">
        <!-- Panel 1: Buku Favorit -->
        <div class="col-lg-6" id="panelFavorites">
            <div class="favorites-panel-card">
                <div class="favorites-panel-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box text-danger" style="background: rgba(220, 38, 38, 0.1); width: 42px; height: 42px; font-size: 1.2rem; border-radius: 12px;">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <div>
                            <h2 class="h6 fw-bold mb-0">Buku Favorit</h2>
                            <p class="small text-muted mb-0">Disimpan untuk referensi belajar utama</p>
                        </div>
                    </div>
                    <span class="badge badge-soft" id="panelFavBadge">0 e-book</span>
                </div>
                <div class="favorites-panel-body">
                    <div data-favorites-list></div>
                </div>
            </div>
        </div>

        <!-- Panel 2: Terakhir Dibuka -->
        <div class="col-lg-6" id="panelRecent">
            <div class="favorites-panel-card">
                <div class="favorites-panel-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box text-primary" style="background: rgba(37, 99, 235, 0.1); width: 42px; height: 42px; font-size: 1.2rem; border-radius: 12px;">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <h2 class="h6 fw-bold mb-0">Terakhir Dibuka</h2>
                            <p class="small text-muted mb-0">Riwayat bacaan terbaru di perangkat ini</p>
                        </div>
                    </div>
                    <span class="badge badge-soft" id="panelRecentBadge">0 e-book</span>
                </div>
                <div class="favorites-panel-body">
                    <div data-recent-list></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Banner Bantuan Belajar -->
    <div class="mt-5 p-4 rounded-4 border bg-white d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 shadow-sm">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box text-success flex-shrink-0" style="width: 46px; height: 46px; border-radius: 14px; font-size: 1.35rem; background: rgba(15, 107, 79, 0.1);">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <h3 class="h6 fw-bold mb-1">Penyimpanan Otomatis & Privat</h3>
                <p class="small text-muted mb-0">Seluruh buku favorit dan riwayat disimpan secara lokal pada browser perangkat ini sehingga Anda dapat langsung mengaksesnya kapan pun.</p>
            </div>
        </div>
        <a href="{{ route('library') }}" class="btn btn-outline-success btn-sm rounded-pill px-3 text-nowrap flex-shrink-0 fw-semibold">
            <i class="bi bi-search me-1"></i> Cari E-Book Lainnya
        </a>
    </div>
</section>
@endsection
