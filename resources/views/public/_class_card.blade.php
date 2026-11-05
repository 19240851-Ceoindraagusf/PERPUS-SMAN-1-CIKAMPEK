@php
    $name = trim($class->name);
    // Replace lowercase 'l' that looks like Roman numeral 'I' or 'i' (e.g., 'Xl' -> 'XI')
    $normalizedName = preg_replace('/\bX[lL]\b/i', 'XI', $name);
    $normalizedName = preg_replace('/\bX[lL]\s+/i', 'XI ', $normalizedName);
    $upperName = strtoupper($normalizedName);
    
    // Determine level: X, XI, XII
    if (str_starts_with($upperName, 'XII') || str_contains($upperName, '12')) {
        $level = 'XII';
        $levelLabel = 'Tingkat XII • Kelas 12';
        $romanShort = 'XII';
        $themeClass = 'class-theme-crimson';
        $streamBadge = 'Tingkat Akhir';
        $classIcon = 'bi-mortarboard';
        $streamDesc = 'Materi komprehensif tingkat akhir persiapan kelulusan dan seleksi PTN.';
    } elseif (str_starts_with($upperName, 'XI') || str_contains($upperName, '11')) {
        $level = 'XI';
        $levelLabel = 'Tingkat XI • Kelas 11';
        $romanShort = 'XI';
        $themeClass = 'class-theme-blue';
        $streamBadge = 'Fase F • Lanjutan';
        $classIcon = 'bi-journal-bookmark';
        $streamDesc = 'Pendalaman materi kurikulum merdeka dan penguatan kompetensi esensial.';
    } else {
        $level = 'X';
        $levelLabel = 'Tingkat X • Kelas 10';
        $romanShort = 'X';
        $themeClass = 'class-theme-emerald';
        $streamBadge = 'Fase E • Fondasi';
        $classIcon = 'bi-compass';
        $streamDesc = 'Fondasi dasar kurikulum merdeka dan pengenalan materi esensial SMA.';
    }

    // Refine specialization if specific stream keywords are in the name
    if (str_contains($upperName, 'IPA') || str_contains($upperName, 'MIPA')) {
        $streamBadge = ($level === 'XII' ? 'Tingkat Akhir' : 'Fase F') . ' • MIPA';
        $classIcon = 'bi-cpu';
        $themeClass = 'class-theme-blue';
        $streamDesc = 'Peminatan Matematika dan Ilmu Pengetahuan Alam.';
    } elseif (str_contains($upperName, 'IPS') || str_contains($upperName, 'IIS')) {
        $streamBadge = ($level === 'XII' ? 'Tingkat Akhir' : 'Fase F') . ' • IPS';
        $classIcon = 'bi-globe-americas';
        $themeClass = 'class-theme-amber';
        $streamDesc = 'Peminatan Ilmu Pengetahuan Sosial dan Humaniora.';
    } elseif (str_contains($upperName, 'BAHASA') || str_contains($upperName, 'IBB')) {
        $streamBadge = ($level === 'XII' ? 'Tingkat Akhir' : 'Fase F') . ' • Bahasa';
        $classIcon = 'bi-translate';
        $themeClass = 'class-theme-purple';
        $streamDesc = 'Peminatan Bahasa, Sastra, dan Wawasan Budaya.';
    }

    $cardDesc = $class->description ?: $streamDesc;
    $displayHeading = str_starts_with(strtolower($class->name), 'kelas') ? $class->name : 'Kelas ' . $class->name;
@endphp

<div class="col-md-6 col-lg-4 class-card-col" data-class-level="{{ $level }}">
    <a href="{{ route('classes.show', $class) }}" class="class-card-premium {{ $themeClass }} text-decoration-none">
        <!-- Sleek Top Accent Stripe -->
        <div class="class-card-top-accent"></div>
        
        <div class="class-card-inner">
            <!-- Header: Icon & Stream Badge -->
            <div class="class-card-header d-flex justify-content-between align-items-center gap-2 mb-3">
                <div class="class-icon-wrapper" aria-hidden="true">
                    <i class="bi {{ $classIcon }}"></i>
                </div>
                <div class="class-badge-wrapper text-end">
                    <span class="class-stream-pill">{{ $streamBadge }}</span>
                </div>
            </div>

            <!-- Title & Roman Watermark -->
            <div class="class-card-title-section mb-2 position-relative">
                <span class="class-watermark-num" aria-hidden="true">{{ $romanShort }}</span>
                <div class="class-level-micro">{{ $levelLabel }}</div>
                <h3 class="class-card-heading">{{ $displayHeading }}</h3>
            </div>

            <!-- Description -->
            <p class="class-card-description">
                {{ $cardDesc }}
            </p>

            <!-- Stats Row -->
            <div class="class-card-meta-row">
                <div class="class-meta-chip">
                    <i class="bi bi-journal-text text-success me-1"></i>
                    <span><strong>{{ $class->subjects_count }}</strong> Mapel</span>
                </div>
                <div class="class-meta-chip">
                    <i class="bi bi-book-half text-success me-1"></i>
                    <span><strong>{{ $class->ebooks_count }}</strong> E-Book</span>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="class-card-footer-action">
                <span class="action-text">Buka Koleksi Kelas</span>
                <span class="action-icon" aria-hidden="true">
                    <i class="bi bi-arrow-right"></i>
                </span>
            </div>
        </div>
    </a>
</div>
