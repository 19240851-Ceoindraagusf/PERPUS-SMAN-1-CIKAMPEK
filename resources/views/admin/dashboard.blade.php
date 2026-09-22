@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<h1 class="h3 mb-4">Dashboard Admin</h1>
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Total Kelas</div><div class="h3 mb-0">{{ $stats['classes'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Total Mata Pelajaran</div><div class="h3 mb-0">{{ $stats['subjects'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Total E-Book</div><div class="h3 mb-0">{{ $stats['ebooks'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Total Akses</div><div class="h3 mb-0">{{ $stats['accesses'] }}</div></div></div></div>
</div>
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5">E-Book Terbaru</h2>
                <ul class="list-group list-group-flush">
                    @forelse($latestEbooks as $ebook)
                        <li class="list-group-item px-0">{{ $ebook->title }} <span class="text-muted small">({{ $ebook->subject->name ?? '-' }})</span></li>
                    @empty
                        <li class="list-group-item px-0 text-muted">Belum ada e-book.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5">E-Book Paling Banyak Diakses</h2>
                <ul class="list-group list-group-flush">
                    @forelse($popularEbooks as $ebook)
                        <li class="list-group-item px-0 d-flex justify-content-between"><span>{{ $ebook->title }}</span><span class="badge text-bg-success">{{ $ebook->access_logs_count }}</span></li>
                    @empty
                        <li class="list-group-item px-0 text-muted">Belum ada data akses.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
