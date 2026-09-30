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
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-success" data-favorite-button data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}">♡ Favorit</button>
            <a href="{{ route('ebooks.download', $ebook) }}" class="btn btn-success">Download PDF</a>
        </div>
    </div>
    <iframe class="reader-frame shadow-sm" src="{{ asset('storage/' . $ebook->file_path) }}#view=FitH" title="Pembaca PDF: {{ $ebook->title }}">
        <p>Browser Anda tidak mendukung pembaca PDF. <a href="{{ route('ebooks.download', $ebook) }}">Download PDF</a>.</p>
    </iframe>
</section>
@endsection
