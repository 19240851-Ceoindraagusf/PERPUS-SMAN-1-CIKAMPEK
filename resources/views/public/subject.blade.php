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
            <h1 class="h3">{{ $subject->name }}</h1>
            <p class="text-muted mb-0">{{ $subject->description ?: 'Belum ada deskripsi mata pelajaran.' }}</p>
        </div>
        <span class="badge text-bg-success">{{ $subject->ebooks->count() }} e-book</span>
    </div>
    <div class="row g-3">
        @forelse($subject->ebooks as $ebook)
            <div class="col-md-6">
                <div class="info-card card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <div class="icon-box">PDF</div>
                            <span class="badge badge-soft">{{ $ebook->publication_year ?: 'Tahun -' }}</span>
                        </div>
                        <h2 class="h5">{{ $ebook->title }}</h2>
                        <p class="text-muted">{{ $ebook->description ?: 'Belum ada deskripsi.' }}</p>
                        <div class="small text-muted mb-3">
                            {{ $ebook->author ?: 'Penulis belum diisi' }} &middot; {{ $ebook->publisher ?: 'Penerbit belum diisi' }}
                        </div>
                        <a href="{{ route('ebooks.show', $ebook) }}" class="btn btn-success">Baca E-Book</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">E-book untuk mata pelajaran ini belum tersedia.</div></div>
        @endforelse
    </div>
</section>
@endsection
