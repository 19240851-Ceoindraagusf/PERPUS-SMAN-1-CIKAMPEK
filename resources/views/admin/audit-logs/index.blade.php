@extends('layouts.admin')

@section('title', 'Audit Log Aktivitas')

@section('content')
<div class="container-fluid px-0">
    {{-- Header Banner --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4 d-flex align-items-center gap-3">
            <div class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 46px; height: 46px; background: rgba(15, 118, 110, 0.12); color: #0f766e;">
                <i class="bi bi-activity fs-4"></i>
            </div>
            <div>
                <h1 class="h4 mb-0 fw-bold text-dark">Audit Log Aktivitas</h1>
            </div>
        </div>
    </div>

    {{-- Filter and Content Card --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            {{-- Filter Form --}}
            <form method="GET" action="{{ route('admin.audit-logs.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label small text-muted fw-semibold mb-1">Cari Aktivitas</label>
                        <input type="text" name="search" class="form-control" placeholder="Deskripsi atau nama user" value="{{ $search ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-semibold mb-1">Aksi</label>
                        <select name="action" class="form-select">
                            <option value="">Semua aksi</option>
                            @foreach($actions as $act)
                                <option value="{{ $act }}" {{ ($selectedAction ?? '') === $act ? 'selected' : '' }}>{{ $act }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn text-white px-4 fw-semibold" style="background-color: #0f766e; border-color: #0f766e;">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline-secondary px-3">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            {{-- Table --}}
            <div class="table-responsive mt-4">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr class="text-uppercase text-muted" style="font-size: 0.78rem; letter-spacing: 0.05em; border-bottom: 2px solid #edf2f7;">
                            <th style="font-weight: 700; width: 16%; padding-top: 1rem; padding-bottom: 1rem;">WAKTU</th>
                            <th style="font-weight: 700; width: 18%; padding-top: 1rem; padding-bottom: 1rem;">USER</th>
                            <th style="font-weight: 700; width: 14%; padding-top: 1rem; padding-bottom: 1rem;">AKSI</th>
                            <th style="font-weight: 700; width: 38%; padding-top: 1rem; padding-bottom: 1rem;">AKTIVITAS</th>
                            <th style="font-weight: 700; width: 14%; padding-top: 1rem; padding-bottom: 1rem;">IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auditLogs as $log)
                            <tr style="border-bottom: 1px solid #f1f4f8;">
                                <td class="text-nowrap" style="color: #4b5563; font-size: 0.88rem; padding-top: 0.95rem; padding-bottom: 0.95rem;">
                                    {{ $log->created_at ? $log->created_at->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="fw-semibold text-dark" style="font-size: 0.88rem; padding-top: 0.95rem; padding-bottom: 0.95rem;">
                                    {{ $log->user_name ?? ($log->user?->name ?? 'Admin Perpustakaan') }}
                                </td>
                                <td style="padding-top: 0.95rem; padding-bottom: 0.95rem;">
                                    <span class="badge border border-secondary-subtle bg-white text-dark fw-medium px-2 py-1 rounded" style="font-size: 0.78rem;">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td style="color: #374151; font-size: 0.88rem; padding-top: 0.95rem; padding-bottom: 0.95rem;">
                                    {{ $log->description }}
                                </td>
                                <td class="text-muted" style="font-size: 0.85rem; padding-top: 0.95rem; padding-bottom: 0.95rem;">
                                    {{ $log->ip_address ?: '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary opacity-50"></i>
                                    Belum ada log aktivitas yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($auditLogs->hasPages())
                <div class="mt-4 pt-3 border-top">
                    {{ $auditLogs->links('vendor.pagination.bootstrap-5-simple') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
