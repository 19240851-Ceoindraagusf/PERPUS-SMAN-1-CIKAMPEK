@extends('layouts.admin')

@section('title', 'Access Logs')

@section('content')
<h1 class="h3 mb-4">Access Logs</h1>
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h2 class="h5">E-Book Paling Banyak Dibaca</h2>
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead><tr><th>E-Book</th><th>Jumlah Akses</th></tr></thead>
                <tbody>
                @forelse($popularEbooks as $ebook)
                    <tr><td>{{ $ebook->title }}</td><td>{{ $ebook->access_logs_count }}</td></tr>
                @empty
                    <tr><td colspan="2" class="text-muted">Belum ada data akses.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead><tr><th>Waktu</th><th>E-Book</th><th>IP Address</th><th>User Agent</th></tr></thead>
            <tbody>
            @forelse($accessLogs as $log)
                <tr><td>{{ $log->accessed_at?->format('d M Y H:i') }}</td><td>{{ $log->ebook->title ?? '-' }}</td><td>{{ $log->ip_address ?: '-' }}</td><td class="text-truncate" style="max-width: 360px;">{{ $log->user_agent ?: '-' }}</td></tr>
            @empty
                <tr><td colspan="4" class="text-muted">Belum ada data akses.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $accessLogs->links('vendor.pagination.bootstrap-5-simple') }}</div>
</div>
@endsection
