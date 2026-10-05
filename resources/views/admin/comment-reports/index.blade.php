@extends('layouts.admin')

@section('title', 'Laporan Komentar')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div><h1 class="h3 mb-1">Laporan Komentar</h1><p class="text-muted mb-0">Tinjau komentar yang dilaporkan siswa dan sembunyikan bila diperlukan.</p></div>
    <div class="btn-group" role="group" aria-label="Filter laporan komentar">
        @foreach(['open' => 'Baru', 'resolved' => 'Selesai', 'all' => 'Semua'] as $value => $label)
            <a class="btn btn-sm {{ $status === $value ? 'btn-success' : 'btn-outline-success' }}" href="{{ route('admin.comment-reports.index', ['status' => $value]) }}">{{ $label }}</a>
        @endforeach
    </div>
</div>
<div class="admin-card card"><div class="card-body p-0"><div class="table-responsive"><table class="table align-middle mb-0">
    <thead><tr><th>Komentar</th><th>E-Book</th><th>Alasan</th><th>Waktu</th><th>Tindakan</th></tr></thead>
    <tbody>
    @forelse($reports as $report)
        <tr>
            <td><strong>{{ $report->comment->display_name ?? 'Komentar telah dihapus' }}</strong><div class="text-break small">{{ $report->comment->message ?? '-' }}</div></td>
            <td>{{ $report->comment?->ebook?->title ?? '-' }}</td>
            <td>{{ ['spam' => 'Spam', 'abusive' => 'Tidak pantas', 'irrelevant' => 'Tidak relevan', 'other' => 'Lainnya'][$report->reason] ?? $report->reason }}</td>
            <td class="small text-muted">{{ $report->created_at->translatedFormat('d M Y H:i') }}</td>
            <td><div class="d-flex gap-2"><form method="POST" action="{{ route('admin.comment-reports.update', $report) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="{{ $report->status === 'open' ? 'resolved' : 'open' }}"><button class="btn btn-sm btn-success">{{ $report->status === 'open' ? 'Selesai' : 'Buka lagi' }}</button></form>@if($report->comment)<form method="POST" action="{{ route('admin.ebook-comments.update', $report->comment) }}">@csrf @method('PATCH')<input type="hidden" name="is_approved" value="0"><button class="btn btn-sm btn-outline-danger">Sembunyikan</button></form>@endif</div></td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada laporan komentar.</td></tr>
    @endforelse
    </tbody>
</table></div><div class="p-3">{{ $reports->links() }}</div></div></div>
@endsection
