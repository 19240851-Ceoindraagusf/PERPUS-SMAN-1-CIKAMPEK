@extends('layouts.public')

@section('title', 'Favorit Saya')

@section('content')
<section class="container py-5">
    <div class="section-title mb-4">
        <p class="eyebrow mb-1">Koleksi pribadi</p>
        <h1 class="h3 mb-1">Favorit & Terakhir Dibuka</h1>
        <p class="text-muted mb-0">Daftar ini tersimpan di browser pada perangkat yang sedang Anda gunakan.</p>
    </div>
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card h-100"><div class="card-body">
                <h2 class="h5 mb-3">Buku favorit</h2>
                <div data-favorites-list class="text-muted"></div>
            </div></div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100"><div class="card-body">
                <h2 class="h5 mb-3">Terakhir dibuka</h2>
                <div data-recent-list class="text-muted"></div>
            </div></div>
        </div>
    </div>
</section>
@endsection
