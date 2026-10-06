@extends('layouts.public')

@section('title', $ebook->title)
@section('meta_description', $ebook->description ?: 'Baca ' . $ebook->title . ' di Perpustakaan Digital SMAN 1 Cikampek.')

@section('content')
<section class="container py-4 py-md-5" data-ebook-record data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}">
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
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Mulai dibaca</div><div class="fw-semibold">{{ $ebook->reads_count }} kali</div></div></div>
                @php
                    $avgRating = $ebook->comments()->whereNotNull('rating')->avg('rating');
                @endphp
                @if($avgRating)
                <div class="col-sm-6"><div class="metric"><div class="small text-muted">Rating Pembaca</div><div class="fw-semibold">{{ number_format($avgRating, 1) }} / 5 ⭐</div></div></div>
                @endif
            </div>

            @if($ebook->file_path)
                <div class="detail-actions d-flex flex-column flex-sm-row gap-2">
                    <a href="{{ route('ebooks.reader', $ebook) }}" class="btn btn-success flex-fill">Baca Sekarang</a>
                    <a href="{{ route('ebooks.download', $ebook) }}" class="btn btn-outline-success flex-fill">Download</a>
                </div>
                <div class="d-flex flex-column flex-sm-row gap-2 mt-2">
                    <button type="button" class="btn btn-outline-success flex-fill" data-favorite-button data-ebook-id="{{ $ebook->id }}" data-ebook-title="{{ $ebook->title }}" data-ebook-subject="{{ $ebook->subject->name }}" data-ebook-class="{{ $ebook->subject->class->name }}" data-ebook-url="{{ route('ebooks.show', $ebook) }}" data-ebook-reader-url="{{ route('ebooks.reader', $ebook) }}">♡ Simpan ke favorit</button>
                    <button type="button" class="btn btn-outline-primary flex-fill" id="btn-offline" data-pdf-url="{{ asset('storage/' . $ebook->file_path) }}">⬇️ Simpan Offline</button>
                </div>
            @else
                <div class="alert alert-warning mb-0">File PDF belum tersedia.</div>
            @endif
        </div>
    </div>

    <div class="row g-4 mt-2">
        <section class="col-lg-7" aria-labelledby="comments-heading">
            <div class="card h-100"><div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                    <div><p class="eyebrow mb-1">Ruang diskusi siswa</p><h2 id="comments-heading" class="h4 mb-0">Komentar tentang e-book</h2></div>
                    <span class="badge badge-soft">{{ $ebook->approved_comments_count }} komentar</span>
                </div>
                @forelse($comments as $comment)
                    <article class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between gap-3">
                            <strong>{{ $comment->display_name }} 
                                @if($comment->rating)
                                    <span class="text-warning">{{ str_repeat('★', $comment->rating) }}{{ str_repeat('☆', 5 - $comment->rating) }}</span>
                                @endif
                            </strong>
                            <time class="small text-muted" datetime="{{ $comment->created_at->toDateString() }}">{{ $comment->created_at->translatedFormat('d M Y') }}</time>
                        </div>
                        <p class="mb-0 mt-1">{{ $comment->message }}</p>
                        <details class="mt-2"><summary class="small text-muted" role="button">Laporkan komentar</summary><form method="POST" action="{{ route('comments.reports.store', $comment) }}" class="d-flex flex-wrap gap-2 mt-2">@csrf<div class="visually-hidden" aria-hidden="true"><label>Website <input tabindex="-1" autocomplete="off" name="website"></label></div><select class="form-select form-select-sm" name="reason" style="max-width: 190px"><option value="spam">Spam</option><option value="abusive">Tidak pantas</option><option value="irrelevant">Tidak relevan</option><option value="other">Lainnya</option></select><button class="btn btn-sm btn-outline-danger" type="submit">Kirim laporan</button></form></details>
                    </article>
                @empty
                    <p class="text-muted mb-0">Belum ada komentar. Jadilah siswa pertama yang berbagi pengalaman belajar.</p>
                @endforelse
                <div class="mt-3">{{ $comments->links() }}</div>
                <hr class="my-4">
                <h3 class="h5">Bagikan pengalamanmu</h3>
                <p class="small text-muted">Contoh: “Wah, dengan adanya e-book ini saya jadi lebih mudah belajar.” Komentar langsung tampil dan dapat dibaca siswa lain.</p>
                <form method="POST" action="{{ route('ebooks.comments.store', $ebook) }}">
                    @csrf
                    <div class="visually-hidden" aria-hidden="true"><label>Website <input tabindex="-1" autocomplete="off" name="website"></label></div>
                    <div class="mb-3"><label class="form-label" for="display_name">Nama panggilan</label><input class="form-control @error('display_name', 'comment') is-invalid @enderror" id="display_name" name="display_name" value="{{ old('display_name') }}" maxlength="80" required>@error('display_name', 'comment')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3">
                        <label class="form-label" for="rating">Rating (opsional)</label>
                        <select class="form-select @error('rating', 'comment') is-invalid @enderror" id="rating" name="rating">
                            <option value="">-- Pilih Rating --</option>
                            <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Bagus</option>
                            <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ Bagus</option>
                            <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                            <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>⭐⭐ Kurang</option>
                            <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>⭐ Sangat Kurang</option>
                        </select>
                        @error('rating', 'comment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3"><label class="form-label" for="comment_message">Komentar</label><textarea class="form-control @error('message', 'comment') is-invalid @enderror" id="comment_message" name="message" rows="4" maxlength="1000" required>{{ old('message') }}</textarea>@error('message', 'comment')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <button class="btn btn-success" type="submit">Kirim komentar</button>
                </form>
            </div></div>
        </section>
        <aside class="col-lg-5">
            <div class="card h-100"><div class="card-body p-4">
                <p class="eyebrow mb-1">Bantu perbaiki koleksi</p><h2 class="h4">Laporkan masalah e-book</h2>
                <p class="small text-muted">Laporkan bila PDF tidak bisa dibuka, isi atau metadata salah, atau cover kurang sesuai.</p>
                <form method="POST" action="{{ route('ebooks.reports.store', $ebook) }}">
                    @csrf
                    <div class="visually-hidden" aria-hidden="true"><label>Website <input tabindex="-1" autocomplete="off" name="website"></label></div>
                    <div class="mb-3"><label class="form-label" for="reporter_name">Nama panggilan <span class="text-muted">(opsional)</span></label><input class="form-control @error('reporter_name', 'report') is-invalid @enderror" id="reporter_name" name="reporter_name" value="{{ old('reporter_name') }}" maxlength="80">@error('reporter_name', 'report')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label class="form-label" for="category">Jenis masalah</label><select class="form-select @error('category', 'report') is-invalid @enderror" id="category" name="category" required><option value="pdf_broken">PDF tidak bisa dibuka</option><option value="wrong_content">Isi buku tidak sesuai</option><option value="metadata">Judul, penulis, atau tahun salah</option><option value="cover">Cover tidak sesuai</option><option value="other">Lainnya</option></select>@error('category', 'report')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label class="form-label" for="report_message">Penjelasan</label><textarea class="form-control @error('message', 'report') is-invalid @enderror" id="report_message" name="message" rows="4" minlength="10" maxlength="1500" required>{{ old('message') }}</textarea>@error('message', 'report')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <button class="btn btn-outline-success" type="submit">Kirim laporan</button>
                </form>
            </div></div>
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

@push('scripts')
<script>
    const btnOffline = document.getElementById('btn-offline');
    if (btnOffline) {
        const pdfUrl = btnOffline.dataset.pdfUrl;
        
        // Check if already cached
        if ('caches' in window) {
            caches.open('perpus-sman1-static-v2').then(cache => {
                cache.match(pdfUrl).then(response => {
                    if (response) {
                        btnOffline.textContent = '✅ Tersedia Offline';
                        btnOffline.classList.replace('btn-outline-primary', 'btn-primary');
                        btnOffline.disabled = true;
                    }
                });
            });
            
            btnOffline.addEventListener('click', async () => {
                btnOffline.textContent = '⏳ Menyimpan...';
                try {
                    const cache = await caches.open('perpus-sman1-static-v2');
                    await cache.add(pdfUrl);
                    btnOffline.textContent = '✅ Tersedia Offline';
                    btnOffline.classList.replace('btn-outline-primary', 'btn-primary');
                    btnOffline.disabled = true;
                } catch (error) {
                    console.error('Failed to cache PDF:', error);
                    btnOffline.textContent = '❌ Gagal Menyimpan';
                    setTimeout(() => btnOffline.textContent = '⬇️ Simpan Offline', 3000);
                }
            });
        } else {
            btnOffline.style.display = 'none';
        }
    }
</script>
@endpush
