<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Perpustakaan Digital SMAN 1 Cikampek')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        body { background: #f6f8fb; color: var(--school-ink); font-family: 'DM Sans', sans-serif; }
        h1, h2, h3, .brand-name { font-family: 'Plus Jakarta Sans', sans-serif; }
        a { color: var(--school-blue); }
        .navbar { box-shadow: 0 1px 0 rgba(16, 35, 63, .06); }
        .brand-mark {
            width: 56px; height: 56px; border-radius: 50%; object-fit: cover;
            box-shadow: 0 5px 14px rgba(15, 35, 63, .18);
        }
        .brand-name { line-height: 1.05; }
        .nav-pill { border-radius: 10px; color: var(--school-ink); padding: .5rem .9rem; font-weight: 600; }
        .nav-pill:hover, .nav-pill.active { background: var(--school-soft); color: var(--school-green); }
        .hero { background: radial-gradient(circle at 85% 22%, #2aa782 0, transparent 23%), linear-gradient(120deg, #0d5d46, #123f72); color: #fff; overflow: hidden; position: relative; }
        .hero::after { content: ''; position: absolute; width: 420px; height: 420px; border: 1px solid rgba(255,255,255,.13); border-radius: 50%; right: -120px; bottom: -260px; }
        .hero-panel { background: rgba(255, 255, 255, .14); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, .26); border-radius: 16px; }
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
        .search-panel { background: #fff; border: 1px solid var(--school-line); border-radius: 16px; padding: 1rem; }
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
        .hero-visual { min-height: 260px; position: relative; }
        .hero-book { position: absolute; width: 152px; aspect-ratio: 3/4; border-radius: 12px; box-shadow: 0 22px 32px rgba(0,0,0,.22); padding: 1.1rem; display: flex; flex-direction: column; justify-content: space-between; }
        .hero-book-main { background: #fff8e9; color: #123f72; left: 50%; transform: translateX(-52%) rotate(5deg); top: 7px; }
        .hero-book-left { background: #156f55; color: #fff; left: 7%; top: 54px; transform: rotate(-12deg); }
        .hero-book-right { background: #2364b2; color: #fff; right: 4%; top: 57px; transform: rotate(13deg); }
        .hero-book small { font-size: .62rem; letter-spacing: .08em; font-weight: 700; }
        .hero-book strong { font-family: 'Plus Jakarta Sans', sans-serif; line-height: 1.2; font-size: 1.1rem; }
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
        .subject-icon { font-size: 1.3rem; }
        @media (max-width: 575.98px) {
            .brand-mark { width: 48px; height: 48px; font-size: .85rem; }
            .brand-name { font-size: .92rem; }
            .hero { text-align: left; }
            .display-5 { font-size: 2rem; }
            .search-panel .btn { width: 100%; }
            .hero-collection { border-left: 0; border-top: 1px solid rgba(255, 255, 255, .25); padding-top: 1.5rem; }
            .hero-visual { min-height: 220px; max-width: 330px; margin: 0 auto; }
            .hero-book { width: 128px; }
            .book-row-cover { width: 76px; flex-basis: 76px; }
            .study-banner { align-items: flex-start; flex-direction: column; }
        }
    </style>
</head>
<body>
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
                <a class="nav-link nav-pill {{ request()->routeIs('favorites') ? 'active' : '' }}" href="{{ route('favorites') }}">Favorit</a>
                <a class="nav-link nav-pill" href="{{ route('admin.login') }}">Admin</a>
            </div>
        </div>
    </div>
</nav>

<main>@yield('content')</main>

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
        });
        const isFavorite = (book) => read(favoriteKey).some((item) => item.id === book.id);
        const updateFavoriteButton = (button) => {
            const saved = isFavorite(bookFrom(button));
            button.textContent = saved ? '✓ Tersimpan di favorit' : '♡ Simpan ke favorit';
            button.classList.toggle('btn-success', saved);
            button.classList.toggle('btn-outline-success', !saved);
        };
        document.querySelectorAll('[data-favorite-button]').forEach((button) => {
            updateFavoriteButton(button);
            button.addEventListener('click', () => {
                const book = bookFrom(button);
                const items = read(favoriteKey);
                write(favoriteKey, isFavorite(book) ? items.filter((item) => item.id !== book.id) : [book, ...items]);
                updateFavoriteButton(button);
            });
        });
        document.querySelectorAll('[data-ebook-record]').forEach((element) => {
            const book = bookFrom(element);
            const items = read(recentKey).filter((item) => item.id !== book.id);
            write(recentKey, [{ ...book, openedAt: new Date().toISOString() }, ...items].slice(0, 8));
        });
        const renderSavedBooks = (target, items, emptyText, allowRemove) => {
            if (!target) return;
            target.replaceChildren();
            if (!items.length) { target.textContent = emptyText; target.classList.add('text-muted'); return; }
            target.classList.remove('text-muted');
            items.forEach((book) => {
                const card = document.createElement('article'); card.className = 'saved-book-card';
                const title = document.createElement('a'); title.href = book.url; title.className = 'fw-semibold text-decoration-none d-block mb-1'; title.textContent = book.title;
                const meta = document.createElement('p'); meta.className = 'small text-muted mb-3'; meta.textContent = `Kelas ${book.className} / ${book.subject}`;
                const open = document.createElement('a'); open.href = book.readerUrl || book.url; open.className = 'btn btn-sm btn-success'; open.textContent = 'Baca';
                card.append(title, meta, open);
                if (allowRemove) { const remove = document.createElement('button'); remove.type = 'button'; remove.className = 'btn btn-sm btn-link text-danger ms-2'; remove.textContent = 'Hapus'; remove.addEventListener('click', () => { write(favoriteKey, read(favoriteKey).filter((item) => item.id !== book.id)); renderSavedBooks(target, read(favoriteKey), emptyText, true); }); card.append(remove); }
                target.append(card);
            });
        };
        renderSavedBooks(document.querySelector('[data-favorites-list]'), read(favoriteKey), 'Belum ada buku favorit. Simpan buku dari halaman detail e-book.', true);
        renderSavedBooks(document.querySelector('[data-recent-list]'), read(recentKey), 'Belum ada buku yang dibuka pada perangkat ini.', false);
        const homeRecent = document.querySelector('[data-home-recent]');
        const homeRecentList = document.querySelector('[data-home-recent-list]');
        const recentBooks = read(recentKey).slice(0, 4);
        if (homeRecent && homeRecentList && recentBooks.length) {
            homeRecent.hidden = false;
            recentBooks.forEach((book) => {
                const column = document.createElement('div'); column.className = 'col-12 col-sm-6 col-lg-3';
                const card = document.createElement('article'); card.className = 'saved-book-card h-100 d-flex flex-column';
                const kicker = document.createElement('span'); kicker.className = 'badge badge-soft align-self-start mb-2'; kicker.textContent = `Kelas ${book.className}`;
                const title = document.createElement('a'); title.href = book.url; title.className = 'fw-semibold text-decoration-none mb-1'; title.textContent = book.title;
                const meta = document.createElement('p'); meta.className = 'small text-muted mb-3'; meta.textContent = book.subject;
                const open = document.createElement('a'); open.href = book.readerUrl || book.url; open.className = 'btn btn-sm btn-success mt-auto'; open.textContent = 'Lanjut baca';
                card.append(kicker, title, meta, open); column.append(card); homeRecentList.append(column);
            });
        }
    })();
</script>
@stack('scripts')
</body>
</html>
