<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Perpustakaan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --admin-green: #0f6b4f; --admin-blue: #1956a3; --admin-ink: #10233f; --admin-line: #d8e2ee; }
        body { background: #f4f7fb; color: var(--admin-ink); }
        .admin-shell { min-height: 100vh; }
        .admin-sidebar { background: linear-gradient(180deg, #0f6b4f, #123f72); color: #fff; width: 280px; }
        .admin-sidebar a { color: rgba(255, 255, 255, .85); border-radius: 8px; }
        .admin-sidebar a:hover, .admin-sidebar a.active { background: rgba(255, 255, 255, .12); color: #fff; }
        .admin-content { min-width: 0; }
        .admin-brand-mark { width: 44px; height: 44px; border-radius: 10px; background: rgba(255, 255, 255, .16); display: grid; place-items: center; font-weight: 800; }
        .admin-card { border: 1px solid var(--admin-line); border-radius: 8px; box-shadow: 0 12px 26px rgba(15, 35, 63, .07); }
        .stat-card { border-left: 4px solid var(--admin-green); }
        .stat-icon { width: 42px; height: 42px; border-radius: 8px; display: grid; place-items: center; background: #eef6f3; color: var(--admin-green); font-weight: 800; }
        .page-header { background: #fff; border: 1px solid var(--admin-line); border-radius: 8px; padding: 1rem; }
        @media (max-width: 991.98px) {
            .admin-shell { flex-direction: column; }
            .admin-sidebar { width: 100%; }
            .admin-content { padding: 1rem !important; }
        }
    </style>
</head>
<body>
<div class="admin-shell d-flex">
    <aside class="admin-sidebar p-3">
        <div class="mb-4 d-flex gap-2 align-items-center">
            <div class="admin-brand-mark">S1C</div>
            <div>
                <div class="fw-bold">PERPUSTAKAAN DIGITAL</div>
                <div class="small opacity-75">SMAN 1 CIKAMPEK</div>
                <div class="small text-uppercase opacity-75">Admin Panel</div>
            </div>
        </div>
        <nav class="nav flex-column gap-1">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}" href="{{ route('admin.classes.index') }}">Kelola Kelas</a>
            <a class="nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}" href="{{ route('admin.subjects.index') }}">Kelola Mata Pelajaran</a>
            <a class="nav-link {{ request()->routeIs('admin.ebooks.*') ? 'active' : '' }}" href="{{ route('admin.ebooks.index') }}">Kelola E-Book</a>
            <a class="nav-link {{ request()->routeIs('admin.access-logs.*') ? 'active' : '' }}" href="{{ route('admin.access-logs.index') }}">Access Logs</a>
        </nav>
        <form method="POST" action="{{ route('admin.logout') }}" class="mt-4">
            @csrf
            <button class="btn btn-outline-light w-100" type="submit">Logout</button>
        </form>
    </aside>

    <main class="admin-content flex-grow-1 p-4">
        <header class="page-header d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div>
                <div class="fw-bold">Perpustakaan Digital</div>
                <div class="text-muted small">SMAN 1 Cikampek</div>
            </div>
            <span class="badge text-bg-success">Admin</span>
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
</body>
</html>
