@extends('layouts.public')

@section('title', 'Materi Kelas ' . $class->name)

@section('content')
<section class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('library') }}">Perpustakaan</a></li>
            <li class="breadcrumb-item active">Kelas {{ $class->name }}</li>
        </ol>
    </nav>
    <h1 class="h3 mb-4">Materi Pembelajaran Kelas {{ $class->name }}</h1>
    <div class="row g-3">
        @forelse($class->subjects as $subject)
            <div class="col-md-6 col-lg-4">
                <a class="card h-100 text-decoration-none text-dark" href="{{ route('subjects.show', [$class, $subject]) }}">
                    <div class="card-body">
                        <h2 class="h5">{{ $subject->name }}</h2>
                        <p class="text-muted mb-0">{{ $subject->description ?: 'Belum ada deskripsi.' }}</p>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">Mata pelajaran belum tersedia.</div></div>
        @endforelse
    </div>
</section>
@endsection
