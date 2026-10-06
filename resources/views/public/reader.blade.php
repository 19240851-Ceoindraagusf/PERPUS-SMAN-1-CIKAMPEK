@extends('layouts.public')

@section('title', 'Baca ' . $ebook->title)

@section('content')
<section class="container px-2 px-md-3 py-3 py-md-5" data-ebook-record data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <a href="{{ route('ebooks.show', $ebook) }}" class="small text-decoration-none">← Kembali ke detail</a>
            <h1 class="h4 mb-0 mt-1">{{ $ebook->title }}</h1>
            <p class="text-muted small mb-0">{{ $ebook->subject->name }} · Kelas {{ $ebook->subject->class->name }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-outline-success" data-favorite-button data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}">♡ Favorit</button>
            <button type="button" class="btn btn-outline-secondary" data-reader-theme>Mode gelap</button>
            <button type="button" class="btn btn-outline-secondary" data-reader-fullscreen>Layar penuh</button>
            <a href="{{ route('ebooks.download', $ebook) }}" class="btn btn-success">Download PDF</a>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-end mb-2">
        <p class="small text-muted mb-0">Scroll atau geser untuk membaca. Gunakan kontrol PDF dari browser untuk zoom dan berpindah halaman.</p>
        <div class="d-flex gap-2 align-items-center">
            <label for="pageInput" class="small text-muted mb-0 text-nowrap">Simpan Halaman:</label>
            <input type="number" id="pageInput" class="form-control form-control-sm" style="width: 70px" min="1" placeholder="Hal">
            <button type="button" class="btn btn-sm btn-outline-success" id="savePageBtn">Simpan</button>
            <span id="savePageFeedback" class="small text-success d-none">Tersimpan!</span>
        </div>
    </div>
    <div class="reader-shell" data-reader-shell>
        <iframe id="pdfFrame" class="reader-frame shadow-sm" src="{{ asset('storage/' . $ebook->file_path) }}#view=FitH" title="Pembaca PDF: {{ $ebook->title }}">
            <p>Browser Anda tidak mendukung pembaca PDF. <a href="{{ route('ebooks.download', $ebook) }}">Download PDF</a>.</p>
        </iframe>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.querySelector('[data-reader-theme]')?.addEventListener('click', (event) => {
        const dark = document.querySelector('[data-reader-shell]').classList.toggle('reader-dark');
        event.currentTarget.textContent = dark ? 'Mode terang' : 'Mode gelap';
    });
    document.querySelector('[data-reader-fullscreen]')?.addEventListener('click', () => {
        document.querySelector('[data-reader-shell]')?.requestFullscreen?.();
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
        // update iframe src with hash
        const currentSrc = pdfFrame.src.split('#')[0];
        pdfFrame.src = currentSrc + '#page=' + savedPage + '&view=FitH';
    }

    savePageBtn.addEventListener('click', () => {
        const page = pageInput.value;
        if (page && page > 0) {
            localStorage.setItem('perpus_last_page_' + ebookId, page);
            feedback.classList.remove('d-none');
            setTimeout(() => feedback.classList.add('d-none'), 2000);
            
            // update iframe src to go to that page immediately
            const currentSrc = pdfFrame.src.split('#')[0];
            pdfFrame.src = currentSrc + '#page=' + page + '&view=FitH';
        }
    });
</script>
@endpush
