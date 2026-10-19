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
    } elseif (str_starts_with($upperName, 'XI') || str_contains($upperName, '11')) {
        $level = 'XI';
        $levelLabel = 'Tingkat XI • Kelas 11';
        $romanShort = 'XI';
    } else {
        $level = 'X';
        $levelLabel = 'Tingkat X • Kelas 10';
        $romanShort = 'X';
    }

    // Default icon and theme fallback
    $classIcon = 'bi-collection';
    $themeClass = 'class-theme-cyan';

    // Determine stream, icon & color theme
    if ($level === 'X') {
        $themeClass = 'class-theme-emerald';
        $streamBadge = 'Fase E • Umum';
        $classIcon = 'bi-stars';
        $streamDesc = 'Fondasi dasar kurikulum dan pengenalan materi esensial SMA.';
    } elseif ($level === 'XI') {
        if (str_contains($upperName, 'IPA') || str_contains($upperName, 'MIPA')) {
            $themeClass = 'class-theme-blue';
            $streamBadge = 'Fase F • MIPA';
            $classIcon = 'bi-lightning-charge';
            $streamDesc = 'Peminatan Matematika dan Ilmu Pengetahuan Alam.';
        } elseif (str_contains($upperName, 'IPS') || str_contains($upperName, 'IIS')) {
            $themeClass = 'class-theme-amber';
            $streamBadge = 'Fase F • IPS';
            $classIcon = 'bi-globe-americas';
            $streamDesc = 'Peminatan Ilmu Pengetahuan Sosial dan Ekonomi Humaniora.';
        } elseif (str_contains($upperName, 'BAHASA') || str_contains($upperName, 'IBB')) {
            $themeClass = 'class-theme-purple';
            $streamBadge = 'Fase F • Bahasa';
            $classIcon = 'bi-translate';
            $streamDesc = 'Peminatan Bahasa, Sastra Indonesia, Inggris, dan Budaya.';
        } else {
            $themeClass = 'class-theme-cyan';
            $streamBadge = 'Fase F • Reguler';
            $classIcon = 'bi-layers';
            $streamDesc = 'Koleksi materi pelajaran terintegrasi tingkat XI.';
        }
    } else { // XII
        if (str_contains($upperName, 'IPA') || str_contains($upperName, 'MIPA')) {
            $themeClass = 'class-theme-indigo';
            $streamBadge = 'Tingkat Akhir • MIPA';
            $classIcon = 'bi-mortarboard';
            $streamDesc = 'Pendalaman materi sains lanjutan dan persiapan seleksi PTN.';
        } elseif (str_contains($upperName, 'IPS') || str_contains($upperName, 'IIS')) {
            $themeClass = 'class-theme-orange';
            $streamBadge = 'Tingkat Akhir • IPS';
            $classIcon = 'bi-graph-up-arrow';
            $streamDesc = 'Pendalaman materi sosial ekonomi dan persiapan seleksi PTN.';
        } elseif (str_contains($upperName, 'BAHASA') || str_contains($upperName, 'IBB')) {
            $themeClass = 'class-theme-rose';
            $streamBadge = 'Tingkat Akhir • Bahasa';
            $classIcon = 'bi-feather';
            $streamDesc = 'Pendalaman sastra, kebahasaan, dan wawasan global.';
        } else {
            $themeClass = 'class-theme-crimson';
            $streamBadge = 'Tingkat Akhir • Reguler';
            $classIcon = 'bi-mortarboard-fill';
            $streamDesc = 'Materi komprehensif tingkat akhir menuju kelulusan.';
        }
    }

    $cardDesc = $class->description ?: $streamDesc;
@endphp

<div class="col-md-6 col-lg-4 class-card-col" data-class-level="{{ $level }}">
    <a href="{{ route('classes.show', $class) }}" class="class-card-premium {{ $themeClass }} text-decoration-none">
        <!-- Top color accent stripe -->
        <div class="class-card-top-accent"></div>
        
        <div class="class-card-inner">
            <!-- Header: Icon & Stream Badge -->
            <div class="class-card-header d-flex justify-content-between align-items-start gap-2 mb-3">
                <div class="class-icon-wrapper">
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
                <h3 class="class-card-heading">Kelas {{ $class->name }}</h3>
            </div>

            <!-- Description -->
            <p class="class-card-description">
                {{ $cardDesc }}
            </p>

            <!-- Stats Row -->
            <div class="class-card-meta-row">
                <div class="class-meta-chip">
                    <i class="bi bi-book me-1"></i>
                    <span><strong>{{ $class->subjects_count }}</strong> Mapel</span>
                </div>
                <div class="class-meta-chip">
                    <i class="bi bi-journal-bookmark me-1"></i>
                    <span><strong>{{ $class->ebooks_count }}</strong> E-Book</span>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="class-card-footer-action">
                <span class="action-text">Buka Koleksi Kelas</span>
                <span class="action-icon">
                    <i class="bi bi-arrow-right"></i>
                </span>
            </div>
        </div>
    </a>
</div>
