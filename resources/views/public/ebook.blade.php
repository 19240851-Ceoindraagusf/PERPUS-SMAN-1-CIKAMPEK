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
            <h1 class="h3">{{ $ebook->title }}</h1>
            <p class="text-muted">{{ $ebook->description ?: 'Belum ada deskripsi e-book.' }}</p>
            <dl class="row">
                <dt class="col-sm-4">Mata Pelajaran</dt><dd class="col-sm-8">{{ $ebook->subject->name }}</dd>
                <dt class="col-sm-4">Penulis</dt><dd class="col-sm-8">{{ $ebook->author ?: '-' }}</dd>
                <dt class="col-sm-4">Penerbit</dt><dd class="col-sm-8">{{ $ebook->publisher ?: '-' }}</dd>
                <dt class="col-sm-4">Tahun</dt><dd class="col-sm-8">{{ $ebook->publication_year ?: '-' }}</dd>
            </dl>
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
