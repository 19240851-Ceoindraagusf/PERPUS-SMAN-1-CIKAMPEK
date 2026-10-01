@php
    $subjectName = $ebook->subject->name ?? 'E-BOOK';
    $theme = abs(crc32(strtolower($subjectName))) % 5;
@endphp
@if($ebook->cover_path)
    <img src="{{ asset('storage/' . $ebook->cover_path) }}" class="book-cover" loading="lazy" decoding="async" alt="Cover {{ $ebook->title }}">
@else
    <div class="book-cover-placeholder book-cover-theme-{{ $theme }}">
        <small>PERPUSTAKAAN DIGITAL</small>
        <strong>{{ $subjectName }}</strong>
        <small>{{ $ebook->publication_year ?: 'SMAN 1 CIKAMPEK' }}</small>
    </div>
@endif
