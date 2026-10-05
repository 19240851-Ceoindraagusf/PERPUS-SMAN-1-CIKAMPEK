@extends('layouts.admin')

@section('title', 'Laporan E-Book')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div><h1 class="h3 mb-1">Laporan E-Book</h1><p class="text-muted mb-0">Tindak lanjuti masalah yang dilaporkan siswa.</p></div>
    <div class="btn-group" role="group" aria-label="Filter status laporan">
        @foreach(['open' => 'Baru', 'in_progress' => 'Diproses', 'resolved' => 'Selesai', 'all' => 'Semua'] as $value => $label)
            <a class="btn btn-sm {{ $status === $value ? 'btn-success' : 'btn-outline-success' }}" href="{{ route('admin.ebook-reports.index', ['status' => $value]) }}">{{ $label }}</a>
        @endforeach
    </div>
</div>
<div class="admin-card card"><div class="card-body p-0">
    <div class="table-responsive"><table class="table align-middle mb-0">
        <thead><tr><th>E-Book</th><th>Pelapor / masalah</th><th>Penjelasan</th><th>Waktu</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($reports as $report)
            <tr>
                <td><strong>{{ $report->ebook->title ?? 'E-book telah dihapus' }}</strong><div class="small text-muted">{{ $report->ebook?->subject?->name }}</div></td>
                <td><div>{{ $report->reporter_name ?: 'Anonim' }}</div><span class="badge text-bg-light">{{ ['pdf_broken' => 'PDF bermasalah', 'wrong_content' => 'Isi tidak sesuai', 'metadata' => 'Metadata salah', 'cover' => 'Cover salah', 'other' => 'Lainnya'][$report->category] ?? $report->category }}</span></td>
                <td class="text-break">{{ $report->message }}</td>
                <td class="small text-muted">{{ $report->created_at->translatedFormat('d M Y H:i') }}</td>
                <td><form method="POST" action="{{ route('admin.ebook-reports.update', $report) }}" class="d-flex gap-2">@csrf @method('PATCH')<select class="form-select form-select-sm" name="status"><option value="open" @selected($report->status === 'open')>Baru</option><option value="in_progress" @selected($report->status === 'in_progress')>Diproses</option><option value="resolved" @selected($report->status === 'resolved')>Selesai</option></select><button class="btn btn-sm btn-success">Simpan</button></form></td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada laporan pada kategori ini.</td></tr>
        @endforelse
        </tbody>
    </table></div>
    <div class="p-3">{{ $reports->links() }}</div>
</div></div>
@endsection
