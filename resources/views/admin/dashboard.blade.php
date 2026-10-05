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
    <div class="col-sm-6 col-xl-3"><div class="admin-card stat-card card"><div class="card-body d-flex justify-content-between"><div><div class="text-muted">Total Kelas</div><div class="h3 mb-0">{{ $stats['classes'] }}</div></div><div class="stat-icon">K</div></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="admin-card stat-card card"><div class="card-body d-flex justify-content-between"><div><div class="text-muted">Mata Pelajaran</div><div class="h3 mb-0">{{ $stats['subjects'] }}</div></div><div class="stat-icon">M</div></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="admin-card stat-card card"><div class="card-body d-flex justify-content-between"><div><div class="text-muted">Total E-Book</div><div class="h3 mb-0">{{ $stats['ebooks'] }}</div></div><div class="stat-icon">E</div></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="admin-card stat-card card"><div class="card-body d-flex justify-content-between"><div><div class="text-muted">Mulai Dibaca</div><div class="h3 mb-0">{{ $stats['reads'] }}</div><div class="small text-muted">{{ $stats['downloads'] }} unduhan</div></div><div class="stat-icon">B</div></div></div></div>
</div>
@if($stats['open_reports'] || $stats['pending_comments'])
    <div class="alert alert-warning d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4"><span><strong>Perlu perhatian:</strong> {{ $stats['open_reports'] }} laporan e-book dan {{ $stats['pending_comments'] }} komentar menunggu.</span><span class="d-flex gap-2"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.ebook-reports.index') }}">Lihat laporan</a><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.ebook-comments.index') }}">Moderasi komentar</a></span></div>
@endif
<section class="audit-summary mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
        <div>
            <p class="text-success small fw-semibold text-uppercase mb-1">Audit kualitas koleksi</p>
            <h2 class="h5 mb-1">Periksa data sebelum ditemukan siswa</h2>
            <p class="text-muted small mb-0">Mendeteksi file PDF, cover, penulis, penerbit, tahun terbit, dan deskripsi yang perlu dilengkapi atau diperiksa.</p>
        </div>
        <a href="{{ route('admin.ebooks.index') }}" class="btn btn-outline-success btn-sm">Kelola semua e-book</a>
    </div>
    <div class="row g-3">
        <div class="col-sm-6 col-lg-3"><div class="metric"><div class="small text-muted">Koleksi siap</div><strong class="h4 mb-0">{{ $collectionAudit['ready'] }} <small class="fs-6 fw-normal">dari {{ $collectionAudit['total'] }}</small></strong></div></div>
        <div class="col-sm-6 col-lg-3"><div class="metric"><div class="small text-muted">Perlu ditinjau</div><strong class="h4 mb-0">{{ $collectionAudit['needs_review'] }}</strong></div></div>
        <div class="col-sm-6 col-lg-3"><div class="metric"><div class="small text-muted">File bermasalah</div><strong class="h4 mb-0 text-danger">{{ $collectionAudit['critical'] }}</strong></div></div>
        <div class="col-sm-6 col-lg-3"><div class="metric"><div class="small text-muted">Tanpa cover</div><strong class="h4 mb-0">{{ $collectionHealth['without_cover'] }}</strong></div></div>
    </div>
</section>
<section class="admin-card card mb-4">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div><h2 class="h5 mb-1">Prioritas perbaikan koleksi</h2><p class="small text-muted mb-0">Urutan tertinggi diberikan untuk PDF yang tidak tersedia dan metadata yang tampak tidak valid.</p></div>
            <span class="badge text-bg-light">Maks. 12 e-book</span>
        </div>
        @forelse($auditEbooks as $ebook)
            @php($hasCriticalIssue = collect($ebook->audit_issues)->contains('level', 'critical'))
            <article class="audit-item {{ $hasCriticalIssue ? 'critical' : '' }} rounded bg-light p-3 mb-2">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                    <div>
                        <h3 class="h6 mb-1">{{ $ebook->title }}</h3>
                        <p class="small text-muted mb-2">Kelas {{ $ebook->subject->class->name ?? '-' }} · {{ $ebook->subject->name ?? '-' }}</p>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($ebook->audit_issues as $issue)
                                <span class="badge audit-badge-{{ $issue['level'] }}">{{ $issue['label'] }}</span>
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ route('admin.ebooks.edit', $ebook) }}" class="btn btn-sm btn-success">Perbaiki</a>
                </div>
            </article>
        @empty
            <div class="text-center py-4"><div class="h5 text-success">Koleksi sudah rapi</div><p class="text-muted mb-0">Tidak ada masalah kualitas data yang terdeteksi saat ini.</p></div>
        @endforelse
    </div>
