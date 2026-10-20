@extends('layouts.public')

@section('title', 'Komentar Siswa')
@section('meta_description', 'Komentar dan pengalaman belajar siswa tentang koleksi e-book SMAN 1 Cikampek.')

@section('content')
<section class="container py-4 py-md-5">
    <!-- Hero Banner Komentar Siswa -->
    <div class="comments-hero-banner mb-4 mb-md-5">
        <div class="row align-items-center g-4 position-relative" style="z-index: 1;">
            <div class="col-lg-8">
                <span class="badge px-3 py-2 rounded-pill mb-3" style="background: rgba(255, 255, 255, 0.2); color: #fff; font-weight: 700; font-size: 0.8rem; letter-spacing: 0.05em; text-transform: uppercase; backdrop-filter: blur(4px);">
                    <i class="bi bi-chat-heart-fill me-1 text-warning"></i> Ruang Diskusi Siswa
                </span>
                <h1 class="display-6 fw-bold mb-2 text-white">Komentar & Pengalaman Belajar</h1>
                <p class="lead fs-6 opacity-90 mb-0 text-white-50">
                    Kumpulan tanggapan, ulasan materi, dan pengalaman membaca dari rekan-rekan siswa seputar koleksi buku pelajaran digital SMAN 1 Cikampek.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-inline-flex flex-wrap gap-2 justify-content-lg-end">
                    <div class="favorites-hero-stat">
                        <i class="bi bi-chat-quote-fill fs-3 text-warning"></i>
                        <div class="text-start text-white">
                            <div class="stat-num">{{ $comments->total() }}</div>
                            <div class="small opacity-75">Komentar Siswa</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar Info -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <span class="badge px-3 py-2 rounded-pill mb-1" style="background: rgba(15, 107, 79, 0.12); color: var(--school-green); font-weight: 700; font-size: 0.78rem; letter-spacing: 0.05em; text-transform: uppercase;">
                <i class="bi bi-chat-dots-fill me-1"></i> Diskusi Terkini
            </span>
            <h2 class="h4 fw-bold mb-0">Ulasan & Tanggapan Pembaca</h2>
        </div>
        <a href="{{ route('library') }}" class="btn btn-outline-success rounded-pill px-4">
            <i class="bi bi-compass me-1"></i> Jelajahi E-Book Lainnya
        </a>
    </div>

    <!-- Daftar Komentar Siswa -->
    <div class="row g-4">
        @forelse($comments as $comment)
            @php
                $avatarGradients = [
                    'linear-gradient(135deg, #0f6b4f, #10b981)',
                    'linear-gradient(135deg, #2563eb, #38bdf8)',
                    'linear-gradient(135deg, #7c3aed, #c084fc)',
                    'linear-gradient(135deg, #d97706, #fbbf24)',
                    'linear-gradient(135deg, #dc2626, #f87171)',
                    'linear-gradient(135deg, #0d9488, #2dd4bf)',
                    'linear-gradient(135deg, #ea580c, #fb923c)',
                ];
                $avatarBg = $avatarGradients[abs(crc32($comment->display_name)) % count($avatarGradients)];
                $initial = mb_strtoupper(mb_substr($comment->display_name, 0, 1));
            @endphp
            <div class="col-12">
                <article class="comment-card-modern">
                    <!-- Header Komentar -->
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="comment-avatar" style="background: {{ $avatarBg }};">
                                {{ $initial }}
                            </div>
                            <div>
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <strong class="fs-6 text-dark">{{ $comment->display_name }}</strong>
                                    <span class="badge text-bg-light border text-muted small">
                                        <i class="bi bi-mortarboard me-1 text-success"></i> Siswa
                                    </span>
                                    @if($comment->rating)
                                        <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis border border-warning-subtle small fw-bold" aria-label="Rating {{ $comment->rating }} dari 5" title="Rating {{ $comment->rating }} dari 5">
                                            <i class="bi bi-star-fill text-warning me-1"></i> {{ $comment->rating }}/5
                                        </span>
                                    @endif
                                </div>
                                <div class="small text-muted mt-1">
                                    <i class="bi bi-clock me-1"></i> {{ $comment->created_at->diffForHumans() }} · <time datetime="{{ $comment->created_at->toDateString() }}">{{ $comment->created_at->translatedFormat('d M Y') }}</time>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Banner E-Book Terkait -->
                    <div class="comment-book-banner p-2 px-3 mb-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <span class="badge badge-soft small">Kelas {{ $comment->ebook->subject->class->name ?? '-' }}</span>
                            <span class="badge text-bg-light border small text-muted">{{ $comment->ebook->subject->name ?? 'Mapel' }}</span>
                            <a href="{{ route('ebooks.show', $comment->ebook) }}" class="fw-bold text-decoration-none text-dark small" title="{{ $comment->ebook->title }}">
                                <i class="bi bi-book-half text-success me-1"></i> {{ \Illuminate\Support\Str::limit($comment->ebook->title, 55) }}
                            </a>
                        </div>
                        <a href="{{ route('ebooks.show', $comment->ebook) }}" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 small fw-semibold">
                            <span>Buka Buku</span> <i class="bi bi-arrow-right small ms-1"></i>
                        </a>
                    </div>

                    <!-- Isi Komentar -->
                    <div class="comment-bubble mb-3">
                        <i class="bi bi-quote text-success fs-5 me-1 opacity-50"></i>
                        <span>{{ $comment->message }}</span>
                    </div>

                    <!-- Footer & Aksi Laporan -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <a href="{{ route('ebooks.show', $comment->ebook) }}" class="small text-decoration-none text-success fw-semibold">
                            <i class="bi bi-chat-left-text me-1"></i> Lihat diskusi lengkap buku ini →
                        </a>
                        <details class="comment-report-accordion">
                            <summary class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 small">
                                <i class="bi bi-flag me-1 text-danger"></i> Laporkan
                            </summary>
                            <div class="comment-report-card mt-2">
                                <p class="small text-danger fw-semibold mb-2">
                                    <i class="bi bi-shield-exclamation me-1"></i> Laporkan komentar tidak pantas atau tidak relevan:
                                </p>
                                <form method="POST" action="{{ route('comments.reports.store', $comment) }}" class="d-flex flex-wrap align-items-center gap-2">
                                    @csrf
                                    <div class="visually-hidden" aria-hidden="true"><label>Website <input tabindex="-1" autocomplete="off" name="website"></label></div>
                                    <select class="form-select form-select-sm rounded-pill" name="reason" style="max-width: 200px" required>
                                        <option value="spam">Spam / Iklan</option>
                                        <option value="abusive">Tidak Pantas / Kasar</option>
                                        <option value="irrelevant">Tidak Relevan</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                    <button class="btn btn-sm btn-danger rounded-pill px-3 fw-semibold" type="submit">Kirim Laporan</button>
                                </form>
                            </div>
                        </details>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="card p-5 text-center rounded-4 border shadow-sm">
                    <div class="saved-empty-icon mb-3 mx-auto" style="width: 70px; height: 70px; border-radius: 50%; background: rgba(15,107,79,0.1); color: var(--school-green); display: grid; place-items: center; font-size: 2rem;">
                        <i class="bi bi-chat-square-dots"></i>
                    </div>
                    <h2 class="h5 fw-bold mb-1">Belum Ada Komentar</h2>
                    <p class="text-muted mb-4 mx-auto" style="max-width: 440px;">
                        Komentar dan ulasan siswa akan tampil di sini setelah dikirimkan dari halaman buku e-book. Jadilah siswa pertama yang membagikan pengalaman belajarmu!
                    </p>
                    <div>
                        <a href="{{ route('library') }}" class="btn btn-success rounded-pill px-4 fw-semibold shadow-sm">
                            <i class="bi bi-compass me-1"></i> Jelajahi Buku & Beri Komentar
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Navigasi Halaman -->
    <div class="mt-5 d-flex justify-content-center">
        {{ $comments->links() }}
    </div>
</section>
@endsection
