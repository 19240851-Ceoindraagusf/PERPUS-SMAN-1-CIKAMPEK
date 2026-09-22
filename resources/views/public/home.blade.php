@extends('layouts.public')

@section('title', 'Perpustakaan Digital SMAN 1 Cikampek')

@section('content')
<section class="hero py-5">
    <div class="container py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="text-uppercase fw-semibold mb-2">PERPUSTAKAAN DIGITAL</p>
                <h1 class="display-5 fw-bold">SMAN 1 CIKAMPEK</h1>
                <p class="lead mt-3">Akses materi dan e-book pembelajaran siswa secara mudah melalui website perpustakaan digital sekolah.</p>
                <a href="{{ route('library') }}" class="btn btn-light btn-lg mt-3">Mulai Membaca</a>
            </div>
            <div class="col-lg-5">
                <div class="card text-dark">
                    <div class="card-body p-4">
                        <h2 class="h5">Alur Akses</h2>
                        <p class="mb-0 text-muted">Pilih kelas, pilih mata pelajaran, lalu buka materi atau e-book yang tersedia.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="row g-4">
        <div class="col-lg-4">
            <h2 class="h4">Daftar Kelas</h2>
            <p class="text-muted">Data kelas berasal dari database dan siap dikembangkan untuk kebutuhan perpustakaan.</p>
        </div>
        <div class="col-lg-8">
            <div class="row g-3">
                @forelse($classes as $class)
                    <div class="col-md-4">
                        <a class="card text-decoration-none text-dark h-100" href="{{ route('classes.show', $class) }}">
                            <div class="card-body">
                                <h3 class="h5 mb-1">Kelas {{ $class->name }}</h3>
                                <p class="text-muted mb-0">{{ $class->description }}</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12"><div class="alert alert-info">Data kelas belum tersedia.</div></div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
