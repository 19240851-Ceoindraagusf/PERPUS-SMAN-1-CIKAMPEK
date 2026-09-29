@extends('layouts.public')

@section('title', $subject->name)

@section('content')
<section class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('library') }}">Perpustakaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('classes.show', $class) }}">Kelas {{ $class->name }}</a></li>
            <li class="breadcrumb-item active">{{ $subject->name }}</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <p class="eyebrow mb-1">Kelas {{ $class->name }}</p>
            <h1 class="h3">{{ $subject->name }}</h1>
            <p class="text-muted mb-0">{{ $subject->description ?: 'Pilih buku digital yang ingin dipelajari.' }}</p>
        </div>
        <span class="badge text-bg-success">{{ $subject->ebooks->count() }} e-book</span>
    </div>
    <div class="row g-3">
        @forelse($subject->ebooks as $ebook)
            <div class="col-md-6">
                <article class="collection-card info-card card h-100">
                    <div class="card-body d-flex gap-3">
                        <a href="{{ route('ebooks.show', $ebook) }}" class="book-row-cover">
                            @if($ebook->cover_path)
                                <img src="{{ asset('storage/' . $ebook->cover_path) }}" class="book-cover rounded" alt="Cover {{ $ebook->title }}">
                            @else
                                <div class="book-cover-placeholder rounded p-2"><small>BUKU DIGITAL</small><strong class="small">{{ $subject->name }}</strong></div>
                            @endif
                        </a>
                        <div class="min-w-0 d-flex flex-column">
                            <div><span class="badge badge-soft mb-2">{{ $ebook->publication_year ?: 'Tahun belum diisi' }}</span>
                            <h2 class="h5"><a href="{{ route('ebooks.show', $ebook) }}" class="text-decoration-none text-dark">{{ $ebook->title }}</a></h2>
                            <p class="text-muted small mb-2">{{ $ebook->author ?: 'Penulis belum diisi' }}</p></div>
                            <a href="{{ route('ebooks.show', $ebook) }}" class="btn btn-success mt-auto">Baca Sekarang</a>
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">E-book untuk mata pelajaran ini belum tersedia.</div></div>
        @endforelse
    </div>
</section>
@endsection
