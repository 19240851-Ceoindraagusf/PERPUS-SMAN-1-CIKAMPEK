@php
    $norm = strtolower($subject->name);
    
    // Categorize cluster, theme, and icon
    if (str_contains($norm, 'matematika')) {
        $cluster = 'Matematika & Logika';
        $subTheme = 'subject-theme-blue';
        $subIcon = 'bi-calculator-fill';
        $clusterFilter = 'sains';
    } elseif (str_contains($norm, 'fisika')) {
        $cluster = 'Sains & Fisika';
        $subTheme = 'subject-theme-cyan';
        $subIcon = 'bi-lightning-charge-fill';
        $clusterFilter = 'sains';
    } elseif (str_contains($norm, 'kimia')) {
        $cluster = 'Sains & Kimia';
        $subTheme = 'subject-theme-teal';
        $subIcon = 'bi-radioactive';
        $clusterFilter = 'sains';
    } elseif (str_contains($norm, 'biologi')) {
        $cluster = 'Sains & Hayati';
        $subTheme = 'subject-theme-emerald';
        $subIcon = 'bi-flower1';
        $clusterFilter = 'sains';
    } elseif (str_contains($norm, 'ipa') || str_contains($norm, 'sains')) {
        $cluster = 'Ilmu Pengetahuan Alam';
        $subTheme = 'subject-theme-blue';
        $subIcon = 'bi-flask';
        $clusterFilter = 'sains';
    } elseif (str_contains($norm, 'inggris')) {
        $cluster = 'Bahasa Inggris & Asing';
        $subTheme = 'subject-theme-emerald';
        $subIcon = 'bi-translate';
        $clusterFilter = 'bahasa';
    } elseif (str_contains($norm, 'indonesia')) {
        $cluster = 'Bahasa & Sastra Indonesia';
        $subTheme = 'subject-theme-emerald';
        $subIcon = 'bi-book-half';
        $clusterFilter = 'bahasa';
    } elseif (str_contains($norm, 'sunda') || str_contains($norm, 'daerah') || str_contains($norm, 'jawa')) {
        $cluster = 'Muatan Lokal & Bahasa Daerah';
        $subTheme = 'subject-theme-emerald';
        $subIcon = 'bi-chat-heart-fill';
        $clusterFilter = 'bahasa';
    } elseif (str_contains($norm, 'sejarah')) {
        $cluster = 'Sejarah & Peradaban';
        $subTheme = 'subject-theme-amber';
        $subIcon = 'bi-hourglass-split';
        $clusterFilter = 'sosial';
    } elseif (str_contains($norm, 'geografi')) {
        $cluster = 'Geografi & Kebumian';
        $subTheme = 'subject-theme-amber';
        $subIcon = 'bi-globe-asia-australia';
        $clusterFilter = 'sosial';
    } elseif (str_contains($norm, 'sosiologi')) {
        $cluster = 'Sosiologi & Antropologi';
        $subTheme = 'subject-theme-amber';
        $subIcon = 'bi-people-fill';
        $clusterFilter = 'sosial';
    } elseif (str_contains($norm, 'ekonomi') || str_contains($norm, 'akuntansi')) {
        $cluster = 'Ekonomi & Finansial';
        $subTheme = 'subject-theme-amber';
        $subIcon = 'bi-graph-up-arrow';
        $clusterFilter = 'sosial';
    } elseif (str_contains($norm, 'pancasila') || str_contains($norm, 'ppkn') || str_contains($norm, 'kewarganegaraan')) {
        $cluster = 'Pancasila & Kebangsaan';
        $subTheme = 'subject-theme-crimson';
        $subIcon = 'bi-shield-fill-check';
        $clusterFilter = 'sosial';
    } elseif (str_contains($norm, 'agama') || str_contains($norm, 'islam') || str_contains($norm, 'kristen') || str_contains($norm, 'katolik')) {
        $cluster = 'Agama & Budi Pekerti';
        $subTheme = 'subject-theme-purple';
        $subIcon = 'bi-moon-stars-fill';
        $clusterFilter = 'lainnya';
    } elseif (str_contains($norm, 'seni') || str_contains($norm, 'budaya') || str_contains($norm, 'musik') || str_contains($norm, 'rupa')) {
        $cluster = 'Seni & Kebudayaan';
        $subTheme = 'subject-theme-rose';
        $subIcon = 'bi-palette-fill';
        $clusterFilter = 'lainnya';
    } elseif (str_contains($norm, 'pjok') || str_contains($norm, 'penjas') || str_contains($norm, 'olahraga')) {
        $cluster = 'Pendidikan Jasmani & Kesehatan';
        $subTheme = 'subject-theme-orange';
        $subIcon = 'bi-heart-pulse-fill';
        $clusterFilter = 'lainnya';
    } elseif (str_contains($norm, 'informatika') || str_contains($norm, 'tik') || str_contains($norm, 'komputer')) {
        $cluster = 'Informatika & Teknologi';
        $subTheme = 'subject-theme-indigo';
        $subIcon = 'bi-laptop-fill';
        $clusterFilter = 'sains';
    } elseif (str_contains($norm, 'prakarya') || str_contains($norm, 'pkwu') || str_contains($norm, 'kewirausahaan')) {
        $cluster = 'Prakarya & Kewirausahaan';
        $subTheme = 'subject-theme-orange';
        $subIcon = 'bi-tools';
        $clusterFilter = 'lainnya';
    } else {
        $cluster = 'Mata Pelajaran Kurikulum';
        $subTheme = 'subject-theme-blue';
        $subIcon = 'bi-mortarboard-fill';
        $clusterFilter = 'lainnya';
    }
