@extends('layouts.public')

@section('title', $ebook->title)

@section('content')
<section class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('library') }}">Perpustakaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('classes.show', $ebook->subject->class) }}">Kelas {{ $ebook->subject->class->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subjects.show', [$ebook->subject->class, $ebook->subject]) }}">{{ $ebook->subject->name }}</a></li>
            <li class="breadcrumb-item active">{{ $ebook->title }}</li>
        </ol>
    </nav>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($ebook->cover_path)
                        <img src="{{ asset('storage/' . $ebook->cover_path) }}" class="img-fluid rounded" alt="Cover {{ $ebook->title }}">
                    @else
                        <div class="bg-light rounded p-5 text-muted">Cover belum tersedia</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <span class="badge badge-soft mb-3">Kelas {{ $ebook->subject->class->name }} / {{ $ebook->subject->name }}</span>
            <h1 class="h3">{{ $ebook->title }}</h1>
            <p class="text-muted">{{ $ebook->description ?: 'Belum ada deskripsi e-book.' }}</p>
            <div class="row g-3 mb-4">
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Mata Pelajaran</div><div class="fw-semibold">{{ $ebook->subject->name }}</div></div></div>
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Penulis</div><div class="fw-semibold">{{ $ebook->author ?: '-' }}</div></div></div>
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Penerbit</div><div class="fw-semibold">{{ $ebook->publisher ?: '-' }}</div></div></div>
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Tahun</div><div class="fw-semibold">{{ $ebook->publication_year ?: '-' }}</div></div></div>
            </div>
            @if($ebook->file_path)
                <a href="{{ asset('storage/' . $ebook->file_path) }}" class="btn btn-success" target="_blank">Baca E-Book</a>
                <a href="{{ route('ebooks.download', $ebook) }}" class="btn btn-outline-success">Download</a>
            @else
                <div class="alert alert-warning">File PDF belum tersedia.</div>
            @endif
        </div>
    </div>
</section>
@endsection
