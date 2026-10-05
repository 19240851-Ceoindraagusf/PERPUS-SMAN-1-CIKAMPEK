@extends('layouts.admin')

@section('title', 'Moderasi Komentar')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div><h1 class="h3 mb-1">Moderasi Komentar</h1><p class="text-muted mb-0">Komentar tampil langsung; sembunyikan yang tidak sopan atau tidak relevan dengan pembelajaran.</p></div>
    <div class="btn-group" role="group" aria-label="Filter komentar">
        @foreach(['pending' => 'Menunggu', 'approved' => 'Disetujui', 'all' => 'Semua'] as $value => $label)
            <a class="btn btn-sm {{ $approval === $value ? 'btn-success' : 'btn-outline-success' }}" href="{{ route('admin.ebook-comments.index', ['approval' => $value]) }}">{{ $label }}</a>
        @endforeach
    </div>
</div>
<div class="admin-card card"><div class="card-body p-0">
    <div class="table-responsive"><table class="table align-middle mb-0">
        <thead><tr><th>Siswa</th><th>E-Book</th><th>Komentar</th><th>Waktu</th><th>Tindakan</th></tr></thead>
        <tbody>
        @forelse($comments as $comment)
            <tr>
                <td><strong>{{ $comment->display_name }}</strong><div><span class="badge {{ $comment->is_approved ? 'text-bg-success' : 'text-bg-warning' }}">{{ $comment->is_approved ? 'Disetujui' : 'Menunggu' }}</span></div></td>
                <td>{{ $comment->ebook->title ?? 'E-book telah dihapus' }}</td>
                <td class="text-break">{{ $comment->message }}</td>
                <td class="small text-muted">{{ $comment->created_at->translatedFormat('d M Y H:i') }}</td>
                <td><div class="d-flex gap-2"><form method="POST" action="{{ route('admin.ebook-comments.update', $comment) }}">@csrf @method('PATCH')<input type="hidden" name="is_approved" value="{{ $comment->is_approved ? '0' : '1' }}"><button class="btn btn-sm {{ $comment->is_approved ? 'btn-outline-secondary' : 'btn-success' }}">{{ $comment->is_approved ? 'Sembunyikan' : 'Setujui' }}</button></form><form method="POST" action="{{ route('admin.ebook-comments.destroy', $comment) }}" onsubmit="return confirm('Hapus komentar ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button></form></div></td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada komentar pada kategori ini.</td></tr>
        @endforelse
        </tbody>
    </table></div>
    <div class="p-3">{{ $comments->links() }}</div>
</div></div>
@endsection
