<!doctype html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Perpustakaan Digital SMAN 1 Cikampek')</title>
    <meta name="description" content="@yield('meta_description', 'Katalog buku pelajaran dan materi digital SMAN 1 Cikampek.')">
    <meta name="theme-color" content="#0f6b4f">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Perpustakaan Digital SMAN 1 Cikampek')">
    <meta property="og:description" content="@yield('meta_description', 'Katalog buku pelajaran dan materi digital SMAN 1 Cikampek.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo-perpus-sman-1-cikampek.jpeg') }}">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-perpus-sman-1-cikampek.jpeg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap');
        :root {
            --school-green: #0f6b4f;
            --school-blue: #1956a3;
            --school-ink: #10233f;
            --school-muted: #64748b;
            --school-soft: #eef6f3;
            --school-line: #d8e2ee;
        }
        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }
        body { background: #f6f8fb; color: var(--school-ink); font-family: 'DM Sans', sans-serif; }
        h1, h2, h3, .brand-name { font-family: 'Plus Jakarta Sans', sans-serif; }
        a { color: var(--school-blue); }
        .navbar {
            box-shadow: 0 1px 0 rgba(16, 35, 63, .06);
            position: sticky;
            top: 0;
            z-index: 1040;
            background-color: #ffffff;
        }
        [data-bs-theme="dark"] .navbar {
            background-color: #111a28 !important;
            border-bottom-color: rgba(255, 255, 255, 0.08) !important;
        }
        .brand-mark {
            width: 56px; height: 56px; border-radius: 50%; object-fit: cover;
            box-shadow: 0 5px 14px rgba(15, 35, 63, .18);
        }
        .brand-name { line-height: 1.05; }
        .nav-pill { border-radius: 10px; color: var(--school-ink); padding: .5rem .9rem; font-weight: 600; }
        .nav-pill:hover, .nav-pill.active { background: var(--school-soft); color: var(--school-green); }
        .hero {
            background: linear-gradient(135deg, rgba(15, 107, 79, 0.82), rgba(18, 63, 114, 0.85)), url('{{ asset("images/gedung-sman-1-cikampek.png") }}') center/cover no-repeat;
            color: #fff;
            position: relative;
            overflow: visible;
            z-index: 20;
            padding-top: 3.5rem !important;
            padding-bottom: 3.5rem !important;
            min-height: 480px;
        }
        .hero-bg-shapes {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }
        .hero-bg-shapes::after {
            content: '';
            position: absolute;
            width: 420px;
            height: 420px;
            border: 1px solid rgba(255,255,255,.13);
            border-radius: 50%;
            right: -120px;
            bottom: -260px;
            pointer-events: none;
        }
        .hero-panel { background: rgba(255, 255, 255, .14); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, .26); border-radius: 16px; position: relative; z-index: 2; }
        .section-title { max-width: 680px; }
        .info-card, .card {
            border: 1px solid var(--school-line); border-radius: 16px;
            box-shadow: 0 12px 26px rgba(15, 35, 63, .07);
        }
        .info-card { transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease; }
        .info-card:hover { transform: translateY(-3px); border-color: rgba(15, 107, 79, .45); box-shadow: 0 18px 34px rgba(15, 35, 63, .12); }
        .metric { border-left: 3px solid var(--school-green); background: #fff; border-radius: 12px; padding: 1rem; }
        .icon-box { width: 48px; height: 48px; border-radius: 14px; display: grid; place-items: center; background: var(--school-soft); color: var(--school-green); font-weight: 800; }
        .class-card:nth-child(3n+2) .icon-box { background: #edf3ff; color: var(--school-blue); }
        .class-card:nth-child(3n) .icon-box { background: #fff4df; color: #b66a00; }

        /* ==========================================================================
           CLASS THEMES & COLOR CODING (PILIH KELAS)
           ========================================================================== */
        .class-theme-emerald {
            --cls-primary: #059669;
            --cls-primary-hover: #047857;
            --cls-bg-soft: #ecfdf5;
            --cls-border: #a7f3d0;
            --cls-glow: rgba(5, 150, 105, 0.2);
            --cls-gradient: linear-gradient(135deg, #059669 0%, #10b981 100%);
            --cls-badge-bg: #d1fae5;
            --cls-badge-text: #065f46;
        }
        .class-theme-blue {
            --cls-primary: #2563eb;
            --cls-primary-hover: #1d4ed8;
            --cls-bg-soft: #eff6ff;
            --cls-border: #bfdbfe;
            --cls-glow: rgba(37, 99, 235, 0.2);
            --cls-gradient: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            --cls-badge-bg: #dbeafe;
            --cls-badge-text: #1e40af;
        }
        .class-theme-amber {
            --cls-primary: #d97706;
            --cls-primary-hover: #b45309;
            --cls-bg-soft: #fffbeb;
            --cls-border: #fde68a;
            --cls-glow: rgba(217, 119, 6, 0.2);
            --cls-gradient: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
            --cls-badge-bg: #fef3c7;
            --cls-badge-text: #92400e;
        }
        .class-theme-purple {
            --cls-primary: #7c3aed;
            --cls-primary-hover: #6d28d9;
            --cls-bg-soft: #f5f3ff;
            --cls-border: #ddd6fe;
            --cls-glow: rgba(124, 58, 237, 0.2);
            --cls-gradient: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            --cls-badge-bg: #ede9fe;
            --cls-badge-text: #5b21b6;
        }
        .class-theme-cyan {
            --cls-primary: #0284c7;
            --cls-primary-hover: #0369a1;
            --cls-bg-soft: #f0f9ff;
            --cls-border: #bae6fd;
            --cls-glow: rgba(2, 132, 199, 0.2);
            --cls-gradient: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%);
            --cls-badge-bg: #e0f2fe;
            --cls-badge-text: #075985;
        }
        .class-theme-indigo {
            --cls-primary: #4f46e5;
            --cls-primary-hover: #4338ca;
            --cls-bg-soft: #eef2ff;
            --cls-border: #c7d2fe;
            --cls-glow: rgba(79, 70, 229, 0.2);
            --cls-gradient: linear-gradient(135deg, #4338ca 0%, #6366f1 100%);
            --cls-badge-bg: #e0e7ff;
            --cls-badge-text: #3730a3;
        }
        .class-theme-orange {
            --cls-primary: #ea580c;
            --cls-primary-hover: #c2410c;
            --cls-bg-soft: #fff7ed;
            --cls-border: #fed7aa;
            --cls-glow: rgba(234, 88, 12, 0.2);
            --cls-gradient: linear-gradient(135deg, #c2410c 0%, #f97316 100%);
            --cls-badge-bg: #ffedd5;
            --cls-badge-text: #9a3412;
        }
        .class-theme-rose {
            --cls-primary: #e11d48;
            --cls-primary-hover: #be123c;
            --cls-bg-soft: #fff1f2;
            --cls-border: #fecdd3;
            --cls-glow: rgba(225, 29, 72, 0.2);
            --cls-gradient: linear-gradient(135deg, #be123c 0%, #fb7185 100%);
            --cls-badge-bg: #ffe4e6;
            --cls-badge-text: #9f1239;
        }
        .class-theme-crimson {
            --cls-primary: #dc2626;
            --cls-primary-hover: #b91c1c;
            --cls-bg-soft: #fef2f2;
            --cls-border: #fecaca;
            --cls-glow: rgba(220, 38, 38, 0.2);
            --cls-gradient: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%);
            --cls-badge-bg: #fee2e2;
            --cls-badge-text: #991b1b;
        }

        /* Dark mode theme adjustments */
        [data-bs-theme="dark"] .class-theme-emerald {
            --cls-bg-soft: rgba(5, 150, 105, 0.14);
            --cls-border: rgba(5, 150, 105, 0.35);
            --cls-badge-bg: rgba(5, 150, 105, 0.25);
            --cls-badge-text: #6ee7b7;
        }
        [data-bs-theme="dark"] .class-theme-blue {
            --cls-bg-soft: rgba(37, 99, 235, 0.14);
            --cls-border: rgba(37, 99, 235, 0.35);
            --cls-badge-bg: rgba(37, 99, 235, 0.25);
            --cls-badge-text: #93c5fd;
        }
        [data-bs-theme="dark"] .class-theme-amber {
            --cls-bg-soft: rgba(217, 119, 6, 0.14);
            --cls-border: rgba(217, 119, 6, 0.35);
            --cls-badge-bg: rgba(217, 119, 6, 0.25);
            --cls-badge-text: #fcd34d;
        }
        [data-bs-theme="dark"] .class-theme-purple {
            --cls-bg-soft: rgba(124, 58, 237, 0.14);
            --cls-border: rgba(124, 58, 237, 0.35);
            --cls-badge-bg: rgba(124, 58, 237, 0.25);
            --cls-badge-text: #c4b5fd;
        }
        [data-bs-theme="dark"] .class-theme-cyan {
            --cls-bg-soft: rgba(2, 132, 199, 0.14);
            --cls-border: rgba(2, 132, 199, 0.35);
            --cls-badge-bg: rgba(2, 132, 199, 0.25);
            --cls-badge-text: #7dd3fc;
        }
        [data-bs-theme="dark"] .class-theme-indigo {
            --cls-bg-soft: rgba(79, 70, 229, 0.14);
            --cls-border: rgba(79, 70, 229, 0.35);
            --cls-badge-bg: rgba(79, 70, 229, 0.25);
            --cls-badge-text: #a5b4fc;
        }
        [data-bs-theme="dark"] .class-theme-orange {
            --cls-bg-soft: rgba(234, 88, 12, 0.14);
            --cls-border: rgba(234, 88, 12, 0.35);
            --cls-badge-bg: rgba(234, 88, 12, 0.25);
            --cls-badge-text: #fdba74;
        }
        [data-bs-theme="dark"] .class-theme-rose {
            --cls-bg-soft: rgba(225, 29, 72, 0.14);
            --cls-border: rgba(225, 29, 72, 0.35);
            --cls-badge-bg: rgba(225, 29, 72, 0.25);
            --cls-badge-text: #fda4af;
        }
        [data-bs-theme="dark"] .class-theme-crimson {
            --cls-bg-soft: rgba(220, 38, 38, 0.14);
            --cls-border: rgba(220, 38, 38, 0.35);
            --cls-badge-bg: rgba(220, 38, 38, 0.25);
            --cls-badge-text: #fca5a5;
        }

        /* Class Filter Button Group */
        .class-filter-btn-group {
            display: inline-flex;
            background: #e9eff5;
            padding: 4px;
            border-radius: 999px;
            gap: 4px;
            border: 1px solid var(--school-line);
        }
        [data-bs-theme="dark"] .class-filter-btn-group {
            background: #1a2739;
            border-color: rgba(255, 255, 255, 0.08);
        }
        .class-filter-pill {
            border: none;
            background: transparent;
            color: var(--school-muted);
            font-size: 0.825rem;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 999px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            white-space: nowrap;
        }
        .class-filter-pill:hover {
            color: var(--school-ink);
        }
        .class-filter-pill.active {
            background: #ffffff;
            color: var(--school-green);
            box-shadow: 0 3px 10px rgba(15, 35, 63, 0.12);
        }
        [data-bs-theme="dark"] .class-filter-pill:hover {
            color: #f1f5f9;
        }
        [data-bs-theme="dark"] .class-filter-pill.active {
            background: #25354c;
            color: #6ee7b7;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
        }

        .class-card-col {
            transition: opacity 0.25s ease, transform 0.25s ease;
        }
        .class-card-col.is-hidden {
            display: none !important;
        }

        /* Premium Class Card Component */
        .class-card-premium {
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            background: #ffffff;
            border: 1px solid var(--cls-border, var(--school-line));
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(15, 35, 63, 0.04);
            transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1), 
                        box-shadow 0.28s cubic-bezier(0.16, 1, 0.3, 1), 
                        border-color 0.25s ease;
        }
        [data-bs-theme="dark"] .class-card-premium {
            background: #141f2e;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.3);
        }
        .class-card-premium:hover {
            transform: translateY(-6px);
            border-color: var(--cls-primary);
            box-shadow: 0 18px 38px var(--cls-glow), 0 4px 12px rgba(15, 35, 63, 0.08);
        }
        [data-bs-theme="dark"] .class-card-premium:hover {
            box-shadow: 0 18px 38px var(--cls-glow), 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        /* Top Accent Stripe */
        .class-card-top-accent {
            height: 6px;
            width: 100%;
            background: var(--cls-gradient);
        }

        /* Inner Content */
        .class-card-inner {
            padding: 1.45rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            position: relative;
            z-index: 1;
        }

        /* Icon Box */
        .class-icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            background: var(--cls-gradient);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
            box-shadow: 0 8px 18px var(--cls-glow);
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .class-card-premium:hover .class-icon-wrapper {
            transform: scale(1.1) rotate(-3deg);
        }

        /* Stream Pill */
        .class-stream-pill {
            display: inline-block;
            padding: 0.35rem 0.8rem;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            border-radius: 999px;
            background: var(--cls-badge-bg);
            color: var(--cls-badge-text);
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        /* Watermark Number */
        .class-watermark-num {
            position: absolute;
            right: 0;
            top: -26px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 4.6rem;
            font-weight: 900;
            line-height: 1;
            color: var(--cls-primary);
            opacity: 0.06;
            pointer-events: none;
            user-select: none;
            transition: opacity 0.25s ease, transform 0.25s ease;
        }
        .class-card-premium:hover .class-watermark-num {
            opacity: 0.13;
            transform: translateY(-4px);
        }

        /* Level micro label */
        .class-level-micro {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--cls-primary);
            margin-bottom: 0.25rem;
        }

        /* Title */
        .class-card-heading {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--school-ink);
            margin: 0;
            line-height: 1.25;
            letter-spacing: -0.01em;
        }
        [data-bs-theme="dark"] .class-card-heading {
            color: #f1f5f9;
        }

        /* Description */
        .class-card-description {
            font-size: 0.885rem;
            line-height: 1.5;
            color: var(--school-muted);
            margin-top: 0.5rem;
            margin-bottom: 1.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.65rem;
        }
        [data-bs-theme="dark"] .class-card-description {
            color: #94a3b8;
        }

        /* Meta chips */
        .class-card-meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }
        .class-meta-chip {
            display: inline-flex;
            align-items: center;
            background: var(--cls-bg-soft);
            color: var(--cls-primary);
            border-radius: 10px;
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid var(--cls-border);
        }
        .class-meta-chip strong {
            font-weight: 800;
            margin-right: 0.25rem;
        }

        /* Footer Action */
        .class-card-footer-action {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid var(--school-line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--cls-primary);
            transition: color 0.2s ease;
        }
        [data-bs-theme="dark"] .class-card-footer-action {
            border-top-color: rgba(255, 255, 255, 0.08);
        }
        .class-card-footer-action .action-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--cls-bg-soft);
            color: var(--cls-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), 
                        background 0.25s ease, 
                        color 0.25s ease;
        }
        .class-card-premium:hover .class-card-footer-action .action-icon {
            transform: translateX(5px);
            background: var(--cls-primary);
            color: #ffffff;
        }

        /* Class Page Hero Banner */
        .class-hero-banner {
            background: var(--cls-gradient);
            color: #ffffff;
            box-shadow: 0 12px 28px var(--cls-glow);
            position: relative;
        }
        .class-hero-banner .class-stream-pill {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.35);
            backdrop-filter: blur(4px);
        }
        .class-hero-banner .class-meta-chip {
            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.28);
            backdrop-filter: blur(4px);
        }
        .class-hero-banner .btn-outline-light:hover {
            background: #ffffff;
            color: var(--cls-primary);
        }
        .search-panel { background: #fff; border: 1px solid var(--school-line); border-radius: 16px; padding: 1rem; position: relative; z-index: 1060; }
        .badge-soft { background: var(--school-soft); color: var(--school-green); }
        .btn-success { background: var(--school-green); border-color: var(--school-green); }
        .btn-outline-success { color: var(--school-green); border-color: var(--school-green); }
        .btn-outline-success:hover { background: var(--school-green); border-color: var(--school-green); }
        .eyebrow { color: var(--school-green); font-size: .75rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
        .hero .eyebrow { color: rgba(255, 255, 255, .72); }
        .hero-search { max-width: 760px; }
        .hero-search .form-control, .hero-search .form-select { min-height: 52px; }
        .hero-search .btn { min-height: 52px; }
        .hero-collection { border-left: 1px solid rgba(255, 255, 255, .25); position: relative; z-index: 1; }
        .school-photo { position: relative; overflow: hidden; min-height: 260px; border: 1px solid rgba(255,255,255,.3); border-radius: 18px; box-shadow: 0 22px 32px rgba(0,0,0,.22); }
        .school-photo img { width: 100%; height: 260px; object-fit: cover; object-position: center; display: block; }
        .school-photo::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, transparent 42%, rgba(7, 42, 38, .72)); pointer-events: none; }
        .school-photo-caption { position: absolute; z-index: 1; right: 1rem; bottom: .85rem; left: 1rem; color: #fff; font-weight: 700; text-shadow: 0 1px 8px rgba(0,0,0,.48); }
        .hero-stat { background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.18); border-radius: 12px; padding: .8rem; }
        .quick-chip { border: 1px solid rgba(255,255,255,.28); background: rgba(255,255,255,.1); color: #fff; border-radius: 99px; padding: .3rem .65rem; font-size: .8rem; text-decoration: none; transition: .18s ease; }
        .quick-chip:hover { background: #fff; color: var(--school-green); }
        .collection-card { overflow: hidden; }
        .collection-card .card-body { padding: 1rem; }
        .book-cover { aspect-ratio: 3 / 4; width: 100%; object-fit: cover; background: #e7edf4; }
        .book-cover[loading="lazy"] { content-visibility: auto; }
        .book-cover-placeholder { aspect-ratio: 3 / 4; color: #fff; display: flex; flex-direction: column; justify-content: space-between; padding: 1rem; overflow: hidden; position: relative; }
        .book-cover-placeholder::after { content: ''; position: absolute; width: 130%; aspect-ratio: 1; border: 1px solid rgba(255,255,255,.18); border-radius: 50%; right: -48%; bottom: -35%; }
        .book-cover-placeholder strong, .book-cover-placeholder small { position: relative; z-index: 1; }
        .book-cover-theme-0 { background: linear-gradient(145deg, #0f6b4f, #1fa779); }
        .book-cover-theme-1 { background: linear-gradient(145deg, #1956a3, #538ee0); }
        .book-cover-theme-2 { background: linear-gradient(145deg, #8e4c13, #e29a38); }
        .book-cover-theme-3 { background: linear-gradient(145deg, #6b317f, #aa6ec0); }
        .book-cover-theme-4 { background: linear-gradient(145deg, #b44952, #e47d80); }
        .book-cover-placeholder small { color: rgba(255, 255, 255, .72); }
        .book-title { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .book-meta { min-height: 2.5rem; }
        .collection-card .card-footer { background: #fff; border-top: 1px solid var(--school-line); padding: .75rem 1rem; }
        .book-row-cover { width: 88px; flex: 0 0 88px; }
        .empty-state { border: 1px dashed var(--school-line); background: #fff; border-radius: 8px; padding: 2rem; text-align: center; }
        .detail-cover { max-height: 30rem; width: 100%; object-fit: cover; }
        .detail-actions { border-top: 1px solid var(--school-line); padding-top: 1rem; }
        .section-kicker { color: var(--school-green); font-weight: 700; letter-spacing: .05em; text-transform: uppercase; font-size: .75rem; }
        .book-card-image { position: relative; }
        .book-badge { position: absolute; top: .75rem; left: .75rem; box-shadow: 0 4px 14px rgba(0,0,0,.15); }
        .book-card-footer { display: flex; align-items: center; justify-content: space-between; }
        .catalog-toolbar { border-bottom: 1px solid var(--school-line); }
        .reader-frame { width: 100%; height: min(78vh, 960px); border: 0; border-radius: 14px; background: #e7edf4; }
        .reader-shell { background: #e7edf4; border-radius: 16px; padding: .75rem; transition: background .2s ease; }
        .reader-shell.reader-dark { background: #142033; }
        .reader-shell.reader-dark .reader-frame { background: #1a2738; }
        .saved-book-card { border: 1px solid var(--school-line); border-radius: 14px; background: #fff; padding: 1rem; }
        .saved-book-card + .saved-book-card { margin-top: .75rem; }
        .study-banner { border: 1px solid var(--school-line); border-radius: 18px; background: linear-gradient(115deg, #eff8f4, #f7fbff); padding: 1.5rem; display: flex; gap: 1rem; justify-content: space-between; align-items: center; }
        .study-banner .eyebrow { color: var(--school-green); }
        .voice-search-host { position: relative; }
        .voice-search-input { padding-right: 3rem !important; }
        .voice-search-button {
            position: absolute; right: .45rem; top: 50%; transform: translateY(-50%);
            z-index: 4; width: 2.15rem; height: 2.15rem; border: 0; border-radius: 50%;
            display: grid; place-items: center; color: var(--school-green); background: #eaf5f0;
            transition: background .18s ease, color .18s ease, box-shadow .18s ease;
        }
        .voice-search-button:hover { background: var(--school-green); color: #fff; }
        .voice-search-button.is-listening { background: #dc2626; color: #fff; animation: voice-pulse 1.1s infinite; }
        .voice-search-button.is-unavailable { opacity: .45; cursor: not-allowed; }
        .voice-search-host > .input-group-text { padding-right: 2.8rem; }
        @keyframes voice-pulse { 50% { box-shadow: 0 0 0 .45rem rgba(220,38,38,.18); } }
        .search-suggestions { 
            position: absolute; 
            z-index: 1090; 
            top: calc(100% + .4rem); 
            left: 0; 
            width: 100%;
            min-width: 100%;
            max-height: min(420px, 65vh); 
            overflow-y: auto; 
            overscroll-behavior: contain; 
            background: #ffffff; 
            border: 1px solid var(--school-line); 
            border-radius: 16px; 
            box-shadow: 0 20px 45px rgba(15, 35, 63, 0.22); 
            scrollbar-width: thin;
            scrollbar-color: rgba(15, 107, 79, 0.35) transparent;
        }
        .search-suggestions::-webkit-scrollbar {
            width: 6px;
        }
        .search-suggestions::-webkit-scrollbar-track {
            background: transparent;
            margin: 8px 0;
        }
        .search-suggestions::-webkit-scrollbar-thumb {
            background: rgba(15, 107, 79, 0.3);
            border-radius: 10px;
        }
        .search-suggestions::-webkit-scrollbar-thumb:hover {
            background: rgba(15, 107, 79, 0.5);
        }
        [data-bs-theme="dark"] .search-suggestions {
            background: #152238;
            border-color: rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.6);
            scrollbar-color: rgba(255, 255, 255, 0.25) transparent;
        }
        [data-bs-theme="dark"] .search-suggestions::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.25);
        }
        @media (min-width: 768px) {
            .hero-search .search-suggestions {
                min-width: min(520px, calc(100vw - 3rem));
                width: max-content;
                max-width: min(560px, calc(100vw - 4rem));
            }
        }
        .search-suggestion-heading { 
            position: sticky; 
            top: 0; 
            z-index: 2; 
            padding: .65rem 1rem; 
            background: #f7faf9; 
            border-bottom: 1px solid var(--school-line); 
            color: var(--school-muted); 
            font-size: .72rem; 
            font-weight: 700; 
            letter-spacing: .08em; 
            text-transform: uppercase; 
        }
        [data-bs-theme="dark"] .search-suggestion-heading {
            background: #111b2d;
            border-bottom-color: rgba(255,255,255,0.08);
            color: #94a3b8;
        }
        .search-suggestion { 
            display: flex; 
            align-items: center; 
            gap: 0.85rem; 
            padding: .7rem 1rem; 
            color: var(--school-ink); 
            text-decoration: none; 
            border-bottom: 1px solid rgba(0,0,0,0.03); 
            transition: all 0.18s ease;
        }
        .search-suggestion .bi-arrow-right {
            transition: transform 0.18s ease, color 0.18s ease, opacity 0.18s ease;
        }
        [data-bs-theme="dark"] .search-suggestion {
            color: #e2e8f0;
            border-bottom-color: rgba(255,255,255,0.04);
        }
        .search-suggestion:hover, .search-suggestion:focus, .search-suggestion.active { 
            background: var(--school-soft); 
            color: var(--school-green); 
            padding-left: 1.25rem;
        }
        .search-suggestion:hover .bi-arrow-right,
        .search-suggestion:focus .bi-arrow-right,
        .search-suggestion.active .bi-arrow-right {
            transform: translateX(4px);
            opacity: 1 !important;
            color: var(--school-green) !important;
        }
        [data-bs-theme="dark"] .search-suggestion:hover,
        [data-bs-theme="dark"] .search-suggestion:focus,
        [data-bs-theme="dark"] .search-suggestion.active {
            background: rgba(16, 185, 129, 0.14);
            color: #6ee7b7;
        }
        .search-all-results { 
            display: block; 
            position: sticky; 
            bottom: 0; 
            padding: .75rem 1rem; 
            background: #ffffff; 
            border-top: 1px solid var(--school-line); 
            color: var(--school-green); 
            font-size: .875rem; 
            font-weight: 700; 
            text-decoration: none; 
        }
        [data-bs-theme="dark"] .search-all-results {
            background: #152238;
            border-top-color: rgba(255, 255, 255, 0.1);
            color: #34d399;
        }
        .search-shortcut-badge {
            font-size: 0.68rem;
            font-weight: 700;
            background: rgba(255,255,255,0.25);
            color: inherit;
            padding: 2px 7px;
            border-radius: 6px;
            border: 1px solid rgba(255,255,255,0.4);
            pointer-events: none;
            letter-spacing: 0.05em;
        }
        .hero-search .search-shortcut-badge {
            background: rgba(255,255,255,0.25);
            color: #fff;
        }
        .catalog-search .search-shortcut-badge {
            background: rgba(0,0,0,0.05);
            color: #64748b;
            border-color: rgba(0,0,0,0.08);
        }

        /* Reader Sepia & Dark Enhancements */
        .reader-shell.reader-sepia { background: #fbf0d9 !important; }
        .reader-shell.reader-sepia .reader-frame { filter: sepia(0.35) contrast(0.95); }
        .reader-progress-track {
            height: 4px;
            background: rgba(0,0,0,0.06);
            border-radius: 999px;
            overflow: hidden;
            width: 100%;
        }
        .reader-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--school-green), #10b981);
            transition: width 0.3s ease;
        }
        /* ==========================================================================
           FAVORITES & SAVED BOOKS PAGE STYLING
           ========================================================================== */
        .favorites-hero {
            background: linear-gradient(135deg, #0f6b4f 0%, #164e63 50%, #1956a3 100%);
            color: #ffffff;
            border-radius: 24px;
            padding: 2.5rem 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 16px 36px rgba(15, 35, 63, 0.15);
        }
        .favorites-hero::after {
            content: '';
            position: absolute;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            top: -100px;
            right: -60px;
            border-radius: 50%;
            pointer-events: none;
        }
        .favorites-hero-stat {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 14px;
            padding: 0.75rem 1.25rem;
            backdrop-filter: blur(8px);
            display: inline-flex;
            align-items: center;
            gap: 0.85rem;
        }
        .favorites-hero-stat .stat-num {
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1;
        }
        .favorites-panel-card {
            border: 1px solid var(--school-line);
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(15, 35, 63, 0.04);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        [data-bs-theme="dark"] .favorites-panel-card {
            background: #141f2e;
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
        }
        .favorites-panel-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--school-line);
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        [data-bs-theme="dark"] .favorites-panel-header {
            background: #182638;
            border-bottom-color: rgba(255, 255, 255, 0.08);
        }
        .favorites-panel-body {
            padding: 1.25rem;
            flex-grow: 1;
        }
        .saved-book-card-premium {
            background: #ffffff;
            border: 1px solid var(--school-line);
            border-radius: 16px;
            padding: 0.9rem 1.1rem;
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 2px 8px rgba(15, 35, 63, 0.03);
        }
        [data-bs-theme="dark"] .saved-book-card-premium {
            background: #19273a;
            border-color: rgba(255, 255, 255, 0.08);
        }
        .saved-book-card-premium:hover {
            transform: translateY(-3px);
            border-color: rgba(15, 107, 79, 0.45);
            box-shadow: 0 10px 24px rgba(15, 35, 63, 0.08);
        }
        [data-bs-theme="dark"] .saved-book-card-premium:hover {
            border-color: rgba(110, 231, 183, 0.4);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.35);
        }
        .saved-book-thumb-wrapper {
            width: 50px;
            height: 66px;
            border-radius: 8px;
            overflow: hidden;
            background: #e2e8f0;
            box-shadow: 0 3px 8px rgba(0,0,0,0.12);
        }
        .saved-book-thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .saved-book-thumb-fallback {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0f6b4f 0%, #1956a3 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        .saved-book-title {
            color: var(--school-ink);
            font-size: 0.95rem;
            line-height: 1.3;
            transition: color 0.18s ease;
        }
        [data-bs-theme="dark"] .saved-book-title {
            color: #f1f5f9;
        }
        .saved-book-title:hover {
            color: var(--school-green);
        }
        [data-bs-theme="dark"] .saved-book-title:hover {
            color: #6ee7b7;
        }
        .saved-empty-state {
            padding: 3rem 1.5rem;
        }
        .saved-empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(15, 107, 79, 0.08);
            color: var(--school-green);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.85rem;
        }
        /* ==========================================================================
           SUBJECT (MATA PELAJARAN) THEMES & CARDS
           ========================================================================== */
        .subject-theme-blue {
            --sbj-primary: #2563eb;
            --sbj-gradient: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            --sbj-soft: #eff6ff;
            --sbj-border: #bfdbfe;
            --sbj-glow: rgba(37, 99, 235, 0.2);
            --sbj-badge-bg: #dbeafe;
            --sbj-badge-text: #1e40af;
        }
        .subject-theme-cyan {
            --sbj-primary: #0284c7;
            --sbj-gradient: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            --sbj-soft: #f0f9ff;
            --sbj-border: #bae6fd;
            --sbj-glow: rgba(2, 132, 199, 0.2);
            --sbj-badge-bg: #e0f2fe;
            --sbj-badge-text: #075985;
        }
        .subject-theme-teal {
            --sbj-primary: #0d9488;
            --sbj-gradient: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
            --sbj-soft: #f0fdfa;
            --sbj-border: #99f6e4;
            --sbj-glow: rgba(13, 148, 136, 0.2);
            --sbj-badge-bg: #ccfbf1;
            --sbj-badge-text: #115e59;
        }
        .subject-theme-emerald {
            --sbj-primary: #059669;
            --sbj-gradient: linear-gradient(135deg, #059669 0%, #10b981 100%);
            --sbj-soft: #ecfdf5;
            --sbj-border: #a7f3d0;
            --sbj-glow: rgba(5, 150, 105, 0.2);
            --sbj-badge-bg: #d1fae5;
            --sbj-badge-text: #065f46;
        }
        .subject-theme-amber {
            --sbj-primary: #d97706;
            --sbj-gradient: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
            --sbj-soft: #fffbeb;
            --sbj-border: #fde68a;
            --sbj-glow: rgba(217, 119, 6, 0.2);
            --sbj-badge-bg: #fef3c7;
            --sbj-badge-text: #92400e;
        }
        .subject-theme-orange {
            --sbj-primary: #ea580c;
            --sbj-gradient: linear-gradient(135deg, #c2410c 0%, #f97316 100%);
            --sbj-soft: #fff7ed;
            --sbj-border: #fed7aa;
            --sbj-glow: rgba(234, 88, 12, 0.2);
            --sbj-badge-bg: #ffedd5;
            --sbj-badge-text: #9a3412;
        }
        .subject-theme-rose {
            --sbj-primary: #e11d48;
            --sbj-gradient: linear-gradient(135deg, #be123c 0%, #fb7185 100%);
            --sbj-soft: #fff1f2;
            --sbj-border: #fecdd3;
            --sbj-glow: rgba(225, 29, 72, 0.2);
            --sbj-badge-bg: #ffe4e6;
            --sbj-badge-text: #9f1239;
        }
        .subject-theme-purple {
            --sbj-primary: #7c3aed;
            --sbj-gradient: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%);
            --sbj-soft: #f5f3ff;
            --sbj-border: #ddd6fe;
            --sbj-glow: rgba(124, 58, 237, 0.2);
            --sbj-badge-bg: #ede9fe;
            --sbj-badge-text: #5b21b6;
        }
        .subject-theme-indigo {
            --sbj-primary: #4f46e5;
            --sbj-gradient: linear-gradient(135deg, #4338ca 0%, #6366f1 100%);
            --sbj-soft: #eef2ff;
            --sbj-border: #c7d2fe;
            --sbj-glow: rgba(79, 70, 229, 0.2);
            --sbj-badge-bg: #e0e7ff;
            --sbj-badge-text: #3730a3;
        }
        .subject-theme-crimson {
            --sbj-primary: #dc2626;
            --sbj-gradient: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%);
            --sbj-soft: #fef2f2;
            --sbj-border: #fecaca;
            --sbj-glow: rgba(220, 38, 38, 0.2);
            --sbj-badge-bg: #fee2e2;
            --sbj-badge-text: #991b1b;
        }

        /* Dark mode overrides for subjects */
        [data-bs-theme="dark"] .subject-theme-blue { --sbj-soft: rgba(37, 99, 235, 0.14); --sbj-border: rgba(37, 99, 235, 0.35); --sbj-badge-bg: rgba(37, 99, 235, 0.25); --sbj-badge-text: #93c5fd; }
        [data-bs-theme="dark"] .subject-theme-cyan { --sbj-soft: rgba(2, 132, 199, 0.14); --sbj-border: rgba(2, 132, 199, 0.35); --sbj-badge-bg: rgba(2, 132, 199, 0.25); --sbj-badge-text: #7dd3fc; }
        [data-bs-theme="dark"] .subject-theme-teal { --sbj-soft: rgba(13, 148, 136, 0.14); --sbj-border: rgba(13, 148, 136, 0.35); --sbj-badge-bg: rgba(13, 148, 136, 0.25); --sbj-badge-text: #5eead4; }
        [data-bs-theme="dark"] .subject-theme-emerald { --sbj-soft: rgba(5, 150, 105, 0.14); --sbj-border: rgba(5, 150, 105, 0.35); --sbj-badge-bg: rgba(5, 150, 105, 0.25); --sbj-badge-text: #6ee7b7; }
        [data-bs-theme="dark"] .subject-theme-amber { --sbj-soft: rgba(217, 119, 6, 0.14); --sbj-border: rgba(217, 119, 6, 0.35); --sbj-badge-bg: rgba(217, 119, 6, 0.25); --sbj-badge-text: #fcd34d; }
        [data-bs-theme="dark"] .subject-theme-orange { --sbj-soft: rgba(234, 88, 12, 0.14); --sbj-border: rgba(234, 88, 12, 0.35); --sbj-badge-bg: rgba(234, 88, 12, 0.25); --sbj-badge-text: #fdba74; }
        [data-bs-theme="dark"] .subject-theme-rose { --sbj-soft: rgba(225, 29, 72, 0.14); --sbj-border: rgba(225, 29, 72, 0.35); --sbj-badge-bg: rgba(225, 29, 72, 0.25); --sbj-badge-text: #fda4af; }
        [data-bs-theme="dark"] .subject-theme-purple { --sbj-soft: rgba(124, 58, 237, 0.14); --sbj-border: rgba(124, 58, 237, 0.35); --sbj-badge-bg: rgba(124, 58, 237, 0.25); --sbj-badge-text: #c4b5fd; }
        [data-bs-theme="dark"] .subject-theme-indigo { --sbj-soft: rgba(79, 70, 229, 0.14); --sbj-border: rgba(79, 70, 229, 0.35); --sbj-badge-bg: rgba(79, 70, 229, 0.25); --sbj-badge-text: #a5b4fc; }
        [data-bs-theme="dark"] .subject-theme-crimson { --sbj-soft: rgba(220, 38, 38, 0.14); --sbj-border: rgba(220, 38, 38, 0.35); --sbj-badge-bg: rgba(220, 38, 38, 0.25); --sbj-badge-text: #fca5a5; }

        /* Subject Card Component */
        .subject-card-col {
            transition: opacity 0.25s ease, transform 0.25s ease;
        }
        .subject-card-col.is-hidden {
            display: none !important;
        }
        .subject-card-premium {
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            background: #ffffff;
            border: 1px solid var(--sbj-border, var(--school-line));
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(15, 35, 63, 0.04);
            transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1), 
                        box-shadow 0.28s cubic-bezier(0.16, 1, 0.3, 1), 
                        border-color 0.25s ease;
        }
        [data-bs-theme="dark"] .subject-card-premium {
            background: #141f2e;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.3);
        }
        .subject-card-premium:hover {
            transform: translateY(-6px);
            border-color: var(--sbj-primary);
            box-shadow: 0 18px 36px var(--sbj-glow), 0 4px 12px rgba(15, 35, 63, 0.08);
        }
        [data-bs-theme="dark"] .subject-card-premium:hover {
            box-shadow: 0 18px 36px var(--sbj-glow), 0 4px 12px rgba(0, 0, 0, 0.4);
        }
        .subject-card-top-accent {
            height: 6px;
            width: 100%;
            background: var(--sbj-gradient);
        }
        .subject-card-inner {
            padding: 1.45rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            position: relative;
            z-index: 1;
        }
        .subject-icon-box {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            background: var(--sbj-gradient);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
            box-shadow: 0 8px 18px var(--sbj-glow);
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .subject-card-premium:hover .subject-icon-box {
            transform: scale(1.1) rotate(-3deg);
        }
        .subject-cluster-badge {
            display: inline-block;
            padding: 0.35rem 0.8rem;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            border-radius: 999px;
            background: var(--sbj-badge-bg);
            color: var(--sbj-badge-text);
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .subject-card-class-tag {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--sbj-primary);
            margin-bottom: 0.25rem;
        }
        .subject-card-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--school-ink);
            margin: 0;
            line-height: 1.25;
            letter-spacing: -0.01em;
        }
        [data-bs-theme="dark"] .subject-card-title {
            color: #f1f5f9;
        }
        .subject-card-desc {
            font-size: 0.885rem;
            line-height: 1.5;
            color: var(--school-muted);
            margin-top: 0.5rem;
            margin-bottom: 1.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.65rem;
        }
        [data-bs-theme="dark"] .subject-card-desc {
            color: #94a3b8;
        }
        .subject-card-stats-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }
        .subject-stat-pill {
            display: inline-flex;
            align-items: center;
            background: var(--sbj-soft);
            color: var(--sbj-primary);
            border-radius: 10px;
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid var(--sbj-border);
        }
        .subject-stat-status {
            font-size: 0.78rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
        }
        .subject-stat-status.status-available {
            color: #059669;
        }
        [data-bs-theme="dark"] .subject-stat-status.status-available {
            color: #34d399;
        }
        .subject-stat-status.status-empty {
            color: var(--school-muted);
        }
        .subject-card-action-footer {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid var(--school-line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--sbj-primary);
            transition: color 0.2s ease;
        }
        [data-bs-theme="dark"] .subject-card-action-footer {
            border-top-color: rgba(255, 255, 255, 0.08);
        }
        .subject-card-action-footer .action-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--sbj-soft);
            color: var(--sbj-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), 
                        background 0.25s ease, 
                        color 0.25s ease;
        }
        .subject-card-premium:hover .subject-card-action-footer .action-icon {
            transform: translateX(5px);
            background: var(--sbj-primary);
            color: #ffffff;
        }

        /* Subject Detail Hero Banner */
        .subject-hero-banner {
            background: var(--sbj-gradient);
            color: #ffffff;
            box-shadow: 0 12px 30px var(--sbj-glow);
            position: relative;
            overflow: hidden;
        }
        .subject-hero-banner .subject-cluster-badge {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.35);
            backdrop-filter: blur(4px);
        }
        .subject-hero-banner .subject-stat-pill {
            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.28);
            backdrop-filter: blur(4px);
        }

        /* ==========================================================================
           MODERN E-BOOK CARDS & DASHBOARD ENHANCEMENTS
           ========================================================================== */
        .ebook-modern-card {
            background: #ffffff;
            border: 1px solid var(--school-line);
            border-radius: 20px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 18px rgba(15, 35, 63, 0.04);
            transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1), 
                        box-shadow 0.28s cubic-bezier(0.16, 1, 0.3, 1), 
                        border-color 0.25s ease;
        }
        [data-bs-theme="dark"] .ebook-modern-card {
            background: #141f2e;
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.3);
        }
        .ebook-modern-card:hover {
            transform: translateY(-6px);
            border-color: var(--school-green);
            box-shadow: 0 18px 36px rgba(15, 35, 63, 0.12), 0 2px 8px rgba(0,0,0,0.04);
        }
        [data-bs-theme="dark"] .ebook-modern-card:hover {
            border-color: #6ee7b7;
            box-shadow: 0 18px 36px rgba(0, 0, 0, 0.45);
        }
        .ebook-cover-wrapper {
            position: relative;
            overflow: hidden;
            background: #e7edf4;
            aspect-ratio: 3 / 4;
        }
        .ebook-cover-wrapper img, 
        .ebook-cover-wrapper .book-cover,
        .ebook-cover-wrapper .book-cover-placeholder {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }
        .ebook-modern-card:hover .ebook-cover-wrapper img,
        .ebook-modern-card:hover .ebook-cover-wrapper .book-cover {
            transform: scale(1.05);
        }
        .ebook-floating-badge {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            z-index: 2;
            padding: 0.35rem 0.75rem;
            font-size: 0.72rem;
            font-weight: 700;
            border-radius: 999px;
            letter-spacing: 0.03em;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(8px);
        }
        .ebook-floating-badge.badge-new {
            background: rgba(15, 107, 79, 0.92);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .ebook-floating-badge.badge-popular {
            background: rgba(217, 119, 6, 0.92);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .ebook-card-content {
            padding: 1.15rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .ebook-card-title {
            font-size: 0.95rem;
            font-weight: 700;
            line-height: 1.35;
            color: var(--school-ink);
            margin-bottom: 0.35rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.6rem;
            transition: color 0.2s ease;
        }
        .ebook-card-title a {
            color: inherit;
            text-decoration: none;
        }
        [data-bs-theme="dark"] .ebook-card-title {
            color: #f1f5f9;
        }
        .ebook-modern-card:hover .ebook-card-title,
        .ebook-card-title a:hover {
            color: var(--school-green);
        }
        [data-bs-theme="dark"] .ebook-modern-card:hover .ebook-card-title,
        [data-bs-theme="dark"] .ebook-card-title a:hover {
            color: #6ee7b7;
        }
        .ebook-card-meta {
            font-size: 0.8rem;
            color: var(--school-muted);
            margin-bottom: 0.85rem;
        }
        .ebook-card-actions {
            margin-top: auto;
            padding-top: 0.85rem;
            border-top: 1px solid var(--school-line);
        }
        [data-bs-theme="dark"] .ebook-card-actions {
            border-top-color: rgba(255, 255, 255, 0.08);
        }

        /* Study Banner Premium */
        .study-banner-premium {
            background: linear-gradient(135deg, #eff8f4 0%, #f0f7ff 100%);
            border: 1px solid var(--school-line);
        }
        [data-bs-theme="dark"] .study-banner-premium {
            background: linear-gradient(135deg, #13222e 0%, #162438 100%);
            border-color: rgba(255, 255, 255, 0.08);
        }

        /* Recent Dashboard Card */
        .recent-dashboard-card {
            background: #ffffff;
            border: 1px solid var(--school-line);
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(15, 35, 63, 0.04);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        [data-bs-theme="dark"] .recent-dashboard-card {
            background: #141f2e;
            border-color: rgba(255, 255, 255, 0.08);
        }
        .recent-dashboard-card:hover {
            transform: translateY(-4px);
            border-color: var(--school-green);
            box-shadow: 0 14px 28px rgba(15, 35, 63, 0.08);
        }

        /* ==========================================================================
           LIBRARY CATALOG & HERO BANNER
           ========================================================================== */
        .library-hero-banner {
            background: linear-gradient(135deg, #0f6b4f 0%, #0d543e 40%, #1956a3 100%);
            color: #ffffff;
            border-radius: 24px;
            padding: 2.5rem 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 16px 36px rgba(15, 35, 63, 0.14);
        }
        .library-hero-banner::after {
            content: '';
            position: absolute;
            width: 340px;
            height: 340px;
            background: radial-gradient(circle, rgba(255,255,255,0.18) 0%, transparent 70%);
            top: -120px;
            right: -80px;
            border-radius: 50%;
            pointer-events: none;
        }
        .library-filter-panel {
            position: relative;
            z-index: 20;
            background: #ffffff;
            border: 1px solid var(--school-line);
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(15, 35, 63, 0.04);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        [data-bs-theme="dark"] .library-filter-panel {
            background: #141f2e;
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
        }
        .active-filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: var(--school-soft);
            color: var(--school-green);
            border: 1px solid rgba(15, 107, 79, 0.25);
            border-radius: 999px;
            padding: 0.28rem 0.75rem;
            font-size: 0.78rem;
            font-weight: 600;
        }
        [data-bs-theme="dark"] .active-filter-chip {
            background: rgba(15, 107, 79, 0.2);
            color: #6ee7b7;
            border-color: rgba(110, 231, 183, 0.3);
        }

        /* ==========================================================================
           COMMENTS & REVIEWS MODERN STYLING
           ========================================================================== */
        .comments-hero-banner {
            background: linear-gradient(135deg, #0f6b4f 0%, #164e63 45%, #1956a3 100%);
            color: #ffffff;
            border-radius: 24px;
            padding: 2.5rem 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 16px 36px rgba(15, 35, 63, 0.14);
        }
        .comments-hero-banner::after {
            content: '';
            position: absolute;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(255,255,255,0.16) 0%, transparent 70%);
            top: -100px;
            right: -60px;
            border-radius: 50%;
            pointer-events: none;
        }
        .comment-card-modern {
            background: #ffffff;
            border: 1px solid var(--school-line);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 4px 18px rgba(15, 35, 63, 0.04);
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.22s ease, border-color 0.2s ease;
        }
        [data-bs-theme="dark"] .comment-card-modern {
            background: #141f2e;
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.25);
        }
        .comment-card-modern:hover {
            transform: translateY(-3px);
            border-color: var(--school-green);
            box-shadow: 0 12px 28px rgba(15, 35, 63, 0.09);
        }
        [data-bs-theme="dark"] .comment-card-modern:hover {
            border-color: #6ee7b7;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.4);
        }
        .comment-avatar {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.15rem;
            color: #ffffff;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }
        .comment-bubble {
            background: #f8fafc;
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 14px;
            padding: 1rem 1.25rem;
            color: var(--school-ink);
            font-size: 0.95rem;
            line-height: 1.55;
            position: relative;
        }
        [data-bs-theme="dark"] .comment-bubble {
            background: #182638;
            border-color: rgba(255, 255, 255, 0.07);
            color: #e2e8f0;
        }
        .comment-book-banner {
            background: linear-gradient(135deg, rgba(15, 107, 79, 0.06) 0%, rgba(25, 86, 163, 0.06) 100%);
            border: 1px dashed rgba(15, 107, 79, 0.25);
            border-radius: 12px;
            transition: background 0.2s ease, border-color 0.2s ease;
        }
        [data-bs-theme="dark"] .comment-book-banner {
            background: rgba(15, 107, 79, 0.12);
            border-color: rgba(110, 231, 183, 0.2);
        }
        .comment-book-banner:hover {
            background: rgba(15, 107, 79, 0.1);
            border-color: var(--school-green);
        }
        .comment-report-accordion summary {
            cursor: pointer;
            list-style: none;
            user-select: none;
        }
        .comment-report-accordion summary::-webkit-details-marker {
            display: none;
        }
        .comment-report-card {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 14px;
            padding: 0.85rem 1rem;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.06);
        }
        [data-bs-theme="dark"] .comment-report-card {
            background: #241416;
            border-color: rgba(239, 68, 68, 0.3);
        }
        /* Refined library interface */
        :root { --school-green: #12634c; --school-blue: #244f83; --school-ink: #172b45; --school-muted: #64748b; --school-line: #e1e8ef; --school-soft: #eff6f2; }
        body { background: #f5f7f8; letter-spacing: -.01em; }
        .navbar { border-bottom: 1px solid #e7edf1; box-shadow: 0 5px 24px rgba(19,43,67,.045); }
        .nav-pill { border-radius: 999px; }
        .hero { min-height: 440px; padding-top: 4.5rem !important; padding-bottom: 4.5rem !important; background-image: linear-gradient(110deg, rgba(9,48,39,.91), rgba(20,64,93,.76)), url('{{ asset("images/gedung-sman-1-cikampek.png") }}'); }
        .hero h1 { letter-spacing: -.045em; line-height: 1.08; }
        .hero-panel { border-radius: 22px; box-shadow: 0 20px 55px rgba(6,28,46,.16); }
        .section-title { letter-spacing: -.035em; }
        .card, .info-card { border-color: #e4eaf0; border-radius: 18px; box-shadow: 0 8px 28px rgba(20,42,63,.055); }
        .info-card:hover { transform: translateY(-3px); box-shadow: 0 16px 35px rgba(20,42,63,.09); }
        .btn { font-weight: 600; transition: transform .18s ease, box-shadow .18s ease, background-color .18s ease; }
        .btn-success { --bs-btn-bg: #12634c; --bs-btn-border-color: #12634c; --bs-btn-hover-bg: #0d503d; --bs-btn-hover-border-color: #0d503d; }
        .form-control, .form-select, .input-group-text { min-height: 44px; border-color: #dce5eb; border-radius: 11px; }
        .form-control:focus, .form-select:focus { border-color: #5a9a80; box-shadow: 0 0 0 .22rem rgba(18,99,76,.13); }
        .library-hero-banner, .favorites-hero { border-radius: 24px; box-shadow: 0 18px 40px rgba(18,60,69,.13); }
        .library-filter-panel { background: #fff; border: 1px solid #e4eaf0; border-radius: 20px; box-shadow: 0 10px 30px rgba(20,42,63,.055); }
        .active-filter-chip { border-radius: 999px; }
        .class-hero-banner, .subject-hero-banner, .comments-hero-banner { border-radius: 24px; box-shadow: 0 16px 38px rgba(18,60,69,.11); }
        .class-hero-banner h1, .subject-hero-banner h1, .comments-hero-banner h1, .library-hero-banner h1 { letter-spacing: -.035em; line-height: 1.12; }
        .ebook-modern-card, .ebook-card, .book-card, .library-book-card { overflow: hidden; border: 1px solid #e5ebf0; border-radius: 18px; background: #fff; box-shadow: 0 8px 24px rgba(20,42,63,.055); transition: transform .22s ease, box-shadow .22s ease; }
        .ebook-modern-card:hover, .ebook-card:hover, .book-card:hover, .library-book-card:hover { transform: translateY(-4px); box-shadow: 0 18px 35px rgba(20,42,63,.11); }
        .ebook-cover-wrapper { background: #edf2f5; }
        .ebook-cover-wrapper .book-cover { width: 100%; height: 100%; display: block; object-fit: cover; }
        .ebook-card-title { line-height: 1.35; font-weight: 700; }
        .ebook-card-title a { color: #172b45; text-decoration: none; }
        .ebook-card-title a:hover { color: #12634c; }
        .ebook-card-meta { color: #66788b !important; }
        .ebook-card-actions .btn { min-height: 34px; }
        .book-cover-placeholder { min-height: 100%; }
        .book-cover, .ebook-cover, .book-cover-image { object-fit: cover; background: #edf2f5; }
        .ebook-title, .book-title { color: #172b45; font-weight: 700; line-height: 1.35; }
        .ebook-meta, .book-meta { color: #66788b; font-size: .84rem; }
        .detail-breadcrumb { font-size: .9rem; }
        .detail-hero { --detail-ink: #173247; position: relative; isolation: isolate; overflow: hidden; padding: clamp(1.15rem, 3vw, 2.5rem); border: 1px solid #cfe7ed; border-radius: 28px; background: linear-gradient(128deg, #e5f6f8 0%, #d8f0f2 48%, #dcecf8 100%); box-shadow: 0 20px 48px rgba(30,91,112,.12); }
        .detail-hero::before, .detail-hero::after { content: ""; position: absolute; z-index: -1; border-radius: 50%; pointer-events: none; }
        .detail-hero::before { width: 390px; height: 390px; right: 15%; top: -285px; background: rgba(70,170,183,.12); }
        .detail-hero::after { width: 300px; height: 300px; right: -110px; bottom: -230px; background: rgba(76,143,190,.1); }
        .detail-cover-card { position: sticky; top: 100px; overflow: hidden; border: 0 !important; border-radius: 18px !important; background: transparent; box-shadow: none !important; }
        .detail-cover-card .card-body { padding: 0 !important; }
        .detail-cover-stage { min-height: 300px; display: grid; place-items: center; padding: 0; border-radius: 0; background: transparent; }
        .detail-cover-stage .detail-cover { width: 100%; max-width: 430px; max-height: min(76vh, 680px); object-fit: contain; border-radius: 10px; box-shadow: 0 12px 30px rgba(18,42,62,.14); }
        .detail-cover-stage .book-cover-placeholder { width: min(100%, 430px); aspect-ratio: 2 / 3; min-height: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.5rem; border-radius: 12px; box-shadow: 0 12px 30px rgba(18,42,62,.14); }
        .detail-cover-caption { color: #637688; font-size: .76rem; font-weight: 600; }
        .detail-info-panel { padding: clamp(.5rem, 1.5vw, 1.3rem); border: 0; border-radius: 0; background: transparent; box-shadow: none; }
        .detail-kicker, .detail-subject-chip { display: inline-flex; align-items: center; border-radius: 99px; padding: .45rem .8rem; font-size: .8rem; font-weight: 700; }
        .detail-kicker { color: #176c70; background: #d2eeeb; border: 1px solid #b9e0dc; }
        .detail-subject-chip { color: #315d78; background: #e1eff7; border: 1px solid #cbdfea; }
        .detail-availability { display: inline-flex; align-items: center; gap: .4rem; color: #168078; font-size: .78rem; font-weight: 700; }
        .detail-availability span { width: 8px; height: 8px; border-radius: 50%; background: #20a464; box-shadow: 0 0 0 3px rgba(32,164,100,.13); }
        .detail-title { color: #173b56; font-size: clamp(2rem, 4vw, 3.15rem); font-weight: 800; line-height: 1.1; letter-spacing: -.045em; overflow-wrap: anywhere; text-wrap: balance; }
        .detail-description { color: #4d6978; font-size: 1.02rem; line-height: 1.8; white-space: pre-line; }
        .detail-stats { color: #3d6277; font-size: .9rem; }
        .detail-stats > span { display: inline-flex; align-items: center; }
        .detail-rating { color: #a96708; font-weight: 800; }
        .detail-rating small { color: #748393; font-weight: 500; }
        .detail-info-panel .metric { height: 100%; min-height: 74px; padding: .8rem 1rem; border: 1px solid #cfe3e8; border-radius: 14px; background: rgba(255,255,255,.78); box-shadow: 0 5px 16px rgba(45,95,111,.05); }
        .detail-info-panel .metric .small { color: #71808b !important; }
        .detail-info-panel .metric .fw-semibold { margin-top: .25rem; color: #233b4f; overflow-wrap: anywhere; }
        .detail-info-panel .detail-actions { padding-top: 1rem; border-top: 1px solid #c9e0e5; }
        .detail-info-panel .detail-actions .btn { min-height: 50px; border-radius: 13px; font-weight: 700; }
        .detail-info-panel .detail-actions .btn-success { color: #fff; background: #12634c; border-color: #12634c; }
        .detail-info-panel .detail-actions .btn-success:hover { color: #fff; background: #0d503d; border-color: #0d503d; }
        .detail-info-panel .detail-actions .btn-outline-success { color: #12634c; border-color: #8fb6a6; }
        .detail-info-panel .detail-actions .btn-outline-success:hover { color: #fff; background: #12634c; border-color: #12634c; }
        .detail-info-panel > .d-flex .btn-outline-danger { color: #a33445; border-color: #d9aeb4; background: rgba(255,255,255,.45); }
        .detail-info-panel > .d-flex .btn-outline-danger:hover { color: #fff; background: #a33445; border-color: #a33445; }
        [data-bs-theme="dark"] .detail-hero { background: linear-gradient(128deg, #163642 0%, #1b4149 48%, #203b53 100%); border-color: #31525d; }
        [data-bs-theme="dark"] .detail-title { color: #f2f7f5; }
        [data-bs-theme="dark"] .detail-description, [data-bs-theme="dark"] .detail-stats { color: #c1ced0; }
        [data-bs-theme="dark"] .detail-kicker { color: #b8f0e6; background: #204c4e; border-color: #32676a; }
        [data-bs-theme="dark"] .detail-subject-chip { color: #d0e9f3; background: #284452; border-color: #3a5b69; }
        [data-bs-theme="dark"] .detail-availability { color: #7ee6db; }
        [data-bs-theme="dark"] .detail-info-panel .metric { background: rgba(24,42,48,.82); border-color: #35494e; }
        [data-bs-theme="dark"] .detail-info-panel .metric .small { color: #aab8bb !important; }
        [data-bs-theme="dark"] .detail-info-panel .metric .fw-semibold { color: #edf4f4; }
        [data-bs-theme="dark"] .detail-info-panel .detail-actions { border-color: #35494e; }
        @media (max-width: 991.98px) { .detail-cover-card { position: static; } .detail-cover-stage { min-height: 240px; } }
        @media (max-width: 575.98px) { .detail-info-panel { border-radius: 18px; } .detail-cover-stage { min-height: 210px; } }
        .detail-community { align-items: stretch; }
        .detail-section-card, .detail-report-card { border-color: #e3eaf0 !important; border-radius: 20px !important; box-shadow: 0 10px 30px rgba(20,42,63,.055) !important; }
        .detail-community .card-body { padding: clamp(1rem, 2.5vw, 1.6rem); }
        .detail-comment { border-color: #e6ebef !important; background: linear-gradient(145deg, #fbfcfd, #f6f9f8) !important; }
        .detail-comment .comment-bubble { background: #fff; border: 1px solid #e9eef1; }
        .detail-report-card { align-self: start; position: sticky; top: 100px; }
        .detail-report-card .card-body > p { line-height: 1.65; }
        .detail-report-card .form-control, .detail-report-card .form-select,
        .detail-section-card .form-control, .detail-section-card .form-select { border-radius: 11px; }
        .detail-report-card .btn, .detail-section-card form > .btn { min-height: 44px; }
        .detail-related { border-top: 1px solid #e6ebef; }
        .detail-related-card { overflow: hidden; border: 1px solid #e5ebef !important; border-radius: 16px !important; transition: transform .18s ease, box-shadow .18s ease; }
        .detail-related-card:hover { transform: translateY(-3px); box-shadow: 0 12px 26px rgba(20,42,63,.12); }
        .detail-related-card .book-cover, .detail-related-card .ebook-cover, .detail-related-card .book-cover-image { aspect-ratio: 4 / 3; }
        [data-bs-theme="dark"] .detail-section-card, [data-bs-theme="dark"] .detail-report-card,
        [data-bs-theme="dark"] .detail-related-card { background: #111a28; border-color: #273648 !important; }
        [data-bs-theme="dark"] .detail-comment { background: #172333 !important; border-color: #2a394a !important; }
        [data-bs-theme="dark"] .detail-comment .text-dark { color: #edf4f8 !important; }
        [data-bs-theme="dark"] .detail-comment .comment-bubble { background: #111a28; border-color: #2a394a; color: #d8e2ea; }
        [data-bs-theme="dark"] .detail-related { border-color: #273648; }
        @media (max-width: 991.98px) { .detail-report-card { position: static; } }
        @media (prefers-reduced-motion: reduce) { .detail-related-card { transition: none; } .detail-related-card:hover { transform: none; } }
        .comment-card-modern { max-width: 980px; margin-inline: auto; padding: clamp(1rem,3vw,1.65rem); border-radius: 20px; border-color: #e3e9ee; box-shadow: 0 8px 26px rgba(20,42,63,.055); }
        .comment-card-modern + .comment-card-modern { margin-top: 1rem; }
        .comment-card-modern .comment-book-banner { display: flex; align-items: center; gap: .75rem; padding: .85rem 1rem !important; background: #f5f8f7; border: 1px solid #e3ece8; border-radius: 13px; }
        .comment-card-modern .comment-book-banner > div { min-width: 0; }
        .comment-card-modern .comment-bubble, [data-ebook-record] .comment-bubble { padding: 1rem 1.1rem; border-radius: 14px; background: #f7f9fa; border-color: #e7edf1; line-height: 1.7; overflow-wrap: anywhere; }
        .comment-card-modern .comment-avatar { width: 46px; height: 46px; border-radius: 15px; }
        .comment-card-modern time { font-variant-numeric: tabular-nums; }
        .comment-card-modern .comment-report-accordion > summary { list-style: none; }
        .comment-card-modern .comment-report-accordion > summary::-webkit-details-marker { display: none; }
        .reader-topbar { background: rgba(255,255,255,.97); border-color: #e1e8ef !important; }
        .reader-viewport { background: #e9edf1; }
        .reader-canvas-card { border-radius: 6px; box-shadow: 0 12px 38px rgba(22,38,54,.18) !important; }
        [data-ebook-record] > .row:first-child > .col-lg-7 > .card { overflow: hidden; }
        [data-ebook-record] > .row:first-child > .col-lg-4 > .card { position: sticky; top: 100px; border: 1px solid #e4eaf0 !important; }
        [data-ebook-record] > .row:first-child > .col-lg-4 .detail-cover { width: 100%; max-width: 430px; max-height: min(76vh, 680px); object-fit: contain; box-shadow: 0 12px 30px rgba(18,42,62,.14); }
        [data-ebook-record] > .row:first-child > .col-lg-8 h1 { font-size: clamp(1.8rem, 3vw, 2.6rem); letter-spacing: -.04em; }
        [data-ebook-record] .metric { min-height: 82px; border: 1px solid #e5ebef; border-left: 3px solid var(--school-green); }
        [data-ebook-record] .detail-actions .btn { min-height: 48px; display: inline-flex; align-items: center; justify-content: center; font-size: 1rem; }
        .empty-state, .saved-empty-state { border-radius: 20px; border: 1px solid #e4eaf0; background: linear-gradient(145deg,#fff,#f8faf9); padding: clamp(1.5rem,4vw,3rem); }
        .saved-empty-icon { box-shadow: 0 8px 20px rgba(18,99,76,.12); }
        .mobile-filter-details > .filter-toggle { display: none; }
        .mobile-filter-details > form { display: block; }
        .mobile-filter-details > .filter-toggle:focus-visible { outline: 3px solid #d99b32; outline-offset: 3px; }
        :where(a, button, input, select, textarea, iframe):focus-visible { outline: 3px solid #d99b32; outline-offset: 3px; }
        img { max-width: 100%; }
        @media (max-width: 767.98px) {
            .hero { min-height: 390px; padding-top: 3rem !important; padding-bottom: 3rem !important; }
            .hero h1 { font-size: clamp(2rem, 9vw, 3rem); }
            .library-filter-panel { padding: 1rem !important; }
            .container { --bs-gutter-x: 1.25rem; }
            .library-filter-panel { padding: .9rem !important; }
            .mobile-filter-details > .filter-toggle { display: flex; align-items: center; gap: .5rem; width: 100%; min-height: 44px; padding: 0; cursor: pointer; list-style: none; color: #172b45; font-weight: 700; text-align: left; border: 0; background: transparent; }
            .mobile-filter-details.is-collapsed > form { display: none; }
            .mobile-filter-details:not(.is-collapsed) > .filter-toggle { padding-bottom: .8rem; margin-bottom: .8rem; border-bottom: 1px solid #e5ebef; }
            .mobile-filter-details:not(.is-collapsed) > .filter-toggle .bi-chevron-down { transform: rotate(180deg); }
            .mobile-filter-details > form { display: block; }
            [data-ebook-record] > .row:first-child > .col-lg-4 > .card { position: static; }
            .ebook-card-actions { gap: .4rem !important; }
            .ebook-card-actions .btn { min-width: 34px; }
            .class-filter-btn-group { max-width: 100%; overflow-x: auto; flex-wrap: nowrap !important; padding-bottom: .35rem; }
            .class-filter-pill { white-space: nowrap; }
            .table-responsive { border-radius: 14px; }
            .comment-card-modern { padding: 1rem; }
            .comment-card-modern .comment-book-banner { align-items: flex-start; }
            .comment-card-modern .comment-book-banner > a.btn { width: 100%; }
            .comment-card-modern > .d-flex:last-child { align-items: flex-start !important; }
            .comment-card-modern .comment-report-card { width: min(100%, 360px); }
        }
        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { scroll-behavior: auto !important; animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; } }
        @media (max-width: 575.98px) {
            .brand-mark { width: 48px; height: 48px; font-size: .85rem; }
            .brand-name { font-size: .92rem; }
            .hero { text-align: left; }
            .display-5 { font-size: 2rem; }
            .search-panel .btn { width: 100%; }
            .hero-collection { border-left: 0; border-top: 1px solid rgba(255, 255, 255, .25); padding-top: 1.5rem; }
            .school-photo { min-height: 220px; max-width: 430px; margin: 0 auto; }
            .school-photo img { height: 220px; }
            .book-row-cover { width: 76px; flex-basis: 76px; }
            .study-banner { align-items: flex-start; flex-direction: column; }
            .reader-shell { padding: 0.25rem; border-radius: 8px; }
            .reader-frame { height: 85vh; border-radius: 6px; }
            .favorites-hero { padding: 1.75rem 1.25rem; }
            .library-hero-banner { padding: 1.75rem 1.25rem; }
            .comments-hero-banner { padding: 1.75rem 1.25rem; }
        }
    </style>
</head>
<body>
@unless(View::hasSection('hide_global_nav_footer'))
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="{{ route('library') }}">
            <img class="brand-mark" src="{{ asset('images/logo-perpus-sman-1-cikampek.jpeg') }}" alt="Logo Perpustakaan SMAN 1 Cikampek">
            <span class="brand-name">PERPUSTAKAAN DIGITAL<br><small class="text-muted">SMAN 1 CIKAMPEK</small></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNav" aria-controls="publicNav" aria-expanded="false" aria-label="Buka navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="publicNav">
            <div class="navbar-nav ms-auto gap-lg-2 mt-3 mt-lg-0">
                <a class="nav-link nav-pill {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                <a class="nav-link nav-pill {{ request()->routeIs('library') || request()->routeIs('classes.*') || request()->routeIs('subjects.*') || request()->routeIs('ebooks.*') ? 'active' : '' }}" href="{{ route('library') }}">Perpustakaan</a>
                <a class="nav-link nav-pill {{ request()->routeIs('comments.*') ? 'active' : '' }}" href="{{ route('comments.index') }}">Komentar Siswa</a>
                <a class="nav-link nav-pill {{ request()->routeIs('favorites') ? 'active' : '' }}" href="{{ route('favorites') }}">Favorit</a>
                <a class="nav-link nav-pill" href="{{ route('admin.login') }}">Admin</a>
            </div>
        </div>
    </div>
</nav>
@endunless

<main>@yield('content')</main>

@unless(View::hasSection('hide_global_nav_footer'))
<footer class="border-top bg-white py-4 mt-5">
    <div class="container">
        <div class="row text-center text-md-start g-3 small text-muted">
            <div class="col-md-5"><strong class="text-dark d-block mb-1">Perpustakaan Digital</strong>&copy; {{ date('Y') }} SMAN 1 Cikampek.</div>
            <div class="col-md-3"><strong class="text-dark d-block mb-1">Lokasi</strong>{{ config('library.location') }}</div>
            <div class="col-md-2"><strong class="text-dark d-block mb-1">Layanan</strong>{{ config('library.service_hours') }}</div>
            <div class="col-md-2"><strong class="text-dark d-block mb-1">Bantuan</strong>{{ config('library.contact') }}</div>
        </div>
    </div>
</footer>
@endunless

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (() => {
        const favoriteKey = 'perpus-favorites-v1';
        const recentKey = 'perpus-recent-v1';
        const read = (key) => { try { return JSON.parse(localStorage.getItem(key)) || []; } catch { return []; } };
        const write = (key, items) => localStorage.setItem(key, JSON.stringify(items));
        const bookFrom = (element) => ({
            id: element.dataset.ebookId,
            title: element.dataset.ebookTitle,
            subject: element.dataset.ebookSubject,
            className: element.dataset.ebookClass,
            url: element.dataset.ebookUrl,
            readerUrl: element.dataset.ebookReaderUrl,
            coverUrl: element.dataset.ebookCover || '',
            author: element.dataset.ebookAuthor || '',
        });
        const isFavorite = (book) => read(favoriteKey).some((item) => item.id === book.id);
        const updateFavoriteButton = (button) => {
            const saved = isFavorite(bookFrom(button));
            const isCircle = button.classList.contains('rounded-circle');
            if (isCircle) {
                button.innerHTML = saved ? '<i class="bi bi-bookmark-fill"></i>' : '<i class="bi bi-bookmark"></i>';
                button.classList.toggle('btn-danger', saved);
                button.classList.toggle('text-white', saved);
                button.classList.toggle('btn-outline-danger', !saved);
            } else {
                button.innerHTML = saved ? '<i class="bi bi-bookmark-check-fill me-1"></i> Tersimpan di favorit' : '<i class="bi bi-bookmark-heart me-1"></i> Simpan ke favorit';
                button.classList.toggle('btn-success', saved);
                button.classList.toggle('btn-outline-success', !saved);
            }
        };
        document.querySelectorAll('[data-favorite-button]').forEach((button) => {
            updateFavoriteButton(button);
            button.addEventListener('click', () => {
                const book = bookFrom(button);
                const items = read(favoriteKey);
                write(favoriteKey, isFavorite(book) ? items.filter((item) => item.id !== book.id) : [book, ...items]);
                updateFavoriteButton(button);
                updateFavoritesBadges();
            });
        });
        document.querySelectorAll('[data-ebook-record]').forEach((element) => {
            const book = bookFrom(element);
            const items = read(recentKey).filter((item) => item.id !== book.id);
            write(recentKey, [{ ...book, openedAt: new Date().toISOString() }, ...items].slice(0, 10));
            updateFavoritesBadges();
        });

        const updateFavoritesBadges = () => {
            const favCount = read(favoriteKey).length;
            const recentCount = read(recentKey).length;
            
            const setTxt = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
            setTxt('heroFavCount', favCount);
            setTxt('heroRecentCount', recentCount);
            setTxt('tabFavCount', favCount);
            setTxt('tabRecentCount', recentCount);
            setTxt('panelFavBadge', `${favCount} e-book`);
            setTxt('panelRecentBadge', `${recentCount} e-book`);
        };

        const renderSavedBooks = (target, items, emptyText, allowRemove) => {
            if (!target) return;
            target.replaceChildren();
            if (!items.length) {
                const emptyWrap = document.createElement('div');
                emptyWrap.className = 'saved-empty-state text-center';
                const icon = allowRemove ? 'bi-bookmark-heart' : 'bi-clock-history';
                const emptyTitle = allowRemove ? 'Belum Ada Buku Favorit' : 'Belum Ada Riwayat Membaca';
                const emptyDesc = allowRemove 
                    ? 'Buku pelajaran yang kamu tandai sebagai favorit akan tersimpan di sini agar mudah diakses kapan saja.'
                    : 'Buku digital yang kamu buka dan baca akan otomatis tercatat di sini.';
                emptyWrap.innerHTML = `
                    <div class="saved-empty-icon mb-3">
                        <i class="bi ${icon}"></i>
                    </div>
                    <h3 class="h6 fw-bold mb-1">${emptyTitle}</h3>
                    <p class="small text-muted mb-3 mx-auto" style="max-width: 320px;">${emptyDesc}</p>
                    <a href="{{ route('library') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                        <i class="bi bi-compass me-1"></i> Jelajahi Katalog Buku
                    </a>
                `;
                target.append(emptyWrap);
                return;
            }

            items.forEach((book) => {
                const card = document.createElement('article');
                card.className = 'saved-book-card-premium d-flex align-items-center gap-3 mb-3';

                // Thumbnail / Cover
                const thumb = document.createElement('div');
                thumb.className = 'saved-book-thumb-wrapper flex-shrink-0';
                if (book.coverUrl) {
                    thumb.innerHTML = `<img src="${book.coverUrl}" class="saved-book-thumb-img" alt="${book.title}" loading="lazy">`;
                } else {
                    thumb.innerHTML = `<div class="saved-book-thumb-fallback"><i class="bi bi-journal-text"></i></div>`;
                }

                // Info Details
                const info = document.createElement('div');
                info.className = 'flex-grow-1 min-w-0';

                const metaRow = document.createElement('div');
                metaRow.className = 'd-flex align-items-center gap-2 mb-1';
                metaRow.innerHTML = `
                    <span class="badge badge-soft">Kelas ${book.className || '-'}</span>
                    <span class="small text-muted text-truncate">${book.subject || ''}</span>
                `;

                const titleLink = document.createElement('a');
                titleLink.href = book.url;
                titleLink.className = 'saved-book-title text-decoration-none fw-bold d-block text-truncate mb-1';
                titleLink.textContent = book.title;

                const bottomMeta = document.createElement('div');
                bottomMeta.className = 'small text-muted d-flex align-items-center gap-1';
                bottomMeta.innerHTML = `<i class="bi bi-file-earmark-pdf text-danger"></i> <span>E-Book Digital</span>`;

                info.append(metaRow, titleLink, bottomMeta);

                // Action Buttons
                const actions = document.createElement('div');
                actions.className = 'd-flex align-items-center gap-2 flex-shrink-0';

                const readBtn = document.createElement('a');
                readBtn.href = book.readerUrl || book.url;
                readBtn.className = 'btn btn-sm btn-success d-inline-flex align-items-center gap-1 px-3';
                readBtn.innerHTML = `<i class="bi bi-book-half"></i> <span class="d-none d-sm-inline">Baca</span>`;
                actions.append(readBtn);

                if (allowRemove) {
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-sm btn-outline-danger d-inline-flex align-items-center justify-content-center';
                    removeBtn.title = 'Hapus dari favorit';
                    removeBtn.innerHTML = `<i class="bi bi-trash3"></i>`;
                    removeBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        write(favoriteKey, read(favoriteKey).filter((item) => item.id !== book.id));
                        card.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
                        card.style.opacity = '0';
                        card.style.transform = 'translateX(20px)';
                        setTimeout(() => {
                            renderSavedBooks(target, read(favoriteKey), emptyText, true);
                            updateFavoritesBadges();
                        }, 200);
                    });
                    actions.append(removeBtn);
                }

                card.append(thumb, info, actions);
                target.append(card);
            });
        };

        const favListEl = document.querySelector('[data-favorites-list]');
        const recentListEl = document.querySelector('[data-recent-list]');
        if (favListEl) renderSavedBooks(favListEl, read(favoriteKey), '', true);
        if (recentListEl) renderSavedBooks(recentListEl, read(recentKey), '', false);
        updateFavoritesBadges();

        // Clear Recent Books button handler
        const clearRecentBtn = document.getElementById('clearRecentBtn');
        if (clearRecentBtn) {
            clearRecentBtn.addEventListener('click', () => {
                if (!read(recentKey).length) return;
                if (confirm('Bersihkan seluruh riwayat buku yang terakhir dibuka?')) {
                    write(recentKey, []);
                    if (recentListEl) renderSavedBooks(recentListEl, [], '', false);
                    updateFavoritesBadges();
                }
            });
        }

        // Tab Switching on Favorites Page
        const favTabs = document.querySelectorAll('[data-fav-tab]');
        const panelFav = document.getElementById('panelFavorites');
        const panelRec = document.getElementById('panelRecent');
        if (favTabs.length && panelFav && panelRec) {
            favTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    favTabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    const mode = tab.getAttribute('data-fav-tab');

                    if (mode === 'favorites') {
                        panelFav.classList.remove('d-none');
                        panelFav.className = 'col-12';
                        panelRec.classList.add('d-none');
                    } else if (mode === 'recent') {
                        panelRec.classList.remove('d-none');
                        panelRec.className = 'col-12';
                        panelFav.classList.add('d-none');
                    } else {
                        panelFav.classList.remove('d-none');
                        panelFav.className = 'col-lg-6';
                        panelRec.classList.remove('d-none');
                        panelRec.className = 'col-lg-6';
                    }
                });
            });
        }

        const homeRecent = document.querySelector('[data-home-recent]');
        const homeRecentList = document.querySelector('[data-home-recent-list]');
        const recentBooks = read(recentKey).slice(0, 4);
        if (homeRecent && homeRecentList && recentBooks.length) {
            homeRecent.hidden = false;
            homeRecentList.replaceChildren();
            recentBooks.forEach((book) => {
                const column = document.createElement('div');
                column.className = 'col-12 col-sm-6 col-lg-3';
                const card = document.createElement('article');
                card.className = 'recent-dashboard-card h-100 d-flex flex-column';
                
                const thumbPart = document.createElement('div');
                thumbPart.className = 'p-3 pb-2 d-flex gap-3 align-items-center';
                const thumbImg = book.coverUrl 
                    ? `<img src="${book.coverUrl}" class="rounded-3 shadow-sm flex-shrink-0" style="width: 48px; height: 64px; object-fit: cover;" alt="${book.title}" loading="lazy">`
                    : `<div class="rounded-3 shadow-sm flex-shrink-0 d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 64px; background: linear-gradient(135deg, #0f6b4f, #1956a3); font-size: 1.25rem;"><i class="bi bi-book"></i></div>`;
                
                thumbPart.innerHTML = `
                    ${thumbImg}
                    <div class="min-w-0">
                        <span class="badge badge-soft mb-1" style="font-size: 0.72rem;">Kelas ${book.className || '-'}</span>
                        <div class="small text-muted text-truncate" style="font-size: 0.75rem;">${book.subject || 'E-Book Digital'}</div>
                    </div>
                `;

                const bodyPart = document.createElement('div');
                bodyPart.className = 'p-3 pt-0 d-flex flex-column flex-grow-1';
                bodyPart.innerHTML = `
                    <h3 class="h6 fw-bold mb-2 text-truncate" title="${book.title}">
                        <a href="${book.url}" class="text-decoration-none text-dark">${book.title}</a>
                    </h3>
                    <div class="d-flex align-items-center gap-1 text-success fw-semibold small mb-3" style="font-size: 0.75rem;">
                        <i class="bi bi-clock-history"></i> Terakhir dibuka
                    </div>
                    <a href="${book.readerUrl || book.url}" class="btn btn-sm btn-success mt-auto rounded-pill fw-semibold d-flex align-items-center justify-content-center gap-1">
                        <i class="bi bi-book-half"></i> <span>Lanjut Baca</span>
                    </a>
                `;

                card.append(thumbPart, bodyPart);
                column.append(card);
                homeRecentList.append(column);
            });
        }
        document.querySelectorAll('[data-smart-search]').forEach((input) => {
            const panel = input.parentElement.querySelector('[data-search-suggestions]');
            let requestTimer;
            let activeIndex = -1;
            let activeRequest;
            const clear = () => { if (panel) { panel.replaceChildren(); panel.hidden = true; } activeIndex = -1; input.setAttribute('aria-expanded', 'false'); input.removeAttribute('aria-activedescendant'); };
            const links = () => [...panel.querySelectorAll('.search-suggestion')];
            const setActive = (index) => {
                const items = links();
                if (!items.length) return;
                activeIndex = (index + items.length) % items.length;
                items.forEach((item, itemIndex) => item.classList.toggle('active', itemIndex === activeIndex));
                input.setAttribute('aria-activedescendant', items[activeIndex].id);
            };
            input.addEventListener('input', () => {
                clearTimeout(requestTimer);
                activeRequest?.abort();
                const query = input.value.trim();
                if (query.length < 2) return clear();
                requestTimer = setTimeout(async () => {
                    try {
                        activeRequest = new AbortController();
                        const response = await fetch(`{{ route('search.suggestions') }}?q=${encodeURIComponent(query)}`, { headers: { Accept: 'application/json' }, signal: activeRequest.signal });
                        const payload = await response.json();
                        // Support cached responses from the previous endpoint format during an update.
                        const suggestions = Array.isArray(payload) ? payload : (payload.items || []);
                        clear();
                        if (suggestions.length) {
                            const heading = document.createElement('div'); heading.className = 'search-suggestion-heading'; heading.textContent = 'Rekomendasi e-book';
                            panel.append(heading);
                        }
                        suggestions.forEach((item, index) => {
                            const link = document.createElement('a'); 
                            link.href = item.url; 
                            link.className = 'search-suggestion';
                            link.id = `search-suggestion-${index}`; 
                            link.setAttribute('role', 'option');

                            const thumbHtml = item.cover_url 
                                ? `<img src="${item.cover_url}" class="rounded shadow-sm flex-shrink-0" style="width:36px;height:48px;object-fit:cover;" alt="Cover">`
                                : `<div class="rounded shadow-sm flex-shrink-0 d-flex align-items-center justify-content-center bg-light text-muted" style="width:36px;height:48px;font-size:1.1rem;"><i class="bi bi-book"></i></div>`;

                            link.innerHTML = `
                                ${thumbHtml}
                                <div class="flex-grow-1 min-w-0">
                                    <strong class="d-block small text-truncate mb-0">${item.title}</strong>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle flex-shrink-0" style="font-size:0.68rem;">Kelas ${item.class_name || '-'}</span>
                                        <span class="small text-muted text-truncate" style="font-size:0.75rem;">${item.author || item.subject_name || ''}</span>
                                    </div>
                                </div>
                                <i class="bi bi-arrow-right text-muted opacity-50 small ms-auto flex-shrink-0"></i>
                            `;
                            panel.append(link);
                        });
                        if (!Array.isArray(payload) && payload.correction) {
                            const correction = document.createElement('a'); correction.href = payload.correction.url; correction.className = 'search-suggestion fw-semibold';
                            correction.id = `search-suggestion-${suggestions.length}`; correction.setAttribute('role', 'option'); correction.textContent = payload.correction.label;
                            panel.append(correction);
                        }
                        if (suggestions.length) {
                            const allResults = document.createElement('a'); allResults.className = 'search-all-results';
                            allResults.href = `{{ route('library') }}?q=${encodeURIComponent(query)}`;
                            allResults.textContent = `Lihat semua hasil untuk “${query}”`;
                            panel.append(allResults);
                        }
                        panel.hidden = !panel.children.length;
                        input.setAttribute('aria-expanded', panel.hidden ? 'false' : 'true');
                    } catch (error) { if (error.name !== 'AbortError') clear(); }
                }, 220);
            });
            input.addEventListener('keydown', (event) => {
                if (panel.hidden) return;
                if (event.key === 'ArrowDown') { event.preventDefault(); setActive(activeIndex + 1); }
                if (event.key === 'ArrowUp') { event.preventDefault(); setActive(activeIndex - 1); }
                if (event.key === 'Escape') { clear(); }
                if (event.key === 'Enter' && activeIndex >= 0) { event.preventDefault(); links()[activeIndex]?.click(); }
            });
            // Keep the list alive while a mouse or touch interaction selects a suggestion.
            // Without this, the input blur can remove the item before its link is followed.
            panel?.addEventListener('pointerdown', (event) => {
                const link = event.target.closest('.search-suggestion, .search-all-results');
                if (!link) return;
                event.preventDefault();
                window.location.assign(link.href);
            });
            input.addEventListener('blur', () => setTimeout(clear, 160));

            // Voice search: uses the browser's built-in speech recognition (HTTPS required).
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!input.dataset.voiceSearchReady) {
                input.dataset.voiceSearchReady = 'true';
                const host = input.closest('.input-group') || input.parentElement;
                host.classList.add('voice-search-host');
                input.classList.add('voice-search-input');
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'voice-search-button';
                button.setAttribute('aria-label', 'Cari menggunakan suara');
                button.title = 'Cari menggunakan suara';
                button.innerHTML = '<i class="bi bi-mic-fill" aria-hidden="true"></i>';
                host.append(button);

                if (!SpeechRecognition) {
                    button.disabled = true;
                    button.title = 'Pencarian suara tidak didukung browser ini. Coba Chrome atau Edge.';
                    button.setAttribute('aria-label', button.title);
                    button.classList.add('is-unavailable');
                } else {

                const recognition = new SpeechRecognition();
                recognition.lang = 'id-ID';
                recognition.interimResults = false;
                recognition.maxAlternatives = 1;
                let listening = false;
                const stopListening = () => {
                    listening = false;
                    button.classList.remove('is-listening');
                    button.setAttribute('aria-label', 'Cari menggunakan suara');
                    button.title = 'Cari menggunakan suara';
                };
                recognition.addEventListener('start', () => {
                    listening = true;
                    button.classList.add('is-listening');
                    button.setAttribute('aria-label', 'Berhenti merekam suara');
                    button.title = 'Mendengarkan… klik untuk berhenti';
                });
                recognition.addEventListener('end', stopListening);
                recognition.addEventListener('error', (event) => {
                    stopListening();
                    const messages = {
                        'not-allowed': 'Izin mikrofon ditolak. Aktifkan izin mikrofon untuk situs ini.',
                        'no-speech': 'Suara belum terdengar. Silakan coba lagi.',
                        'network': 'Pengenalan suara memerlukan koneksi internet.'
                    };
                    if (event.error !== 'aborted') window.alert(messages[event.error] || 'Pencarian suara gagal. Silakan coba lagi.');
                });
                recognition.addEventListener('result', (event) => {
                    const transcript = event.results?.[0]?.[0]?.transcript?.trim();
                    if (!transcript) return;
                    input.value = transcript;
                    input.dispatchEvent(new Event('input', { bubbles: true }));
                    input.form?.requestSubmit();
                });
                button.addEventListener('click', () => {
                    if (listening) recognition.stop();
                    else {
                        input.focus();
                        try { recognition.start(); }
                        catch (error) { stopListening(); }
                    }
                });
                }
            }
        });

        // Global Keyboard Shortcut: Ctrl+K or '/' to focus search
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                const searchInput = document.querySelector('[data-smart-search]');
                if (searchInput) {
                    searchInput.focus();
                    searchInput.select();
                }
            } else if (e.key === '/' && !['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) {
                e.preventDefault();
                const searchInput = document.querySelector('[data-smart-search]');
                if (searchInput) {
                    searchInput.focus();
                    searchInput.select();
                }
            }
        });
    })();
</script>
<script>
    try {
        localStorage.removeItem('theme');
        document.documentElement.setAttribute('data-bs-theme', 'light');
    } catch (e) {}
</script>
<script>if ('serviceWorker' in navigator) navigator.serviceWorker.register('{{ asset('sw.js') }}').catch(() => {});</script>
@stack('scripts')
</body>
</html>
