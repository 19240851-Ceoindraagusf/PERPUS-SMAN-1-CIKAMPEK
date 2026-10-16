@extends('layouts.public')

@section('title', 'Baca ' . $ebook->title)

@section('content')
<section class="container px-2 px-md-3 py-3 py-md-4" data-ebook-record data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}" data-ebook-cover="{{ $ebook->cover_path ? asset('storage/' . $ebook->cover_path) : '' }}" data-ebook-author="{{ $ebook->author ?: '' }}">
    {{-- Header Bar --}}
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-3 p-md-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="min-w-0">
                    <a href="{{ route('ebooks.show', $ebook) }}" class="small text-decoration-none text-muted mb-1 d-inline-flex align-items-center gap-1">
                        <i class="bi bi-arrow-left"></i> <span>Kembali ke detail</span>
                    </a>
                    <h1 class="h5 fw-bold mb-0 text-truncate text-dark">{{ $ebook->title }}</h1>
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill" style="font-size: 0.72rem;">Kelas {{ $ebook->subject->class->name }}</span>
                        <span class="small text-muted text-truncate" style="font-size: 0.8rem;">{{ $ebook->subject->name }}</span>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold" data-favorite-button data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}" data-ebook-cover="{{ $ebook->cover_path ? asset('storage/' . $ebook->cover_path) : '' }}" data-ebook-author="{{ $ebook->author ?: '' }}">
                        ♡ Favorit
                    </button>
                    
                    {{-- Reader Mode Selector --}}
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary active" id="btnModeLight" title="Mode Terang">
                            <i class="bi bi-sun"></i> Terang
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="btnModeSepia" title="Mode Sepia (Hangat)">
                            <i class="bi bi-book"></i> Sepia
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="btnModeDark" title="Mode Gelap">
                            <i class="bi bi-moon"></i> Gelap
                        </button>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-reader-fullscreen title="Tampilan Layar Penuh">
                        <i class="bi bi-arrows-fullscreen me-1"></i> Layar Penuh
                    </button>
                    <a href="{{ route('ebooks.download', $ebook) }}" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold">
                        <i class="bi bi-download me-1"></i> Download PDF
                    </a>
                </div>
            </div>

            <hr class="my-3 opacity-10">

            {{-- Page Marker & Quick Navigation --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <p class="small text-muted mb-0 d-none d-md-block">
                    <i class="bi bi-info-circle me-1"></i> Scroll atau gunakan kontrol PDF bawaan browser untuk zoom dan mencari kata.
                </p>
                <div class="d-flex gap-2 align-items-center ms-auto">
                    <label for="pageInput" class="small text-muted mb-0 text-nowrap fw-semibold">Lompat / Tandai Hal:</label>
                    <input type="number" id="pageInput" class="form-control form-control-sm text-center" style="width: 76px" min="1" placeholder="1">
                    <button type="button" class="btn btn-sm btn-outline-success fw-semibold rounded-pill px-3" id="savePageBtn">
                        <i class="bi bi-bookmark-check me-1"></i> Simpan
                    </button>
                    <span id="savePageFeedback" class="small text-success d-none fw-semibold">
                        <i class="bi bi-check2"></i> Tersimpan!
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Reader Shell & Progress Bar --}}
    <div class="reader-shell shadow-sm rounded-4 p-2 p-md-3 position-relative" data-reader-shell>
        <iframe id="pdfFrame" class="reader-frame rounded-3 shadow-sm w-100" style="min-height: 80vh; border: none;" src="{{ asset('storage/' . $ebook->file_path) }}#view=FitH" title="Pembaca PDF: {{ $ebook->title }}">
            <p>Browser Anda tidak mendukung pembaca PDF bawaan. <a href="{{ route('ebooks.download', $ebook) }}">Download PDF di sini</a>.</p>
        </iframe>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const readerShell = document.querySelector('[data-reader-shell]');
    const btnLight = document.getElementById('btnModeLight');
    const btnSepia = document.getElementById('btnModeSepia');
    const btnDark = document.getElementById('btnModeDark');

    const setReaderMode = (mode) => {
        readerShell.classList.remove('reader-dark', 'reader-sepia');
        btnLight.classList.remove('active');
        btnSepia.classList.remove('active');
        btnDark.classList.remove('active');

        if (mode === 'sepia') {
            readerShell.classList.add('reader-sepia');
            btnSepia.classList.add('active');
        } else if (mode === 'dark') {
            readerShell.classList.add('reader-dark');
            btnDark.classList.add('active');
        } else {
            btnLight.classList.add('active');
        }
        localStorage.setItem('perpus_reader_mode', mode);
    };

    btnLight?.addEventListener('click', () => setReaderMode('light'));
    btnSepia?.addEventListener('click', () => setReaderMode('sepia'));
    btnDark?.addEventListener('click', () => setReaderMode('dark'));

    // Restore saved reader mode
    const savedMode = localStorage.getItem('perpus_reader_mode');
    if (savedMode) setReaderMode(savedMode);

    document.querySelector('[data-reader-fullscreen]')?.addEventListener('click', () => {
        readerShell?.requestFullscreen?.();
    });

    const ebookId = document.querySelector('[data-ebook-id]').dataset.ebookId;
    const savePageBtn = document.getElementById('savePageBtn');
    const pageInput = document.getElementById('pageInput');
    const pdfFrame = document.getElementById('pdfFrame');
    const feedback = document.getElementById('savePageFeedback');
    
    // Load saved page
    const savedPage = localStorage.getItem('perpus_last_page_' + ebookId);
    if (savedPage) {
        pageInput.value = savedPage;
        const currentSrc = pdfFrame.src.split('#')[0];
        pdfFrame.src = currentSrc + '#page=' + savedPage + '&view=FitH';
    }

    savePageBtn?.addEventListener('click', () => {
        const page = pageInput.value;
        if (page && page > 0) {
            localStorage.setItem('perpus_last_page_' + ebookId, page);
            feedback.classList.remove('d-none');
            setTimeout(() => feedback.classList.add('d-none'), 2200);
            
            const currentSrc = pdfFrame.src.split('#')[0];
            pdfFrame.src = currentSrc + '#page=' + page + '&view=FitH';
        }
    });
</script>
@endpush