@endphp

<div class="col-md-6 col-lg-4 subject-card-col" data-subject-cluster="{{ $clusterFilter }}">
    <a href="{{ route('subjects.show', [$class, $subject]) }}" class="subject-card-premium {{ $subTheme }} text-decoration-none">
        <!-- Top color accent stripe -->
        <div class="subject-card-top-accent"></div>
        
        <div class="subject-card-inner">
            <!-- Header: Icon & Cluster Badge -->
            <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                <div class="subject-icon-box">
                    <i class="bi {{ $subIcon }}"></i>
                </div>
                <span class="subject-cluster-badge">{{ $cluster }}</span>
            </div>

            <!-- Title & Class Tag -->
            <div class="subject-card-title-wrap mb-2">
                <div class="subject-card-class-tag">Kelas {{ $class->name }}</div>
                <h3 class="subject-card-title mb-1">{{ $subject->name }}</h3>
            </div>

            <!-- Description -->
            <p class="subject-card-desc text-muted mb-3">
                {{ $subject->description ?: 'Buku pelajaran dan materi kurikulum digital untuk mata pelajaran ' . $subject->name . ' SMAN 1 Cikampek.' }}
            </p>

            <!-- Stats Row -->
            <div class="subject-card-stats-row mb-3">
                <div class="subject-stat-pill">
                    <i class="bi bi-journal-bookmark-fill me-1"></i>
                    <span><strong>{{ $subject->ebooks_count }}</strong> E-Book</span>
                </div>
                <span class="subject-stat-status {{ $subject->ebooks_count > 0 ? 'status-available' : 'status-empty' }}">
                    <i class="bi {{ $subject->ebooks_count > 0 ? 'bi-check-circle-fill' : 'bi-dash-circle' }} me-1"></i>
                    {{ $subject->ebooks_count > 0 ? 'Koleksi Siap' : 'Belum Ada' }}
                </span>
            </div>

            <!-- Footer Action -->
            <div class="subject-card-action-footer">
                <span class="action-text">Buka Koleksi Mapel</span>
                <span class="action-icon">
                    <i class="bi bi-arrow-right"></i>
                </span>
            </div>
        </div>
    </a>
</div>
