@extends('layouts.public')

@section('title', 'Baca ' . $ebook->title)

@section('content')
<section class="container py-4 py-md-5" data-ebook-record data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}">
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
    <p class="small text-muted mb-2">Scroll atau geser untuk membaca. Gunakan kontrol PDF dari browser untuk zoom dan berpindah halaman.</p>
    <div class="reader-shell" data-reader-shell>
        <iframe class="reader-frame shadow-sm" src="{{ asset('storage/' . $ebook->file_path) }}#view=FitH" title="Pembaca PDF: {{ $ebook->title }}">
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
</script>
@endpush
