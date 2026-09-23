<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Perpustakaan Digital SMAN 1 Cikampek')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --school-green: #0f6b4f;
            --school-blue: #1956a3;
            --school-ink: #10233f;
            --school-muted: #64748b;
            --school-soft: #eef6f3;
            --school-line: #d8e2ee;
        }
        body { background: #f6f8fb; color: var(--school-ink); }
        a { color: var(--school-blue); }
        .navbar { backdrop-filter: blur(16px); }
        .brand-mark {
            width: 48px; height: 48px; border-radius: 10px;
            background: linear-gradient(135deg, var(--school-green), var(--school-blue));
            color: #fff; display: grid; place-items: center; font-weight: 800; letter-spacing: 0;
            box-shadow: 0 10px 22px rgba(15, 107, 79, .22);
        }
        .brand-name { line-height: 1.05; }
        .nav-pill { border-radius: 999px; color: var(--school-ink); padding: .5rem .9rem; }
        .nav-pill:hover, .nav-pill.active { background: var(--school-soft); color: var(--school-green); }
        .hero {
            background:
                linear-gradient(135deg, rgba(15, 107, 79, .95), rgba(25, 86, 163, .92)),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, .28), transparent 24%);
            color: #fff;
        }
        .hero-panel { background: rgba(255, 255, 255, .14); border: 1px solid rgba(255, 255, 255, .26); border-radius: 8px; }
        .section-title { max-width: 680px; }
        .info-card, .card {
            border: 1px solid var(--school-line); border-radius: 8px;
            box-shadow: 0 12px 26px rgba(15, 35, 63, .07);
        }
        .info-card { transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease; }
        .info-card:hover { transform: translateY(-3px); border-color: rgba(15, 107, 79, .45); box-shadow: 0 18px 34px rgba(15, 35, 63, .12); }
        .metric { border-left: 3px solid var(--school-green); background: #fff; border-radius: 8px; padding: 1rem; }
        .icon-box { width: 42px; height: 42px; border-radius: 8px; display: grid; place-items: center; background: var(--school-soft); color: var(--school-green); font-weight: 800; }
        .search-panel { background: #fff; border: 1px solid var(--school-line); border-radius: 8px; padding: 1rem; }
        .badge-soft { background: var(--school-soft); color: var(--school-green); }
        .btn-success { background: var(--school-green); border-color: var(--school-green); }
        .btn-outline-success { color: var(--school-green); border-color: var(--school-green); }
        .btn-outline-success:hover { background: var(--school-green); border-color: var(--school-green); }
        @media (max-width: 575.98px) {
            .brand-mark { width: 42px; height: 42px; font-size: .85rem; }
            .brand-name { font-size: .92rem; }
            .hero { text-align: left; }
            .display-5 { font-size: 2rem; }
            .search-panel .btn { width: 100%; }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="{{ route('library') }}">
            <span class="brand-mark">S1C</span>
            <span class="brand-name">PERPUSTAKAAN DIGITAL<br><small class="text-muted">SMAN 1 CIKAMPEK</small></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNav" aria-controls="publicNav" aria-expanded="false" aria-label="Buka navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="publicNav">
            <div class="navbar-nav ms-auto gap-lg-2 mt-3 mt-lg-0">
                <a class="nav-link nav-pill {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                <a class="nav-link nav-pill {{ request()->routeIs('library') || request()->routeIs('classes.*') || request()->routeIs('subjects.*') || request()->routeIs('ebooks.*') ? 'active' : '' }}" href="{{ route('library') }}">Perpustakaan</a>
                <a class="nav-link nav-pill" href="{{ route('admin.login') }}">Admin</a>
            </div>
        </div>
    </div>
</nav>

<main>@yield('content')</main>

<footer class="border-top bg-white py-4 mt-5">
    <div class="container text-center text-muted small">
        &copy; {{ date('Y') }} Perpustakaan Digital SMAN 1 Cikampek.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
