@extends('layouts.public')

@section('title', 'Baca ' . $ebook->title)
@section('hide_global_nav_footer', true)

@section('content')
<div class="reader-app d-flex flex-column" data-ebook-record data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}" data-ebook-cover="{{ $ebook->cover_path ? asset('storage/' . $ebook->cover_path) : '' }}" data-ebook-author="{{ $ebook->author ?: '' }}">

    {{-- Top Navigation & Reading Controls Bar --}}
    <header class="reader-topbar px-3 py-2 d-flex align-items-center justify-content-between border-bottom shadow-sm">
        <div class="d-flex align-items-center gap-2 min-w-0">
            <a href="{{ route('ebooks.show', $ebook) }}" class="btn btn-sm btn-icon-round reader-btn-back" title="Kembali ke detail buku">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div class="reader-book-info min-w-0">
                <h1 class="reader-title h6 fw-bold mb-0 text-truncate" title="{{ $ebook->title }}">{{ $ebook->title }}</h1>
                <div class="reader-meta d-flex align-items-center gap-2 small">
                    <span class="badge rounded-pill reader-class-badge">Kelas {{ $ebook->subject->class->name }}</span>
                    <span class="text-truncate text-muted d-none d-sm-inline" style="font-size: 0.78rem;">{{ $ebook->subject->name }}</span>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-1 gap-md-2 flex-shrink-0">
            {{-- Quick Page Indicator & Jump --}}
            <div class="reader-page-stepper d-flex align-items-center bg-light rounded-pill px-2 py-1 border">
                <button type="button" class="btn btn-sm p-0 text-muted" id="btnPagePrev" title="Halaman Sebelumnya">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <div class="d-flex align-items-center px-1">
                    <input type="number" id="pageNumberInput" class="form-control form-control-sm border-0 bg-transparent text-center p-0 fw-bold" style="width: 42px; font-size: 0.85rem;" min="1" value="1">
                    <span class="text-muted small mx-1">/</span>
                    <span id="pageTotalCount" class="text-muted small fw-semibold">--</span>
                </div>
                <button type="button" class="btn btn-sm p-0 text-muted" id="btnPageNext" title="Halaman Berikutnya">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            {{-- Zoom Controls (Desktop / Tablet) --}}
            <div class="btn-group btn-group-sm d-none d-md-inline-flex" role="group" aria-label="Zoom controls">
                <button type="button" class="btn btn-outline-secondary" id="btnZoomOut" title="Perkecil (-)">
                    <i class="bi bi-dash"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary px-2 text-nowrap" id="btnZoomFit" title="Pas Lebar (Fit Width)">
                    <span id="zoomPercentLabel" style="font-size: 0.78rem;">Fit</span>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="btnZoomIn" title="Perbesar (+)">
                    <i class="bi bi-plus"></i>
                </button>
            </div>

            {{-- Theme & Mood Selector (Light / Warm Sepia / Dark) --}}
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary rounded-pill px-2 px-md-3 d-flex align-items-center gap-1" type="button" id="themeDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false" title="Ubah mode kenyamanan mata">
                    <i class="bi bi-circle-half"></i>
                    <span class="d-none d-lg-inline" style="font-size: 0.82rem;">Tampilan</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg rounded-3 py-2 border-0" aria-labelledby="themeDropdownBtn" style="min-width: 170px;">
                    <li><h6 class="dropdown-header text-uppercase fw-bold" style="font-size: 0.68rem;">Mode Membaca</h6></li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center gap-2 active" type="button" data-theme-btn="light">
                            <i class="bi bi-sun text-warning"></i> <span>Mode Terang</span>
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center gap-2" type="button" data-theme-btn="sepia">
                            <i class="bi bi-book text-amber" style="color: #d97706;"></i> <span>Mode Hangat (Sepia)</span>
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center gap-2" type="button" data-theme-btn="dark">
                            <i class="bi bi-moon-stars text-primary"></i> <span>Mode Gelap</span>
                        </button>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><h6 class="dropdown-header text-uppercase fw-bold" style="font-size: 0.68rem;">Tampilan Halaman</h6></li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center gap-2 active" type="button" id="btnViewSingle">
                            <i class="bi bi-file-earmark"></i> <span>1 Halaman</span>
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center gap-2" type="button" id="btnViewScroll">
                            <i class="bi bi-distribute-vertical"></i> <span>Gulir Berkelanjutan</span>
                        </button>
                    </li>
                </ul>
            </div>

            {{-- Bookmark / Favorite Button --}}
            <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-0 d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;" title="Simpan ke favorit" data-favorite-button data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}" data-ebook-cover="{{ $ebook->cover_path ? asset('storage/' . $ebook->cover_path) : '' }}" data-ebook-author="{{ $ebook->author ?: '' }}">
                <i class="bi bi-bookmark"></i>
            </button>

            {{-- Fullscreen Mode --}}
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle p-0 d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;" id="btnFullscreenToggle" title="Mode Layar Penuh">
                <i class="bi bi-arrows-fullscreen"></i>
            </button>

            {{-- Download File --}}
            <a href="{{ route('ebooks.download', $ebook) }}" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold d-none d-sm-inline-flex align-items-center gap-1" title="Unduh PDF lengkap">
                <i class="bi bi-download"></i> <span style="font-size: 0.82rem;">Unduh</span>
            </a>
        </div>
    </header>

    {{-- Main Reading Area --}}
    <main class="reader-viewport flex-grow-1 position-relative overflow-hidden" id="readerViewport" tabindex="0">
        {{-- Loading Spinner Overlay --}}
        <div class="reader-loading-state position-absolute inset-0 d-flex flex-column align-items-center justify-content-center" id="readerLoadingState">
            <div class="spinner-grow text-success mb-3" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Memuat dokumen...</span>
            </div>
            <div class="fw-semibold text-dark mb-1" id="loadingText">Menyiapkan E-Book...</div>
            <div class="small text-muted" id="loadingSubtext">Mengoptimalkan tampilan untuk perangkat Anda</div>
        </div>

        {{-- Error State Overlay --}}
        <div class="reader-error-state position-absolute inset-0 d-none flex-column align-items-center justify-content-center p-4 text-center" id="readerErrorState">
            <div class="text-danger mb-3" style="font-size: 3rem;"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <h5 class="fw-bold mb-2">Gagal Memuat E-Book di Penampil Cerdas</h5>
            <p class="text-muted small mb-4" style="max-width: 460px;">Dokumen PDF dapat dibuka menggunakan penampil bawaan browser atau diunduh langsung ke perangkat Anda.</p>
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-3" id="btnFallbackIframe">
                    <i class="bi bi-window me-1"></i> Buka dengan Penampil Bawaan
                </button>
                <a href="{{ route('ebooks.download', $ebook) }}" class="btn btn-success rounded-pill px-4">
                    <i class="bi bi-download me-1"></i> Unduh File PDF
                </a>
            </div>
        </div>

        {{-- Interactive Canvas Stage (Single Page Mode) --}}
        <div class="reader-stage d-flex align-items-center justify-content-center w-100 h-100 overflow-auto" id="readerStage">
            <div class="reader-canvas-card position-relative shadow" id="readerCanvasCard">
                <canvas id="pdfCanvas" class="d-block mx-auto"></canvas>
            </div>
        </div>

        {{-- Continuous Scroll Stage (Vertical Mode) --}}
        <div class="reader-scroll-stage d-none w-100 h-100 overflow-auto py-3 py-md-4" id="readerScrollStage">
            <div class="container-fluid d-flex flex-column align-items-center gap-3 gap-md-4" id="readerScrollContainer">
                {{-- Dynamic pages will be placed here --}}
            </div>
        </div>

        {{-- Fallback Iframe (Hidden by default, used if needed) --}}
        <iframe id="pdfFallbackIframe" class="w-100 h-100 border-0 d-none" title="Fallback PDF Viewer"></iframe>

        {{-- On-Screen Floating Nav Arrows (Visible on Desktop / Hover) --}}
        <button type="button" class="reader-nav-arrow reader-nav-prev d-none d-md-flex align-items-center justify-content-center shadow-lg" id="floatingPrevBtn" title="Halaman Sebelumnya (Tekan Panah Kiri)">
            <i class="bi bi-chevron-left fs-4"></i>
        </button>
        <button type="button" class="reader-nav-arrow reader-nav-next d-none d-md-flex align-items-center justify-content-center shadow-lg" id="floatingNextBtn" title="Halaman Berikutnya (Tekan Panah Kanan)">
            <i class="bi bi-chevron-right fs-4"></i>
        </button>

        {{-- Floating Notification Toast (Saved Page, etc.) --}}
        <div class="reader-toast position-absolute bottom-0 start-50 translate-middle-x mb-4 shadow rounded-pill px-4 py-2 d-none" id="readerToast">
            <i class="bi bi-check-circle-fill text-success me-2"></i>
            <span id="readerToastText" class="small fw-semibold"></span>
        </div>
    </main>

    {{-- Bottom Touch Control Bar (Optimized for Mobile/Phone) --}}
    <footer class="reader-bottombar px-3 py-2 border-top d-flex align-items-center justify-content-between shadow-sm">
        <div class="d-flex align-items-center gap-1">
            <button type="button" class="btn btn-sm btn-icon-round" id="btnMobilePrev" title="Sebelumnya">
                <i class="bi bi-arrow-left-short fs-4"></i>
            </button>
            <span class="small fw-bold px-2 text-muted" id="mobilePageIndicator" style="font-size: 0.82rem;">1 / --</span>
            <button type="button" class="btn btn-sm btn-icon-round" id="btnMobileNext" title="Berikutnya">
                <i class="bi bi-arrow-right-short fs-4"></i>
            </button>
        </div>

        <div class="d-flex align-items-center gap-2">
            <div class="reader-progress-status d-flex align-items-center gap-1 rounded-pill px-2 px-sm-3 py-2" id="readerProgressStatus" role="status" aria-live="polite" title="Posisi baca tersimpan otomatis di browser ini">
                <i class="bi bi-check2-circle" aria-hidden="true"></i>
                <span class="d-none d-sm-inline" id="readerProgressStatusText">Menyimpan progres...</span>
                <span class="d-inline d-sm-none">Otomatis</span>
            </div>

            {{-- Zoom Out / In on Mobile --}}
            <div class="d-flex d-md-none align-items-center gap-1">
                <button type="button" class="btn btn-sm btn-icon-round" id="btnMobileZoomOut" title="Perkecil">
                    <i class="bi bi-dash-lg"></i>
                </button>
                <button type="button" class="btn btn-sm btn-icon-round" id="btnMobileZoomIn" title="Perbesar">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </div>
    </footer>
