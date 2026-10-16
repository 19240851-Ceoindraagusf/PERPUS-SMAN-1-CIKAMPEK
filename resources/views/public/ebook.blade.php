@extends('layouts.public')

@section('title', $ebook->title)
@section('meta_description', $ebook->description ?: 'Baca ' . $ebook->title . ' di Perpustakaan Digital SMAN 1 Cikampek.')

@section('content')
<section class="container py-4 py-md-5" data-ebook-record data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}" data-ebook-cover="{{ $ebook->cover_path ? asset('storage/' . $ebook->cover_path) : '' }}" data-ebook-author="{{ $ebook->author ?: '' }}">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('library') }}">Perpustakaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('classes.show', $ebook->subject->class) }}">Kelas {{ $ebook->subject->class->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subjects.show', [$ebook->subject->class, $ebook->subject]) }}">{{ $ebook->subject->name }}</a></li>
            <li class="breadcrumb-item active">{{ $ebook->title }}</li>
        </ol>
    </nav>

    <div class="row g-4 align-items-start">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 p-md-4 text-center">
                    @if($ebook->cover_path)
                        <img src="{{ asset('storage/' . $ebook->cover_path) }}" class="detail-cover rounded" loading="lazy" decoding="async" alt="Cover {{ $ebook->title }}">
                    @else
                        @include('public._book-cover', ['ebook' => $ebook])
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <p class="eyebrow mb-2">Kelas {{ $ebook->subject->class->name }} / {{ $ebook->subject->name }}</p>
            <span class="badge badge-soft mb-3">E-book tersedia untuk dibaca</span>
            <h1 class="h2 mb-3">{{ $ebook->title }}</h1>
            <p class="text-muted mb-4">{{ $ebook->description ?: 'Belum ada deskripsi e-book.' }}</p>

            <div class="row g-3 mb-4">
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Mata Pelajaran</div><div class="fw-semibold">{{ $ebook->subject->name }}</div></div></div>
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Penulis</div><div class="fw-semibold">{{ $ebook->author ?: '-' }}</div></div></div>
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Penerbit</div><div class="fw-semibold">{{ $ebook->publisher ?: '-' }}</div></div></div>
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Tahun</div><div class="fw-semibold">{{ $ebook->publication_year ?: '-' }}</div></div></div>
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Telah dibaca</div><div class="fw-semibold">{{ $ebook->reads_count }} kali</div></div></div>
                @php
                    $avgRating = $ebook->comments()->whereNotNull('rating')->avg('rating');
                @endphp
                @if($avgRating)
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Rating Pembaca</div><div class="fw-semibold">{{ number_format($avgRating, 1) }} / 5.0 ⭐</div></div></div>
                @endif
            </div>

            @if($ebook->file_path)
                <div class="detail-actions d-flex flex-column flex-sm-row gap-2">
                    <a href="{{ route('ebooks.reader', $ebook) }}" class="btn btn-success flex-fill">Baca Sekarang</a>
                    <a href="{{ route('ebooks.download', $ebook) }}" class="btn btn-outline-success flex-fill">Download</a>
                </div>
                <button type="button" class="btn btn-outline-danger mt-2 w-100" data-favorite-button data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}" data-ebook-cover="{{ $ebook->cover_path ? asset('storage/' . $ebook->cover_path) : '' }}" data-ebook-author="{{ $ebook->author ?: '' }}">♡ Simpan ke Favorit</button>
            @else
                <div class="alert alert-warning mb-0">File PDF belum tersedia.</div>
            @endif
        </div>
    </div>

    <div class="row g-4 mt-2">
        <section class="col-lg-7" aria-labelledby="comments-heading">
            <div class="card h-100 border rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <!-- Header Ulasan -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4 pb-3 border-bottom">
                        <div>
                            <span class="badge px-3 py-1 rounded-pill mb-1" style="background: rgba(15, 107, 79, 0.12); color: var(--school-green); font-weight: 700; font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                <i class="bi bi-chat-quote-fill me-1"></i> Ruang Diskusi Siswa
                            </span>
                            <h2 id="comments-heading" class="h4 fw-bold mb-0">Ulasan & Komentar</h2>
                        </div>
                        <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2 fw-bold">
                            <i class="bi bi-chat-dots-fill me-1"></i> {{ $ebook->approved_comments_count }} Komentar
                        </span>
                    </div>

                    <!-- Daftar Komentar -->
                    @forelse($comments as $comment)
                        @php
                            $avatarGradients = [
                                'linear-gradient(135deg, #0f6b4f, #10b981)',
                                'linear-gradient(135deg, #2563eb, #38bdf8)',
                                'linear-gradient(135deg, #7c3aed, #c084fc)',
                                'linear-gradient(135deg, #d97706, #fbbf24)',
                                'linear-gradient(135deg, #dc2626, #f87171)',
                                'linear-gradient(135deg, #0d9488, #2dd4bf)',
                            ];
                            $avatarBg = $avatarGradients[abs(crc32($comment->display_name)) % count($avatarGradients)];
                            $initial = mb_strtoupper(mb_substr($comment->display_name, 0, 1));
                        @endphp
                        <article class="p-3 mb-3 rounded-4 border bg-light-subtle">
                            <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="comment-avatar" style="width: 36px; height: 36px; font-size: 0.95rem; background: {{ $avatarBg }};">
                                        {{ $initial }}
                                    </div>
                                    <div>
                                        <strong class="text-dark small d-block">{{ $comment->display_name }}</strong>
                                        <time class="small text-muted" style="font-size: 0.75rem;" datetime="{{ $comment->created_at->toDateString() }}">
                                            <i class="bi bi-clock me-1"></i> {{ $comment->created_at->diffForHumans() }}
                                        </time>
                                    </div>
                                </div>
                                @if($comment->rating)
                                    <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis border border-warning-subtle small fw-bold">
                                        <i class="bi bi-star-fill text-warning me-1"></i> {{ $comment->rating }}/5
                                    </span>
                                @endif
                            </div>
                            <div class="comment-bubble mb-2 py-2 px-3 small">
                                {{ $comment->message }}
                            </div>
                            <div class="d-flex justify-content-end">
                                <details class="comment-report-accordion">
                                    <summary class="small text-muted py-0 px-2" role="button">
                                        <i class="bi bi-flag me-1 text-danger"></i> Laporkan
                                    </summary>
                                    <div class="comment-report-card mt-2">
                                        <form method="POST" action="{{ route('comments.reports.store', $comment) }}" class="d-flex flex-wrap gap-2">
                                            @csrf
                                            <div class="visually-hidden" aria-hidden="true"><label>Website <input tabindex="-1" autocomplete="off" name="website"></label></div>
                                            <select class="form-select form-select-sm rounded-pill" name="reason" style="max-width: 170px" required>
                                                <option value="spam">Spam</option>
                                                <option value="abusive">Tidak pantas</option>
                                                <option value="irrelevant">Tidak relevan</option>
                                                <option value="other">Lainnya</option>
                                            </select>
                                            <button class="btn btn-sm btn-danger rounded-pill px-3" type="submit">Kirim</button>
                                        </form>
                                    </div>
                                </details>
                            </div>
                        </article>
                    @empty
                        <div class="p-4 text-center rounded-3 border bg-light-subtle mb-4">
                            <i class="bi bi-chat-heart fs-3 text-muted mb-2 d-block"></i>
                            <p class="text-muted small mb-0">Belum ada komentar. Jadilah siswa pertama yang berbagi pengalaman belajar setelah membaca e-book ini!</p>
                        </div>
                    @endforelse

                    <div class="mt-3">{{ $comments->links() }}</div>

                    <!-- Form Tulis Komentar -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="icon-box text-success flex-shrink-0" style="width: 36px; height: 36px; border-radius: 10px; font-size: 1.1rem; background: rgba(15,107,79,0.1);">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div>
                                <h3 class="h6 fw-bold mb-0">Bagikan Pengalaman Belajarmu</h3>
                                <small class="text-muted">Komentar akan langsung tampil untuk membantu rekan siswa lainnya.</small>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('ebooks.comments.store', $ebook) }}" class="mt-3">
                            @csrf
                            <div class="visually-hidden" aria-hidden="true"><label>Website <input tabindex="-1" autocomplete="off" name="website"></label></div>
                            <div class="row g-2 mb-3">
                                <div class="col-sm-7">
                                    <label class="form-label small fw-semibold text-muted" for="display_name">Nama Panggilan</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                                        <input class="form-control @error('display_name', 'comment') is-invalid @enderror" id="display_name" name="display_name" value="{{ old('display_name') }}" maxlength="80" placeholder="Contoh: Rian / Salsabila" required>
                                    </div>
                                    @error('display_name', 'comment')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-sm-5">
                                    <label class="form-label small fw-semibold text-muted" for="rating">Rating (Opsional)</label>
                                    <select class="form-select form-select-sm @error('rating', 'comment') is-invalid @enderror" id="rating" name="rating">
                                        <option value="">-- Pilih Bintang --</option>
                                        <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 (Sangat Bagus)</option>
                                        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ 4 (Bagus)</option>
                                        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ 3 (Cukup)</option>
                                        <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>⭐⭐ 2 (Kurang)</option>
                                        <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>⭐ 1 (Sangat Kurang)</option>
                                    </select>
                                    @error('rating', 'comment')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted" for="comment_message">Tanggapan / Ulasan</label>
                                <textarea class="form-control @error('message', 'comment') is-invalid @enderror" id="comment_message" name="message" rows="3" maxlength="1000" placeholder="Contoh: Penjelasannya sangat jelas dan mudah dipahami untuk materi bab ini..." required>{{ old('message') }}</textarea>
                                @error('message', 'comment')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <button class="btn btn-success rounded-pill px-4 fw-semibold shadow-sm" type="submit">
                                <i class="bi bi-send-fill me-1"></i> Kirim Komentar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Aside: Laporkan Masalah -->
        <aside class="col-lg-5">
            <div class="card h-100 border rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="icon-box text-warning flex-shrink-0" style="width: 44px; height: 44px; border-radius: 12px; font-size: 1.25rem; background: rgba(217, 119, 6, 0.1);">
                            <i class="bi bi-tools"></i>
                        </div>
                        <div>
                            <span class="badge px-2 py-1 rounded-pill mb-1" style="background: rgba(217, 119, 6, 0.12); color: #d97706; font-weight: 700; font-size: 0.72rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                Layanan Perpustakaan
                            </span>
                            <h2 class="h5 fw-bold mb-0">Laporkan Kendala E-Book</h2>
                        </div>
                    </div>
                    <p class="small text-muted mb-3">
                        Laporkan bila file PDF bermasalah, terdapat halaman kosong, isi buku keliru, atau cover tidak sesuai agar tim perpustakaan segera memperbaiki.
                    </p>
                    <form method="POST" action="{{ route('ebooks.reports.store', $ebook) }}">
                        @csrf
                        <div class="visually-hidden" aria-hidden="true"><label>Website <input tabindex="-1" autocomplete="off" name="website"></label></div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted" for="reporter_name">Nama Pelapor <span class="text-muted fw-normal">(Opsional)</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                                <input class="form-control @error('reporter_name', 'report') is-invalid @enderror" id="reporter_name" name="reporter_name" value="{{ old('reporter_name') }}" maxlength="80" placeholder="Nama Anda">
                            </div>
                            @error('reporter_name', 'report')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted" for="category">Jenis Kendala</label>
                            <select class="form-select form-select-sm @error('category', 'report') is-invalid @enderror" id="category" name="category" required>
                                <option value="pdf_broken">PDF Rusak / Tidak Bisa Dibuka</option>
                                <option value="wrong_content">Isi Buku Tidak Sesuai</option>
                                <option value="metadata">Judul, Penulis, atau Tahun Salah</option>
                                <option value="cover">Cover Buku Tidak Sesuai</option>
                                <option value="other">Kendala Lainnya</option>
                            </select>
                            @error('category', 'report')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted" for="report_message">Penjelasan Detail</label>
                            <textarea class="form-control @error('message', 'report') is-invalid @enderror" id="report_message" name="message" rows="3" minlength="10" maxlength="1500" placeholder="Jelaskan kendala yang dialami secara singkat..." required>{{ old('message') }}</textarea>
                            @error('message', 'report')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <button class="btn btn-outline-warning text-dark fw-semibold rounded-pill px-4 w-100" type="submit">
                            <i class="bi bi-send me-1"></i> Kirim Laporan Kendala
                        </button>
                    </form>
                </div>
            </div>
        </aside>
    </div>

    @if($relatedEbooks->isNotEmpty())
        <section class="mt-5 pt-4 catalog-toolbar">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
                <div><p class="eyebrow mb-1">Lanjutkan belajar</p><h2 class="h4 mb-0">E-Book terkait</h2></div>
                <a class="small fw-semibold text-decoration-none" href="{{ route('subjects.show', [$ebook->subject->class, $ebook->subject]) }}">Lihat semua mapel →</a>
            </div>
            <div class="row g-3">
                @foreach($relatedEbooks as $related)
                    <div class="col-6 col-md-3">
                        <article class="collection-card info-card card h-100">
                            <a class="text-decoration-none text-dark" href="{{ route('ebooks.show', $related) }}">
                                @include('public._book-cover', ['ebook' => $related])
                                <div class="card-body"><h3 class="h6 book-title mb-0">{{ $related->title }}</h3></div>
                            </a>
                        </article>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</section>
@endsection
