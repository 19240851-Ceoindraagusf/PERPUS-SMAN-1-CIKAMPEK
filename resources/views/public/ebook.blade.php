@extends('layouts.public')

@section('title', $ebook->title)
@section('meta_description', $ebook->description ?: 'Baca ' . $ebook->title . ' di Perpustakaan Digital SMAN 1 Cikampek.')

@section('content')
<section class="container py-4 py-md-5" data-ebook-record data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}">
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
                        <img src="{{ asset('storage/' . $ebook->cover_path) }}" class="detail-cover rounded" loading="lazy" decoding="async" alt="Cover {{ $ebook->title }}">
                    @else
                        @include('public._book-cover', ['ebook' => $ebook])
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <p class="eyebrow mb-2">Kelas {{ $ebook->subject->class->name }} / {{ $ebook->subject->name }}</p>
            <span class="badge badge-soft mb-3">E-book tersedia untuk dibaca</span>
            <h1 class="h2 mb-3">{{ $ebook->title }}</h1>
            <p class="text-muted mb-4">{{ $ebook->description ?: 'Belum ada deskripsi e-book.' }}</p>

            <div class="row g-3 mb-4">
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Mata Pelajaran</div><div class="fw-semibold">{{ $ebook->subject->name }}</div></div></div>
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Penulis</div><div class="fw-semibold">{{ $ebook->author ?: '-' }}</div></div></div>
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Penerbit</div><div class="fw-semibold">{{ $ebook->publisher ?: '-' }}</div></div></div>
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Tahun</div><div class="fw-semibold">{{ $ebook->publication_year ?: '-' }}</div></div></div>
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Telah dibaca</div><div class="fw-semibold">{{ $ebook->access_logs_count }} kali</div></div></div>
            </div>

            @if($ebook->file_path)
                <div class="detail-actions d-flex flex-column flex-sm-row gap-2">
                    <a href="{{ route('ebooks.reader', $ebook) }}" class="btn btn-success flex-fill">Baca Sekarang</a>
                    <a href="{{ route('ebooks.download', $ebook) }}" class="btn btn-outline-success flex-fill">Download</a>
                </div>
                <button type="button" class="btn btn-outline-success mt-2 w-100" data-favorite-button data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}">♡ Simpan ke favorit</button>
            @else
                <div class="alert alert-warning mb-0">File PDF belum tersedia.</div>
            @endif
        </div>
    </div>

    @if($relatedEbooks->isNotEmpty())
        <section class="mt-5 pt-4 catalog-toolbar">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
                <div><p class="eyebrow mb-1">Lanjutkan belajar</p><h2 class="h4 mb-0">E-Book terkait</h2></div>
                <a class="small fw-semibold text-decoration-none" href="{{ route('subjects.show', [$ebook->subject->class, $ebook->subject]) }}">Lihat semua mapel →</a>
            </div>
            <div class="row g-3">
                @foreach($relatedEbooks as $related)
                    <div class="col-6 col-md-3">
                        <article class="collection-card info-card card h-100">
                            <a class="text-decoration-none text-dark" href="{{ route('ebooks.show', $related) }}">
                                @include('public._book-cover', ['ebook' => $related])
                                <div class="card-body"><h3 class="h6 book-title mb-0">{{ $related->title }}</h3></div>
                            </a>
                        </article>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</section>
@endsection
