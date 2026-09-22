@extends('layouts.public')

@section('title', 'Perpustakaan Digital')

@section('content')
<section class="container py-5">
    <h1 class="h3 mb-1">PERPUSTAKAAN DIGITAL<br>SMAN 1 CIKAMPEK</h1>
    <p class="text-muted mb-4">Pilih kelas untuk melihat mata pelajaran dan e-book yang tersedia.</p>
    <div class="row g-3">
        @forelse($classes as $class)
            <div class="col-md-4">
                <a href="{{ route('classes.show', $class) }}" class="card h-100 text-decoration-none text-dark">
                    <div class="card-body">
                        <h2 class="h4">Kelas {{ $class->name }}</h2>
                        <p class="text-muted mb-0">{{ $class->description }}</p>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">Data kelas belum tersedia.</div></div>
        @endforelse
    </div>
</section>
@endsection
