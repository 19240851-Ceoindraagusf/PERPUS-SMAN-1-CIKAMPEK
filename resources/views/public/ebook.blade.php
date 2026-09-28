@extends('layouts.public')

@section('title', $ebook->title)

@section('content')
<section class="container py-4 py-md-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('library') }}">Perpustakaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('classes.show', $ebook->subject->class) }}">Kelas {{ $ebook->subject->class->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subjects.show', [$ebook->subject->class, $ebook->subject]) }}">{{ $ebook->subject->name }}</a></li>
            <li class="breadcrumb-item active">{{ $ebook->title }}</li>
        </ol>
    </nav>

    <div class="row g-4 align-items-start">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 p-md-4 text-center">
                    @if($ebook->cover_path)
                        <img src="{{ asset('storage/' . $ebook->cover_path) }}" class="img-fluid rounded" alt="Cover {{ $ebook->title }}" style="max-height: 28rem; object-fit: cover; width: 100%;">
                    @else
                        <div class="bg-light rounded p-5 text-muted">Cover belum tersedia</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <span class="badge badge-soft mb-3">Kelas {{ $ebook->subject->class->name }} / {{ $ebook->subject->name }}</span>
            <h1 class="h2 mb-3">{{ $ebook->title }}</h1>
            <p class="text-muted mb-4">{{ $ebook->description ?: 'Belum ada deskripsi e-book.' }}</p>

            <div class="row g-3 mb-4">
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Mata Pelajaran</div><div class="fw-semibold">{{ $ebook->subject->name }}</div></div></div>
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Penulis</div><div class="fw-semibold">{{ $ebook->author ?: '-' }}</div></div></div>
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Penerbit</div><div class="fw-semibold">{{ $ebook->publisher ?: '-' }}</div></div></div>
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Tahun</div><div class="fw-semibold">{{ $ebook->publication_year ?: '-' }}</div></div></div>
            </div>

            @if($ebook->file_path)
                <div class="d-flex flex-column flex-sm-row gap-2 sticky-bottom pb-2">
                    <a href="{{ asset('storage/' . $ebook->file_path) }}" class="btn btn-success flex-fill" target="_blank" rel="noopener">Baca E-Book</a>
                    <a href="{{ route('ebooks.download', $ebook) }}" class="btn btn-outline-success flex-fill">Download</a>
                </div>
            @else
                <div class="alert alert-warning mb-0">File PDF belum tersedia.</div>
            @endif
        </div>
    </div>
</section>
@endsection