</div>

{{-- Reader Styles --}}
<style>
    /* Full-screen Reader App Shell */
    html, body {
        height: 100%;
        overflow: hidden !important;
        margin: 0;
        padding: 0;
    }
    .reader-app {
        height: 100vh;
        height: 100dvh;
        width: 100vw;
        overflow: hidden;
        background-color: #f1f5f9;
        color: #1e293b;
        font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        transition: background-color 0.25s ease, color 0.25s ease;
    }
    .reader-viewport { min-height: 0; min-width: 0; overscroll-behavior: contain; }
    .inset-0 {
        top: 0; right: 0; bottom: 0; left: 0;
    }

    /* Top and Bottom Bars */
    .reader-topbar, .reader-bottombar {
        background-color: #ffffff;
        z-index: 1050;
        transition: background-color 0.25s ease, border-color 0.25s ease;
    }
    .reader-topbar {
        position: relative;
        flex-wrap: wrap;
        gap: .5rem 1rem;
        padding-top: .65rem !important;
        padding-bottom: .65rem !important;
        border-color: #e3e9ef !important;
        box-shadow: 0 5px 20px rgba(15,35,55,.07) !important;
    }
    .reader-topbar > div:first-child { flex: 1 1 260px; }
    .reader-topbar > div:last-child { flex: 0 1 auto; flex-wrap: wrap; }
    .reader-topbar button, .reader-topbar a { touch-action: manipulation; }
    .reader-page-stepper { min-height: 36px; border-color: #dfe6ec !important; }
    .reader-viewport { background-image: radial-gradient(ellipse at top, rgba(255,255,255,.7), transparent 65%); }
    .reader-progress-status { color: #12634c; background: rgba(18,99,76,.08); font-size: .78rem; font-weight: 700; white-space: nowrap; }
    .reader-title {
        max-width: 420px;
    }
    .reader-class-badge {
        background: rgba(15, 107, 79, 0.12);
        color: #0f6b4f;
        font-size: 0.72rem;
        font-weight: 700;
    }
    .btn-icon-round {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(0,0,0,0.08);
        background: #f8fafc;
        color: #334155;
        transition: all 0.2s ease;
    }
    .btn-icon-round:hover {
        background: #e2e8f0;
        color: #0f172a;
        transform: scale(1.05);
    }

    /* Stage & Canvas Styling */
    .reader-stage {
        padding: 1.5rem 1rem;
        user-select: none;
        -webkit-user-select: none;
    }
    .reader-canvas-card {
        background: #ffffff;
        border-radius: 6px;
        overflow: hidden;
        transition: box-shadow 0.25s ease, transform 0.15s ease-out;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    #pdfCanvas {
        display: block;
        max-width: 100%;
        height: auto;
    }

    /* Floating Navigation Arrows */
    .reader-nav-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        color: #1e293b;
        border: 1px solid rgba(0, 0, 0, 0.08);
        cursor: pointer;
        z-index: 1040;
        backdrop-filter: blur(8px);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        opacity: 0.65;
    }
    .reader-nav-arrow:hover {
        opacity: 1;
        background: #0f6b4f;
        color: #ffffff;
        transform: translateY(-50%) scale(1.1);
    }
    .reader-nav-prev { left: 1.25rem; }
    .reader-nav-next { right: 1.25rem; }

    /* Continuous Scroll Mode */
    .reader-scroll-stage { min-height: 0; overscroll-behavior-y: contain; -webkit-overflow-scrolling: touch; scroll-behavior: smooth; }
    .reader-scroll-stage .pdf-scroll-page {
        background: #ffffff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
        overflow: hidden;
        margin: 0 auto;
        width: min(100%, 1100px);
        min-height: 420px;
        flex: 0 0 auto;
    }

    /* Floating Toast Notification */
    .reader-toast {
        background: #1e293b;
        color: #ffffff;
        z-index: 1090;
        pointer-events: none;
        animation: toastFadeIn 0.25s ease;
    }
    @keyframes toastFadeIn {
        from { opacity: 0; transform: translate(-50%, 15px); }
        to { opacity: 1; transform: translate(-50%, 0); }
    }

    /* ==========================================================================
       COMFORT MODES: SEPIA (WARM PAPER) & DARK (NIGHT MODE)
       ========================================================================== */
    /* Sepia / Warm Paper */
    .reader-app.reader-theme-sepia {
        background-color: #f4ecd8 !important;
        color: #433422 !important;
    }
    .reader-app.reader-theme-sepia .reader-topbar,
    .reader-app.reader-theme-sepia .reader-bottombar {
        background-color: #ede2c9 !important;
        border-color: #dfd2b5 !important;
        color: #433422 !important;
    }
    .reader-app.reader-theme-sepia .reader-progress-status { color: #5d462c; background: rgba(93,70,44,.09); }
    .reader-app.reader-theme-sepia .btn-icon-round {
        background: #fbf5e7;
        border-color: #d8c7a6;
        color: #5d462c;
    }
    .reader-app.reader-theme-sepia .reader-canvas-card {
        box-shadow: 0 10px 30px rgba(93, 70, 44, 0.18);
        filter: sepia(25%) contrast(97%) brightness(98%);
    }

    /* Dark Mode (Night Reading) */
    .reader-app.reader-theme-dark {
        background-color: #0f172a !important;
        color: #e2e8f0 !important;
    }
    .reader-app.reader-theme-dark .reader-topbar,
    .reader-app.reader-theme-dark .reader-bottombar {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }
    .reader-app.reader-theme-dark .reader-progress-status { color: #6ee7b7; background: rgba(16,185,129,.14); }
    .reader-app.reader-theme-dark .reader-title {
        color: #f8fafc !important;
    }
    .reader-app.reader-theme-dark .reader-class-badge {
        background: rgba(16, 185, 129, 0.2);
        color: #6ee7b7;
    }
    .reader-app.reader-theme-dark .btn-icon-round {
        background: #334155;
        border-color: #475569;
        color: #f1f5f9;
    }
    .reader-app.reader-theme-dark .btn-icon-round:hover {
        background: #475569;
    }
    .reader-app.reader-theme-dark .reader-canvas-card {
        box-shadow: 0 12px 36px rgba(0, 0, 0, 0.6);
        filter: invert(90%) hue-rotate(180deg) contrast(95%);
    }
    .reader-app.reader-theme-dark .reader-nav-arrow {
        background: rgba(30, 41, 59, 0.85);
        color: #e2e8f0;
        border-color: rgba(255, 255, 255, 0.1);
    }
    .reader-app.reader-theme-dark .reader-page-stepper {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    .reader-app.reader-theme-dark #pageNumberInput,
    .reader-app.reader-theme-dark #pageTotalCount {
        color: #e2e8f0 !important;
    }

    /* Mobile Enhancements */
    @media (max-width: 576px) {
        .reader-topbar { padding: 0.5rem 0.65rem !important; gap: .45rem; }
        .reader-topbar > div:first-child { flex: 1 1 100%; }
        .reader-topbar > div:last-child { flex: 1 1 100%; justify-content: space-between; }
        .reader-bottombar { padding: 0.5rem 0.75rem !important; }
        .reader-stage { padding: 0.5rem 0.25rem !important; }
        .reader-canvas-card { border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.12); }
        .reader-title { max-width: calc(100vw - 90px); font-size: 0.9rem !important; }
        .reader-page-stepper { padding: 0.15rem 0.5rem !important; }
        #pageNumberInput { width: 34px !important; }
        .reader-toast { max-width: calc(100vw - 2rem); white-space: nowrap; font-size: .85rem; }
        .reader-error-state { overflow-y: auto; }
    }
</style>

{{-- PDF.js Library via CDN --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
</script>

<script>
(() => {
    'use strict';

    const pdfUrl = "{{ asset('storage/' . $ebook->file_path) }}";
    const ebookId = "{{ $ebook->id }}";
    const storagePrefix = 'perpus_reader_' + ebookId;
    const progressStatusText = document.getElementById('readerProgressStatusText');
    const saveReadingProgress = (page) => {
        try {
            localStorage.setItem(storagePrefix + '_last_page', String(page));
            if (progressStatusText) progressStatusText.textContent = `Halaman ${page} tersimpan otomatis`;
        } catch (error) {
            if (progressStatusText) progressStatusText.textContent = 'Progres tidak dapat disimpan';
            console.warn('Reading progress could not be saved:', error);
        }
    };

    // DOM Elements
    const appContainer = document.querySelector('.reader-app');
    const viewport = document.getElementById('readerViewport');
    const stage = document.getElementById('readerStage');
    const canvasCard = document.getElementById('readerCanvasCard');
    const canvas = document.getElementById('pdfCanvas');
    const ctx = canvas.getContext('2d');
    const loadingState = document.getElementById('readerLoadingState');
    const errorState = document.getElementById('readerErrorState');
    const fallbackIframe = document.getElementById('pdfFallbackIframe');
    const scrollStage = document.getElementById('readerScrollStage');
    const scrollContainer = document.getElementById('readerScrollContainer');
    const toast = document.getElementById('readerToast');
    const toastText = document.getElementById('readerToastText');

    // Controls
    const pageInput = document.getElementById('pageNumberInput');
    const pageTotal = document.getElementById('pageTotalCount');
    const mobilePageIndicator = document.getElementById('mobilePageIndicator');
    const zoomPercentLabel = document.getElementById('zoomPercentLabel');

    // State Variables
    let pdfDoc = null;
    let currentPage = 1;
    let totalPages = 1;
    let currentScale = 1.0;
    let autoFitScale = 1.0;
    let isFitWidth = true;
    let pageRendering = false;
    let pageNumPending = null;
    let renderTask = null;
    let viewMode = 'single'; // 'single' | 'scroll'
    let scrollRenderGeneration = 0;
    let pagePositionFrame = 0;

    // Toast Helper
    const showToast = (message, duration = 2000) => {
        toastText.textContent = message;
        toast.classList.remove('d-none');
        clearTimeout(toast._timer);
        toast._timer = setTimeout(() => toast.classList.add('d-none'), duration);
    };

    // Theme Selector
    const setTheme = (themeName) => {
        appContainer.classList.remove('reader-theme-sepia', 'reader-theme-dark');
        document.querySelectorAll('[data-theme-btn]').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.themeBtn === themeName);
        });
        if (themeName === 'sepia') {
            appContainer.classList.add('reader-theme-sepia');
        } else if (themeName === 'dark') {
            appContainer.classList.add('reader-theme-dark');
        }
        localStorage.setItem(storagePrefix + '_theme', themeName);
    };

    document.querySelectorAll('[data-theme-btn]').forEach(btn => {
        btn.addEventListener('click', () => setTheme(btn.dataset.themeBtn));
    });
    const savedTheme = localStorage.getItem(storagePrefix + '_theme') || 'light';
    setTheme(savedTheme);

    // Calculate Optimal Auto-Fit Scale
    const computeFitScale = (pageViewport) => {
        const availableWidth = stage.clientWidth - (window.innerWidth < 576 ? 16 : 48);
        const availableHeight = stage.clientHeight - (window.innerWidth < 576 ? 16 : 48);
        const scaleX = availableWidth / pageViewport.width;
        const scaleY = availableHeight / pageViewport.height;

        // On mobile portrait, prioritize fit width for legible textbook reading
        if (window.innerWidth < 768) {
            return Math.min(Math.max(scaleX, 0.6), 2.2);
        }
        // On desktop, fit within container comfortably
        return Math.min(scaleX, scaleY, 1.8);
    };

    // Render Single Page with High-DPI support
    const renderPage = async (num) => {
        if (!pdfDoc) return;
        pageRendering = true;

        try {
            const page = await pdfDoc.getPage(num);

            // Compute scale
            const unscaledViewport = page.getViewport({ scale: 1.0 });
            if (isFitWidth) {
                currentScale = computeFitScale(unscaledViewport);
            }

            const viewportScaled = page.getViewport({ scale: currentScale });
            const pixelRatio = window.devicePixelRatio || 1;

            // Canvas size in hardware pixels for crystal clear text
            canvas.width = Math.floor(viewportScaled.width * pixelRatio);
            canvas.height = Math.floor(viewportScaled.height * pixelRatio);

            // Canvas CSS layout size
            canvas.style.width = Math.floor(viewportScaled.width) + 'px';
            canvas.style.height = Math.floor(viewportScaled.height) + 'px';

            const renderContext = {
                canvasContext: ctx,
                viewport: viewportScaled,
                transform: pixelRatio !== 1 ? [pixelRatio, 0, 0, pixelRatio, 0, 0] : null
            };

            if (renderTask) {
                renderTask.cancel();
            }
            renderTask = page.render(renderContext);
            await renderTask.promise;

            pageRendering = false;
            if (pageNumPending !== null) {
                const pending = pageNumPending;
                pageNumPending = null;
                renderPage(pending);
            }

            // Update UI indicators
            pageInput.value = num;
            mobilePageIndicator.textContent = `${num} / ${totalPages}`;
            zoomPercentLabel.textContent = isFitWidth ? 'Fit' : `${Math.round(currentScale * 100)}%`;

            // Auto save last reading position
            saveReadingProgress(num);

        } catch (err) {
            if (err.name !== 'RenderingCancelledException') {
                console.error('Rendering error on page ' + num, err);
            }
            pageRendering = false;
        }
    };

    const queueRenderPage = (num) => {
        if (num < 1) num = 1;
        if (num > totalPages) num = totalPages;
        currentPage = num;

        if (viewMode === 'scroll') {
            const target = scrollContainer.querySelector(`[data-page="${num}"]`);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                pageInput.value = num;
                mobilePageIndicator.textContent = `${num} / ${totalPages}`;
                saveReadingProgress(num);
                return;
            }
        }

        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    };

    const goToPrevPage = () => {
        if (currentPage <= 1) {
            showToast('Ini adalah halaman pertama');
            return;
        }
        queueRenderPage(currentPage - 1);
    };

    const goToNextPage = () => {
        if (currentPage >= totalPages) {
            showToast('Ini adalah halaman terakhir');
            return;
        }
        queueRenderPage(currentPage + 1);
    };

    // Zoom Functions
    const setZoom = (newScale, fit = false) => {
        isFitWidth = fit;
        currentScale = Math.min(Math.max(newScale, 0.45), 3.2);
        queueRenderPage(currentPage);
    };

    // Continuous Scroll (Intersection Observer)
    let scrollObserver = null;
    const initScrollMode = async (targetPage = currentPage) => {
        scrollContainer.innerHTML = '';
        scrollStage.scrollTop = 0;
        scrollObserver?.disconnect();
        const generation = ++scrollRenderGeneration;

        scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(async (entry) => {
                if (entry.isIntersecting) {
                    const pageEl = entry.target;
                    const pageNum = parseInt(pageEl.dataset.page, 10);
                    scrollObserver.unobserve(pageEl);

                    try {
                        const page = await pdfDoc.getPage(pageNum);
                        const unscaled = page.getViewport({ scale: 1.0 });
                        const availableWidth = Math.max(240, scrollStage.clientWidth - 32);
                        const scale = Math.min(availableWidth / unscaled.width, 1.8);
                        const vp = page.getViewport({ scale });
                        const dpr = Math.min(window.devicePixelRatio || 1, 2);
                        const pCanvas = document.createElement('canvas');
                        pCanvas.width = Math.floor(vp.width * dpr);
                        pCanvas.height = Math.floor(vp.height * dpr);
                        pCanvas.style.width = `${Math.floor(vp.width)}px`;
                        pCanvas.style.height = `${Math.floor(vp.height)}px`;
                        const pCtx = pCanvas.getContext('2d', { alpha: false });
                        await page.render({ canvasContext: pCtx, viewport: vp, transform: dpr !== 1 ? [dpr, 0, 0, dpr, 0, 0] : null }).promise;
                        if (generation === scrollRenderGeneration) {
                            pageEl.replaceChildren(pCanvas);
                            pageEl.style.minHeight = `${Math.ceil(vp.height)}px`;
                        }
                    } catch (error) {
                        if (generation === scrollRenderGeneration) pageEl.innerHTML = `<div class="text-danger small py-5">Halaman ${pageNum} gagal dimuat.</div>`;
                        console.error(`Rendering error on page ${pageNum}`, error);
                    }
                }
            });
        }, { root: scrollStage, rootMargin: '300px 0px', threshold: 0.01 });

        for (let i = 1; i <= totalPages; i++) {
            const pageBox = document.createElement('div');
            pageBox.className = 'pdf-scroll-page d-flex align-items-center justify-content-center';
            pageBox.dataset.page = i;
            pageBox.style.minHeight = '420px';
            pageBox.innerHTML = `<div class="text-muted small py-5"><span class="spinner-border spinner-border-sm me-1"></span> Halaman ${i}</div>`;
            scrollContainer.appendChild(pageBox);
            scrollObserver.observe(pageBox);
        }
        viewMode = 'scroll';
        requestAnimationFrame(() => {
            const target = scrollContainer.querySelector(`[data-page="${targetPage}"]`);
            if (target) scrollStage.scrollTop = target.offsetTop - scrollContainer.offsetTop;
            updatePageFromScroll();
        });
    };

    const updatePageFromScroll = () => {
        if (viewMode !== 'scroll') return;
        cancelAnimationFrame(pagePositionFrame);
        pagePositionFrame = requestAnimationFrame(() => {
            const stageRect = scrollStage.getBoundingClientRect();
            const marker = stageRect.top + stageRect.height * 0.4;
            let nearest = null;
            let nearestDistance = Infinity;
            [...scrollContainer.children].forEach((pageEl) => {
                const rect = pageEl.getBoundingClientRect();
                const distance = Math.abs(rect.top + Math.min(rect.height, stageRect.height) * 0.4 - marker);
                if (distance < nearestDistance) { nearest = pageEl; nearestDistance = distance; }
            });
            if (!nearest) return;
            const pageNum = Number(nearest.dataset.page);
            if (pageNum && pageNum !== currentPage) {
                currentPage = pageNum;
                pageInput.value = pageNum;
                mobilePageIndicator.textContent = `${pageNum} / ${totalPages}`;
                saveReadingProgress(pageNum);
            }
        });
    };
    scrollStage.addEventListener('scroll', updatePageFromScroll, { passive: true });

    // Load PDF Document
    const loadDocument = async () => {
        try {
            loadingState.classList.remove('d-none');
            errorState.classList.add('d-none');

            const loadingTask = window.pdfjsLib.getDocument({
                url: pdfUrl,
                cMapUrl: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/cmaps/',
                cMapPacked: true
            });

            pdfDoc = await loadingTask.promise;
            totalPages = pdfDoc.numPages;

            pageTotal.textContent = totalPages;
            pageInput.max = totalPages;

            // Restore last read page
            let savedPage = 0;
            try {
                savedPage = parseInt(localStorage.getItem(storagePrefix + '_last_page'), 10);
            } catch (error) {
                console.warn('Reading progress could not be restored:', error);
            }
            if (savedPage && savedPage >= 1 && savedPage <= totalPages) {
                currentPage = savedPage;
                showToast(`Melanjutkan dari halaman ${currentPage}`, 2500);
            } else {
                currentPage = 1;
            }

            loadingState.classList.add('d-none');
            queueRenderPage(currentPage);

        } catch (err) {
            console.warn('PDF.js failed to parse file directly, falling back:', err);
            loadingState.classList.add('d-none');
            errorState.classList.remove('d-none');
        }
    };

    // Fallback Button
    document.getElementById('btnFallbackIframe')?.addEventListener('click', () => {
        errorState.classList.add('d-none');
        stage.classList.add('d-none');
        fallbackIframe.classList.remove('d-none');
        fallbackIframe.src = pdfUrl + '#view=FitH&page=' + currentPage;
    });

    // Page Navigation Events
    document.getElementById('btnPagePrev')?.addEventListener('click', goToPrevPage);
    document.getElementById('btnPageNext')?.addEventListener('click', goToNextPage);
    document.getElementById('btnMobilePrev')?.addEventListener('click', goToPrevPage);
    document.getElementById('btnMobileNext')?.addEventListener('click', goToNextPage);
    document.getElementById('floatingPrevBtn')?.addEventListener('click', goToPrevPage);
    document.getElementById('floatingNextBtn')?.addEventListener('click', goToNextPage);

    // Jump by Input
    pageInput?.addEventListener('change', () => {
        const val = parseInt(pageInput.value, 10);
        if (val >= 1 && val <= totalPages) {
            queueRenderPage(val);
        } else {
            pageInput.value = currentPage;
        }
    });

    // Zoom Events
    document.getElementById('btnZoomIn')?.addEventListener('click', () => setZoom(currentScale * 1.2));
    document.getElementById('btnZoomOut')?.addEventListener('click', () => setZoom(currentScale / 1.2));
    document.getElementById('btnZoomFit')?.addEventListener('click', () => setZoom(computeFitScale(canvas), true));
    document.getElementById('btnMobileZoomIn')?.addEventListener('click', () => setZoom(currentScale * 1.25));
    document.getElementById('btnMobileZoomOut')?.addEventListener('click', () => setZoom(currentScale / 1.25));

    // Fullscreen Toggle
    document.getElementById('btnFullscreenToggle')?.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen?.().catch(() => {});
        } else {
            document.exitFullscreen?.().catch(() => {});
        }
    });

    // View Mode Toggle (Single vs Continuous Scroll)
    document.getElementById('btnViewSingle')?.addEventListener('click', () => {
        viewMode = 'single';
        scrollObserver?.disconnect();
        scrollRenderGeneration++;
        stage.classList.remove('d-none');
        scrollStage.classList.add('d-none');
        document.getElementById('btnViewSingle').classList.add('active');
        document.getElementById('btnViewScroll').classList.remove('active');
        queueRenderPage(currentPage);
    });
    document.getElementById('btnViewScroll')?.addEventListener('click', () => {
        stage.classList.add('d-none');
        scrollStage.classList.remove('d-none');
        document.getElementById('btnViewSingle').classList.remove('active');
        document.getElementById('btnViewScroll').classList.add('active');
        initScrollMode(currentPage);
    });

    // Keyboard Shortcuts (Arrow Left, Right, Page Up, Page Down)
    window.addEventListener('keydown', (e) => {
        if (['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) return;
        if (viewMode === 'scroll' && ['ArrowDown', 'ArrowUp', 'PageDown', 'PageUp', ' '].includes(e.key)) return;
        if (e.key === 'ArrowRight' || e.key === 'PageDown' || e.key === ' ') {
            e.preventDefault();
            goToNextPage();
        } else if (e.key === 'ArrowLeft' || e.key === 'PageUp') {
            e.preventDefault();
            goToPrevPage();
        } else if (e.key === '+' || e.key === '=') {
            e.preventDefault();
            setZoom(currentScale * 1.2);
        } else if (e.key === '-') {
            e.preventDefault();
            setZoom(currentScale / 1.2);
        } else if (e.key === '0') {
            e.preventDefault();
            setZoom(1.0, true);
        }
    });

    // Touch Swipe Gestures for Mobile
    let touchStartX = 0;
    let touchStartY = 0;
    let touchStartTime = 0;

    viewport.addEventListener('touchstart', (e) => {
        if (e.touches.length === 1) {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
            touchStartTime = Date.now();
        }
    }, { passive: true });

    viewport.addEventListener('touchend', (e) => {
        if (e.changedTouches.length === 1) {
            const deltaX = e.changedTouches[0].clientX - touchStartX;
            const deltaY = e.changedTouches[0].clientY - touchStartY;
            const elapsedTime = Date.now() - touchStartTime;

            // Horizontal swipe gesture detection (minimum 45px distance and fast flick)
            if (Math.abs(deltaX) > 45 && Math.abs(deltaX) > Math.abs(deltaY) * 1.5 && elapsedTime < 450) {
                if (deltaX < 0) {
                    goToNextPage();
                } else {
                    goToPrevPage();
                }
            }
        }
    }, { passive: true });

    // Handle Window Resize (Auto re-fit)
    let resizeTimer = null;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (viewMode === 'scroll' && pdfDoc) {
                initScrollMode(currentPage);
            } else if (isFitWidth && pdfDoc) {
                renderPage(currentPage);
            }
        }, 200);
    });

    // Start loading
    loadDocument();
})();
</script>
@endsection
