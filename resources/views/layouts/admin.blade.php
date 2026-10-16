<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Perpustakaan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --admin-green: #0f6b4f;
            --admin-green2: #16a167;
            --admin-blue:  #1956a3;
            --admin-ink:   #10233f;
            --admin-line:  #d8e2ee;
        }
        body { background: #f0f4f9; color: var(--admin-ink); font-family: 'Inter', sans-serif; }
        .admin-shell { min-height: 100vh; }
        .admin-sidebar { background: linear-gradient(180deg, #0f6b4f, #123f72); color: #fff; width: 280px; min-width: 280px; }
        .admin-sidebar a { color: rgba(255, 255, 255, .85); border-radius: 8px; }
        .admin-sidebar a:hover, .admin-sidebar a.active { background: rgba(255, 255, 255, .12); color: #fff; }
        .admin-content { min-width: 0; flex: 1 1 auto; }
        .admin-brand-mark { width: 52px; height: 52px; border-radius: 50%; object-fit: cover; background: #fff; }
        .ebook-table { min-width: 1120px; table-layout: fixed; }
        .ebook-table th, .ebook-table td { white-space: normal; vertical-align: top; word-break: break-word; }
        .ebook-table th:nth-child(1), .ebook-table td:nth-child(1) { width: 8%; }
        .ebook-table th:nth-child(2), .ebook-table td:nth-child(2) { width: 12%; }
        .ebook-table th:nth-child(3), .ebook-table td:nth-child(3) { width: 18%; }
        .ebook-table th:nth-child(4), .ebook-table td:nth-child(4) { width: 24%; }
        .ebook-table th:nth-child(5), .ebook-table td:nth-child(5) { width: 8%; }
        .ebook-table th:nth-child(6), .ebook-table td:nth-child(6) { width: 10%; }
        .ebook-table th:nth-child(7), .ebook-table td:nth-child(7) { width: 14%; }
        .admin-card { border: 1px solid var(--admin-line); border-radius: 12px; box-shadow: 0 4px 20px rgba(15,35,63,.06); }

        /* ===== STAT CARDS PREMIUM ===== */
        .stat-card {
            border: none !important;
            border-radius: 16px !important;
            position: relative;
            overflow: hidden;
            transition: transform 0.22s ease, box-shadow 0.22s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(15,35,63,.13) !important;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 110px; height: 110px;
            border-radius: 50%;
            background: rgba(255,255,255,0.12);
            pointer-events: none;
        }
        .stat-card-green  { background: linear-gradient(135deg, #0f6b4f, #16a167); }
        .stat-card-blue   { background: linear-gradient(135deg, #1956a3, #2876e8); }
        .stat-card-purple { background: linear-gradient(135deg, #5b3fa6, #8b5cf6); }
        .stat-card-amber  { background: linear-gradient(135deg, #b45309, #f59e0b); }
        .stat-card .card-body { position: relative; z-index: 1; }
        .stat-card .stat-label {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.75);
            margin-bottom: 0.35rem;
        }
        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            margin-bottom: 0.2rem;
        }
        .stat-card .stat-sub {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.65);
        }
        .stat-card .stat-icon-box {
            width: 52px; height: 52px;
            border-radius: 14px;
            background: rgba(255,255,255,0.18);
            display: grid; place-items: center;
            font-size: 1.5rem;
            color: #fff;
            flex-shrink: 0;
        }
        /* ===== SIDEBAR PREMIUM ===== */
        .admin-sidebar {
            background: linear-gradient(180deg, #0a4535 0%, #0f6b4f 35%, #123f72 100%);
            color: #fff;
            width: 272px;
            min-width: 272px;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 24px rgba(10,69,53,0.25);
        }
        .sidebar-nav-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            padding: 0.85rem 0.75rem 0.3rem;
        }
        .admin-sidebar .nav-link {
            color: rgba(255,255,255,0.78);
            border-radius: 10px;
            padding: 0.6rem 0.85rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            position: relative;
            transition: background 0.18s, color 0.18s, padding-left 0.18s;
        }
        .admin-sidebar .nav-link i {
            font-size: 1.05rem;
            width: 22px;
            text-align: center;
            flex-shrink: 0;
        }
        .admin-sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            padding-left: 1.1rem;
        }
        .admin-sidebar .nav-link.active {
            background: rgba(255,255,255,0.16);
            color: #fff;
            font-weight: 600;
            box-shadow: inset 3px 0 0 #34d89a;
        }
        .nav-badge {
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            border-radius: 999px;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 1px 7px;
            line-height: 1.6;
        }
        /* stat card, metric, chart – unchanged */
        .metric { border-left: 3px solid var(--admin-green); background: #f8fbfa; border-radius: 10px; padding: .85rem 1rem; }
        .activity-chart { height: 170px; display: flex; align-items: end; justify-content: space-between; gap: .6rem; border-bottom: 1px solid var(--admin-line); padding: 0 .2rem; }
        .activity-bar-wrap { height: 100%; flex: 1; min-width: 26px; display: flex; flex-direction: column; justify-content: end; align-items: center; gap: .4rem; }
        .activity-bar { width: 100%; max-width: 42px; min-height: 5px; background: linear-gradient(180deg, #279b77, var(--admin-green)); border-radius: 7px 7px 2px 2px; transition: height .2s ease; }
        /* ===== HEADER PREMIUM ===== */
        .page-header {
            background: linear-gradient(135deg, #0f6b4f 0%, #1956a3 100%);
            border: none;
            border-radius: 14px;
            padding: 0;
            box-shadow: 0 8px 32px rgba(15,107,79,0.22), 0 2px 8px rgba(25,86,163,0.12);
            overflow: hidden;
            position: relative;
        }
        .page-header::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            pointer-events: none;
        }
        .page-header::after {
            content: '';
            position: absolute;
            bottom: -30px; left: 30%;
            width: 140px; height: 140px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            pointer-events: none;
        }
        .page-header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.5rem;
            position: relative;
            z-index: 1;
        }
        /* Kiri – breadcrumb & judul halaman */
        .ph-left .ph-breadcrumb {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.6);
            font-weight: 500;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 0.15rem;
        }
        .ph-left .ph-title {
            font-size: 0.98rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
        }
        /* Tengah – sambutan */
        .ph-center {
            flex: 1;
            text-align: center;
        }
        .ph-center .ph-greeting {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.75);
            font-weight: 500;
        }
        .ph-center .ph-name {
            font-size: 1.05rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.2px;
        }
        /* Kanan – info admin & waktu */
        .ph-right { display: flex; align-items: center; gap: 0.85rem; flex-shrink: 0; }
        .ph-datetime {
            text-align: right;
        }
        .ph-datetime .ph-time {
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.5px;
            line-height: 1;
        }
        .ph-datetime .ph-date {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.65);
            margin-top: 2px;
        }
        .ph-divider-v {
            width: 1px;
            height: 36px;
            background: rgba(255,255,255,0.22);
        }
        .ph-avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.22);
            display: grid; place-items: center;
            font-weight: 800;
            font-size: 1rem;
            color: #fff;
            flex-shrink: 0;
            border: 2px solid rgba(255,255,255,0.35);
            box-shadow: 0 2px 12px rgba(0,0,0,0.15);
            transition: transform 0.2s;
            cursor: default;
        }
        .ph-avatar:hover { transform: scale(1.08); }
        .ph-admin-info .ph-admin-name {
            font-size: 0.82rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.1;
        }
        .ph-admin-info .ph-admin-role {
            font-size: 0.68rem;
            background: rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.9);
            border-radius: 999px;
            padding: 1px 8px;
            font-weight: 600;
            display: inline-block;
            margin-top: 2px;
            border: 1px solid rgba(255,255,255,0.25);
        }
        /* ===== END HEADER ===== */
        .audit-summary { background: linear-gradient(120deg, #fff, #f8fbfa); border: 1px solid var(--admin-line); border-radius: 12px; padding: 1rem; }
        .audit-item { border-left: 4px solid #d99a22; }
        .audit-item.critical { border-left-color: #c8414b; }
        .audit-badge-critical { background: #fbe8ea; color: #9d2732; }
        .audit-badge-warning { background: #fff3db; color: #965b00; }
        .audit-badge-info { background: #eaf2ff; color: #1956a3; }
        .pagination { --bs-pagination-color: var(--admin-ink); --bs-pagination-bg: #fff; --bs-pagination-border-width: 1px; --bs-pagination-border-color: var(--admin-line); --bs-pagination-hover-color: var(--admin-green); --bs-pagination-hover-bg: #eef6f3; --bs-pagination-hover-border-color: rgba(15, 107, 79, .35); --bs-pagination-active-color: #fff; --bs-pagination-active-bg: var(--admin-green); --bs-pagination-active-border-color: var(--admin-green); --bs-pagination-disabled-color: #8a96a6; --bs-pagination-disabled-bg: #f4f7fb; --bs-pagination-disabled-border-color: var(--admin-line); }
        .pagination .page-link {
            min-width: 42px; min-height: 42px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; font-weight: 600; transition: all .2s ease;
        }
        .pagination .page-link:hover { transform: translateY(-1px); }
        .pagination .page-item.active .page-link { box-shadow: 0 8px 18px rgba(15, 107, 79, .18); }
        .pagination .page-item.disabled .page-link { cursor: not-allowed; }
        @media (max-width: 991.98px) {
            .admin-shell { flex-direction: column; }
            .admin-sidebar { width: 100%; }
            .admin-content { padding: 1rem !important; }
            .activity-chart { gap: .35rem; }
        }
    </style>
</head>
<body>
<div class="admin-shell d-flex">
    <aside class="admin-sidebar p-3">
        {{-- Brand --}}
        <div class="mb-3 d-flex gap-2 align-items-center px-1 pt-1">
            <img class="admin-brand-mark" src="{{ asset('images/logo-perpus-sman-1-cikampek.jpeg') }}" alt="Logo">
            <div>
                <div class="fw-bold" style="font-size:0.82rem;letter-spacing:0.03em;">PERPUSTAKAAN DIGITAL</div>
                <div class="small opacity-60" style="font-size:0.72rem;">SMAN 1 CIKAMPEK</div>
                <span style="font-size:0.62rem;background:rgba(255,255,255,0.15);color:rgba(255,255,255,0.8);border-radius:4px;padding:1px 6px;font-weight:600;">ADMIN PANEL</span>
            </div>
        </div>

        <hr style="border-color:rgba(255,255,255,0.12);margin:0 0 0.5rem;">

        {{-- Menu Utama --}}
        <nav class="nav flex-column gap-0">
            <div class="sidebar-nav-label">Menu Utama</div>

            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>

            <div class="sidebar-nav-label">Konten</div>

            <a class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}"
               href="{{ route('admin.classes.index') }}">
                <i class="bi bi-building"></i> Kelola Kelas
            </a>
            <a class="nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}"
               href="{{ route('admin.subjects.index') }}">
                <i class="bi bi-journal-bookmark-fill"></i> Mata Pelajaran
            </a>
            <a class="nav-link {{ request()->routeIs('admin.ebooks.*') ? 'active' : '' }}"
               href="{{ route('admin.ebooks.index') }}">
                <i class="bi bi-book-fill"></i> Kelola E-Book
            </a>

            <div class="sidebar-nav-label">Monitoring</div>

            <a class="nav-link {{ request()->routeIs('admin.audit-logs.*', 'admin.access-logs.*') ? 'active' : '' }}"
               href="{{ route('admin.audit-logs.index') }}">
                <i class="bi bi-activity"></i> Audit Log
            </a>

            <div class="sidebar-nav-label">Laporan</div>

            <a class="nav-link {{ request()->routeIs('admin.ebook-reports.*') ? 'active' : '' }}"
               href="{{ route('admin.ebook-reports.index') }}">
                <i class="bi bi-flag-fill"></i> Laporan E-Book
                @if(!empty($stats['open_reports']) && $stats['open_reports'] > 0)
                    <span class="nav-badge">{{ $stats['open_reports'] }}</span>
                @endif
            </a>
            <a class="nav-link {{ request()->routeIs('admin.ebook-comments.*') ? 'active' : '' }}"
               href="{{ route('admin.ebook-comments.index') }}">
                <i class="bi bi-chat-dots-fill"></i> Moderasi Komentar
                @if(!empty($stats['new_comments']) && $stats['new_comments'] > 0)
                    <span class="nav-badge">{{ $stats['new_comments'] }}</span>
                @endif
            </a>
            <a class="nav-link {{ request()->routeIs('admin.comment-reports.*') ? 'active' : '' }}"
               href="{{ route('admin.comment-reports.index') }}">
                <i class="bi bi-shield-exclamation"></i> Laporan Komentar
                @if(!empty($stats['open_comment_reports']) && $stats['open_comment_reports'] > 0)
                    <span class="nav-badge">{{ $stats['open_comment_reports'] }}</span>
                @endif
            </a>
        </nav>

        {{-- Spacer --}}
        <div class="flex-grow-1"></div>

        {{-- Info akun admin --}}
        <div class="mt-3 pt-3" style="border-top: 1px solid rgba(255,255,255,0.12);">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div style="width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,0.18);display:grid;place-items:center;font-weight:800;font-size:1rem;color:#fff;flex-shrink:0;border:2px solid rgba(255,255,255,0.25);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div style="min-width:0;">
                    <div class="fw-semibold text-white" style="font-size:0.82rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name }}</div>
                    <div class="opacity-55" style="font-size:0.70rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-outline-light w-100" type="submit" style="font-size:0.82rem;border-radius:8px;">
                    <i class="bi bi-box-arrow-left me-1"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="admin-content flex-grow-1 p-4">
        <header class="page-header mb-4">
            <div class="page-header-inner">

                {{-- Kiri: info halaman --}}
                <div class="ph-left d-none d-md-block">
                    <div class="ph-breadcrumb">
                        <i class="bi bi-grid-1x2-fill me-1"></i>
                        Perpustakaan Digital &rsaquo; SMAN 1 Cikampek
                    </div>
                    <div class="ph-title">@yield('title', 'Admin Panel')</div>
                </div>

                {{-- Tengah: sambutan --}}
                <div class="ph-center d-none d-lg-block">
                    <div class="ph-greeting">&#128075; Selamat datang kembali,</div>
                    <div class="ph-name">{{ auth()->user()->name }}</div>
                </div>

                {{-- Kanan: waktu + info admin --}}
                <div class="ph-right">
                    {{-- Jam & tanggal realtime --}}
                    <div class="ph-datetime d-none d-sm-block">
                        <div class="ph-time" id="ph-clock">--:--</div>
                        <div class="ph-date" id="ph-date">-- --- ----</div>
                    </div>

                    <div class="ph-divider-v d-none d-sm-block"></div>

                    {{-- Avatar + nama --}}
                    <div class="ph-avatar" title="{{ auth()->user()->email }}">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="ph-admin-info d-none d-md-block">
                        <div class="ph-admin-name">{{ auth()->user()->name }}</div>
                        <span class="ph-admin-role"><i class="bi bi-shield-lock-fill me-1"></i>Admin</span>
                    </div>
                </div>

            </div>
        </header>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">Periksa kembali data yang diisi.</div>
        @endif
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
<script>
    // ===== JAM & TANGGAL REAL-TIME DI HEADER =====
    const HARI   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const BULAN  = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    function updateClock() {
        const now  = new Date();
        const hh   = String(now.getHours()).padStart(2,'0');
        const mm   = String(now.getMinutes()).padStart(2,'0');
        const ss   = String(now.getSeconds()).padStart(2,'0');
        const day  = HARI[now.getDay()];
        const tgl  = now.getDate();
        const bln  = BULAN[now.getMonth()];
        const thn  = now.getFullYear();

        const clockEl = document.getElementById('ph-clock');
        const dateEl  = document.getElementById('ph-date');
        if (clockEl) clockEl.textContent = `${hh}:${mm}:${ss}`;
        if (dateEl)  dateEl.textContent  = `${day}, ${tgl} ${bln} ${thn}`;
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>
</body>
</html>
