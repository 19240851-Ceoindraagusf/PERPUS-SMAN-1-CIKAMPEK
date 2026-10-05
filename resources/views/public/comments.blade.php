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
                <a class="small text-decoration-none" href="{{ route('ebooks.show', $comment->ebook) }}">Lihat e-book dan komentar lainnya →</a>
            </div></div></article>
        @empty
            <div class="col-12"><div class="empty-state"><h2 class="h5">Belum ada komentar</h2><p class="text-muted mb-0">Komentar siswa akan muncul di sini setelah dikirim dari halaman detail e-book.</p></div></div>
        @endforelse
    </div>
    <div class="mt-4">{{ $comments->links() }}</div>
</section>
@endsection
