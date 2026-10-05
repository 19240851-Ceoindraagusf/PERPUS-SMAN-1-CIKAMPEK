@extends('layouts.public')

@section('title', 'Komentar Siswa')
@section('meta_description', 'Komentar dan pengalaman belajar siswa tentang koleksi e-book SMAN 1 Cikampek.')

@section('content')
<section class="container py-5">
    <div class="section-title mb-4">
        <p class="eyebrow mb-1">Ruang diskusi siswa</p>
        <h1 class="h3 mb-1">Komentar Siswa</h1>
        <p class="text-muted mb-0">Pengalaman dan tanggapan siswa terhadap e-book yang tersedia di perpustakaan digital.</p>
    </div>
    <div class="row g-3">
        @forelse($comments as $comment)
            <article class="col-12"><div class="card"><div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-2">
                    <div><strong>{{ $comment->display_name }}</strong><span class="text-muted mx-1">mengomentari</span><a class="fw-semibold text-decoration-none" href="{{ route('ebooks.show', $comment->ebook) }}">{{ $comment->ebook->title }}</a></div>
                    <time class="small text-muted" datetime="{{ $comment->created_at->toDateString() }}">{{ $comment->created_at->translatedFormat('d M Y') }}</time>
                </div>
                <p class="mb-2">{{ $comment->message }}</p>
                <div class="d-flex flex-wrap align-items-center gap-3"><a class="small text-decoration-none" href="{{ route('ebooks.show', $comment->ebook) }}">Lihat e-book dan komentar lainnya →</a><details><summary class="small text-muted" role="button">Laporkan komentar</summary><form method="POST" action="{{ route('comments.reports.store', $comment) }}" class="d-flex flex-wrap gap-2 mt-2">@csrf<div class="visually-hidden" aria-hidden="true"><label>Website <input tabindex="-1" autocomplete="off" name="website"></label></div><select class="form-select form-select-sm" name="reason" style="max-width: 190px"><option value="spam">Spam</option><option value="abusive">Tidak pantas</option><option value="irrelevant">Tidak relevan</option><option value="other">Lainnya</option></select><button class="btn btn-sm btn-outline-danger" type="submit">Kirim laporan</button></form></details></div>
            </div></div></article>
        @empty
            <div class="col-12"><div class="empty-state"><h2 class="h5">Belum ada komentar</h2><p class="text-muted mb-0">Komentar siswa akan muncul di sini setelah dikirim dari halaman detail e-book.</p></div></div>
        @endforelse
    </div>
    <div class="mt-4">{{ $comments->links() }}</div>
</section>
@endsection
