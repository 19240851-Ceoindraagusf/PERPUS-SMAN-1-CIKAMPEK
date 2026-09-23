@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div>
        <h1 class="h3 mb-1">Dashboard Admin</h1>
        <p class="text-muted mb-0">Pantau koleksi, kelas, dan aktivitas akses perpustakaan digital.</p>
    </div>
    <a href="{{ route('admin.ebooks.create') }}" class="btn btn-success">Tambah E-Book</a>
</div>
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3"><div class="admin-card stat-card card"><div class="card-body d-flex justify-content-between gap-3"><div><div class="text-muted">Total Kelas</div><div class="h3 mb-0">{{ $stats['classes'] }}</div></div><div class="stat-icon">K</div></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="admin-card stat-card card"><div class="card-body d-flex justify-content-between gap-3"><div><div class="text-muted">Mata Pelajaran</div><div class="h3 mb-0">{{ $stats['subjects'] }}</div></div><div class="stat-icon">M</div></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="admin-card stat-card card"><div class="card-body d-flex justify-content-between gap-3"><div><div class="text-muted">Total E-Book</div><div class="h3 mb-0">{{ $stats['ebooks'] }}</div></div><div class="stat-icon">E</div></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="admin-card stat-card card"><div class="card-body d-flex justify-content-between gap-3"><div><div class="text-muted">Total Akses</div><div class="h3 mb-0">{{ $stats['accesses'] }}</div></div><div class="stat-icon">A</div></div></div></div>
</div>
<div class="row g-4">
    <div class="col-lg-6">
        <div class="admin-card card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="h5 mb-0">E-Book Terbaru</h2>
                    <a href="{{ route('admin.ebooks.index') }}" class="small">Kelola</a>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($latestEbooks as $ebook)
                        <li class="list-group-item px-0">
                            <div class="fw-semibold">{{ $ebook->title }}</div>
                            <div class="text-muted small">Kelas {{ $ebook->subject->class->name ?? '-' }} / {{ $ebook->subject->name ?? '-' }}</div>
                        </li>
                    @empty
                        <li class="list-group-item px-0 text-muted">Belum ada e-book.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="admin-card card">
            <div class="card-body">
                <h2 class="h5">E-Book Paling Banyak Diakses</h2>
                <ul class="list-group list-group-flush">
                    @forelse($popularEbooks as $ebook)
                        <li class="list-group-item px-0 d-flex justify-content-between gap-3">
                            <span>
                                <span class="fw-semibold d-block">{{ $ebook->title }}</span>
                                <span class="text-muted small">{{ $ebook->subject->name ?? '-' }}</span>
                            </span>
                            <span class="badge text-bg-success align-self-center">{{ $ebook->access_logs_count }}</span>
                        </li>
                    @empty
                        <li class="list-group-item px-0 text-muted">Belum ada data akses.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="admin-card card">
            <div class="card-body">
                <h2 class="h5">Aktivitas Akses Terbaru</h2>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>E-Book</th>
                                <th>Kelas / Mapel</th>
                                <th>Waktu</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestAccessLogs as $log)
                                <tr>
                                    <td>{{ $log->ebook->title ?? '-' }}</td>
                                    <td class="text-muted">Kelas {{ $log->ebook->subject->class->name ?? '-' }} / {{ $log->ebook->subject->name ?? '-' }}</td>
                                    <td>{{ optional($log->accessed_at)->format('d M Y H:i') }}</td>
                                    <td class="text-muted">{{ $log->ip_address ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-muted">Belum ada aktivitas akses.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
