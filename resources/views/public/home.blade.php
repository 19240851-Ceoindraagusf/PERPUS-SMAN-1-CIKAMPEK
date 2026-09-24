@extends('layouts.public')

@section('title', 'Perpustakaan Digital SMAN 1 Cikampek')

@section('content')
<section class="hero py-5">
    <div class="container py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="text-uppercase fw-semibold mb-2 opacity-75">PERPUSTAKAAN DIGITAL SMAN 1 CIKAMPEK</p>
                <h1 class="display-5 fw-bold">SMAN 1 CIKAMPEK</h1>
                <p class="lead mt-3">Akses materi dan e-book pembelajaran siswa secara mudah melalui website perpustakaan digital sekolah.</p>
                <form action="{{ route('home') }}" method="GET" class="hero-panel p-3 mt-4">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-lg" placeholder="Cari kelas, mata pelajaran, atau e-book">
                        </div>
                        <div class="col-md-3">
                            <select name="class" class="form-select form-select-lg">
                                <option value="">Semua kelas</option>
                                @foreach($classOptions as $className)
                                    <option value="{{ $className }}" @selected(request('class') === $className)>Kelas {{ $className }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-light btn-lg w-100" type="submit">Cari Materi</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="hero-panel p-4">
                    <h2 class="h5 mb-3">Ringkas dan siap dipakai siswa</h2>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="h2 fw-bold mb-0">{{ $stats['classes'] }}</div>
                            <div class="small opacity-75">Kelas aktif</div>
                        </div>
                        <div class="col-6">
                            <div class="h2 fw-bold mb-0">{{ $stats['subjects'] }}</div>
                            <div class="small opacity-75">Mata pelajaran</div>
                        </div>
                        <div class="col-6">
                            <div class="h2 fw-bold mb-0">{{ $stats['ebooks'] }}</div>
                            <div class="small opacity-75">E-book</div>
                        </div>
                        <div class="col-6">
                            <div class="h2 fw-bold mb-0">{{ $stats['accesses'] }}</div>
                            <div class="small opacity-75">Total akses</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div class="section-title">
            <h2 class="h4 mb-1">Daftar Kelas</h2>
            <p class="text-muted mb-0">Pilih kelas untuk masuk ke mata pelajaran dan koleksi e-book yang tersedia.</p>
        </div>
        <a href="{{ route('library') }}" class="btn btn-outline-success">Lihat Semua</a>
    </div>
    <div class="row g-3">
        @forelse($classes as $class)
            <div class="col-md-6 col-lg-4">
                <a class="info-card card text-decoration-none text-dark h-100" href="{{ route('classes.show', $class) }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <div class="icon-box">{{ $class->name }}</div>
                            <span class="badge badge-soft">{{ $class->subjects_count }} mapel</span>
                        </div>
                        <h3 class="h5 mb-1">Kelas {{ $class->name }}</h3>
                        <p class="text-muted mb-3">{{ $class->description ?: 'Koleksi materi pembelajaran digital.' }}</p>
                        <div class="small text-muted">{{ $class->ebooks_count }} e-book tersedia</div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">Data kelas belum tersedia.</div></div>
        @endforelse
    </div>
</section>

<section class="container pb-5">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div class="section-title">
            <h2 class="h4 mb-1">E-Book Terbaru</h2>
            <p class="text-muted mb-0">Koleksi terbaru yang dapat langsung dibaca siswa.</p>
        </div>
    </div>
    <div class="row g-3">
        @forelse($latestEbooks as $ebook)
            <div class="col-md-6 col-lg-3">
                <a class="info-card card h-100 text-decoration-none text-dark" href="{{ route('ebooks.show', $ebook) }}">
                    <div class="card-body">
                        <span class="badge badge-soft mb-3">{{ $ebook->subject->class->name ?? '-' }} / {{ $ebook->subject->name ?? '-' }}</span>
                        <h3 class="h6">{{ $ebook->title }}</h3>
                        <p class="text-muted small mb-1">{{ $ebook->author ?: 'Penulis belum diisi' }}</p>
                        <p class="text-muted small mb-0">{{ $ebook->publisher ?: 'Penerbit belum diisi' }}</p>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">E-book belum tersedia.</div></div>
        @endforelse
    </div>
</section>
@endsection