</section>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="admin-card card h-100"><div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3"><div><h2 class="h5 mb-1">Tren belajar 7 hari terakhir</h2><p class="small text-muted mb-0">Pembacaan dan unduhan unik per siswa/per hari.</p></div><span class="badge text-bg-success">{{ $weeklyAccesses->sum('count') }} aktivitas</span></div>
            @php($chartMax = max(1, $weeklyAccesses->max('count')))
            <div class="activity-chart">
                @foreach($weeklyAccesses as $day)
                    <div class="activity-bar-wrap"><span class="small fw-semibold">{{ $day['count'] }}</span><div class="activity-bar" style="height: {{ max(5, ($day['count'] / $chartMax) * 125) }}px" title="{{ $day['count'] }} akses"></div><span class="small text-muted">{{ $day['label'] }}</span></div>
                @endforeach
            </div>
        </div></div>
    </div>
    <div class="col-lg-5">
        <div class="admin-card card h-100"><div class="card-body">
            <h2 class="h5 mb-1">Kelengkapan koleksi</h2><p class="small text-muted mb-3">Data yang perlu dilengkapi agar katalog lebih menarik.</p>
            <div class="metric mb-3"><div class="small text-muted">E-book tanpa cover</div><div class="d-flex justify-content-between align-items-center"><strong>{{ $collectionHealth['without_cover'] }} buku</strong><a class="small" href="{{ route('admin.ebooks.index') }}">Perbaiki →</a></div></div>
            <div class="metric"><div class="small text-muted">E-book tanpa deskripsi</div><div class="d-flex justify-content-between align-items-center"><strong>{{ $collectionHealth['without_description'] }} buku</strong><a class="small" href="{{ route('admin.ebooks.index') }}">Perbaiki →</a></div></div>
        </div></div>
    </div>
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
                            <span class="badge text-bg-success align-self-center">{{ $ebook->reads_count }}</span>
                        </li>
                    @empty
                        <li class="list-group-item px-0 text-muted">Belum ada data akses.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="admin-card card">
            <div class="card-body">
                <h2 class="h5">Kelas dengan Materi Terbanyak</h2>
                <ul class="list-group list-group-flush">
                    @forelse($topClasses as $class)
                        <li class="list-group-item px-0 d-flex justify-content-between gap-3">
                            <span>
                                <span class="fw-semibold d-block">Kelas {{ $class->name }}</span>
                                <span class="text-muted small">{{ $class->subjects_count ?? 0 }} mapel aktif</span>
                            </span>
                            <span class="badge text-bg-primary align-self-center">{{ $class->ebooks_count ?? 0 }}</span>
                        </li>
                    @empty
                        <li class="list-group-item px-0 text-muted">Belum ada data kelas.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="admin-card card">
            <div class="card-body">
                <h2 class="h5">Mapel Paling Banyak Diakses</h2>
                <ul class="list-group list-group-flush">
                    @forelse($topSubjects as $subject)
                        <li class="list-group-item px-0 d-flex justify-content-between gap-3">
                            <span>
                                <span class="fw-semibold d-block">{{ $subject->name }}</span>
                                <span class="text-muted small">Kelas {{ $subject->class->name ?? '-' }}</span>
                            </span>
                            <span class="badge text-bg-warning align-self-center">{{ $subject->access_count ?? 0 }}</span>
                        </li>
                    @empty
                        <li class="list-group-item px-0 text-muted">Belum ada data mapel.</li>
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
                                <th>Aksi / Waktu</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestAccessLogs as $log)
                                <tr>
                                    <td>{{ $log->ebook->title ?? '-' }}</td>
                                    <td class="text-muted">Kelas {{ $log->ebook->subject->class->name ?? '-' }} / {{ $log->ebook->subject->name ?? '-' }}</td>
                                    <td><span class="badge text-bg-light">{{ ['view' => 'Detail', 'read' => 'Baca', 'download' => 'Unduh'][$log->action] ?? $log->action }}</span><div class="small text-muted mt-1">{{ optional($log->accessed_at)->format('d M Y H:i') }}</div></td>
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
