<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Perpustakaan Digital SMAN 1 Cikampek')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f7f9fc; }
        .hero { background: linear-gradient(135deg, #0f5132, #0d6efd); color: #fff; }
        .brand-mark { width: 44px; height: 44px; border-radius: 8px; background: #fff; color: #0f5132; display: grid; place-items: center; font-weight: 700; }
        .card { border: 0; border-radius: 8px; box-shadow: 0 8px 24px rgba(15, 23, 42, .08); }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="{{ route('library') }}">
            <span class="brand-mark">P</span>
            <span>PERPUSTAKAAN DIGITAL<br><small class="text-muted">SMAN 1 CIKAMPEK</small></span>
        </a>
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
