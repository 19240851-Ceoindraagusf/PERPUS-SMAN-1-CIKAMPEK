<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin Perpustakaan – SMAN 1 Cikampek</title>
    <meta name="description" content="Halaman login admin sistem perpustakaan digital SMAN 1 Cikampek.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* ===== VARIABEL WARNA ===== */
        :root {
            --green:   #0f6b4f;
            --green2:  #16a167;
            --blue:    #1956a3;
            --blue2:   #2876e8;
            --dark:    #080e1a;
            --card-bg: rgba(255,255,255,0.10);
            --border:  rgba(255,255,255,0.22);
            --text:    #e8f0f7;
            --muted:   #94afc5;
        }

        /* ===== BODY ===== */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background:
                linear-gradient(135deg, rgba(15,107,79,.88) 0%, rgba(25,86,163,.92) 100%),
                url('{{ asset("images/gedung-sman-1-cikampek.png") }}') center/cover no-repeat fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* ===== PARTIKEL LATAR (lingkaran blur) ===== */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
        }
        body::before {
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(15,193,113,0.18) 0%, transparent 70%);
            top: -180px; left: -180px;
            animation: blobMove1 12s ease-in-out infinite alternate;
        }
        body::after {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(40,118,232,0.18) 0%, transparent 70%);
            bottom: -150px; right: -150px;
            animation: blobMove2 10s ease-in-out infinite alternate;
        }
        @keyframes blobMove1 {
            0%   { transform: translate(0,0) scale(1); }
            100% { transform: translate(80px,60px) scale(1.2); }
        }
        @keyframes blobMove2 {
            0%   { transform: translate(0,0) scale(1); }
            100% { transform: translate(-60px,-80px) scale(1.15); }
        }

        /* ===== LAYOUT ===== */
        .login-shell {
            width: 100%;
            max-width: 1100px;
            padding: 2rem 1.5rem;
            position: relative;
            z-index: 1;
        }

        /* ===== PANEL KIRI (info sekolah) ===== */
        .school-panel { max-width: 520px; }
        .school-panel .brand-mark {
            width: 70px; height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.35);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        .school-panel h1 {
            font-size: 2.4rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.5px;
        }
        .school-panel .lead {
            font-size: 1rem;
            color: rgba(255,255,255,0.72);
        }
        .feature-list {
            list-style: none;
            padding: 0; margin: 0;
        }
        .feature-list li {
            display: flex; align-items: center; gap: 0.6rem;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.75);
            margin-bottom: 0.55rem;
        }
        .feature-list li i {
            color: #34d89a;
            font-size: 1rem;
        }

        /* ===== KARTU LOGIN ===== */
        .login-card {
            width: 100%;
            max-width: 440px;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow:
                0 8px 40px rgba(0,0,0,0.45),
                inset 0 1px 0 rgba(255,255,255,0.15);
            padding: 2.5rem;
            opacity: 0;
            animation: popIn 0.75s cubic-bezier(0.22,1,0.36,1) 0.1s forwards;
        }
        @keyframes popIn {
            0%   { opacity: 0; transform: translateY(40px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0)   scale(1); }
        }

        /* ===== BADGE ===== */
        .login-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: rgba(52,216,154,0.18);
            color: #34d89a;
            border: 1px solid rgba(52,216,154,0.35);
            border-radius: 999px;
            padding: 0.3rem 0.85rem;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        /* ===== JUDUL & SUBJUDUL ===== */
        .login-card h2 {
            font-size: 1.55rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.25rem;
        }
        .login-card .sub-title {
            font-size: 0.88rem;
            color: var(--muted);
            margin-bottom: 1.6rem;
        }

        /* ===== FORM LABEL ===== */
        .form-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: rgba(255,255,255,0.75);
            margin-bottom: 0.4rem;
        }

        /* ===== FORM CONTROL ===== */
        .form-control {
            background: rgba(255,255,255,0.08) !important;
            border: 1px solid rgba(255,255,255,0.22) !important;
            border-radius: 10px !important;
            color: #fff !important;
            padding: 0.75rem 1rem !important;
            font-size: 0.92rem;
            transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.35) !important; }
        .form-control:focus {
            background: rgba(255,255,255,0.14) !important;
            border-color: var(--green2) !important;
            box-shadow: 0 0 0 3px rgba(22,161,103,0.22) !important;
            outline: none;
        }
        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #1a3040 inset !important;
            -webkit-text-fill-color: #fff !important;
        }

        .captcha-row { display: flex; gap: .65rem; align-items: center; }
        .captcha-image-wrap { min-width: 0; flex: 1; height: 64px; display: flex; align-items: center; justify-content: center; border: 1px solid #c4b5fd; border-radius: 12px; background: rgba(255,255,255,.96); overflow: hidden; }
        .captcha-image-wrap img { width: 100%; height: 100%; object-fit: contain; }
        .captcha-refresh { width: 56px; height: 56px; flex: 0 0 56px; border: 1px solid #c4b5fd; border-radius: 12px; color: #6d28d9; background: rgba(255,255,255,.12); font-size: 1.2rem; }
        .captcha-refresh:hover { background: rgba(196,181,253,.2); }
        .captcha-input { text-align: center; letter-spacing: .25em; text-transform: uppercase; font-size: 1rem !important; }

        /* ===== PASSWORD WRAPPER ===== */
        .pwd-wrapper {
            position: relative;
        }
        .pwd-wrapper .form-control {
            padding-right: 3rem !important;
        }
        .eye-toggle {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--muted);
            font-size: 1.1rem;
            line-height: 1;
            transition: color 0.2s;
            z-index: 5;
            border: none;
            background: transparent;
            padding: 0;
        }
        .eye-toggle:hover { color: var(--green2); }

        /* ===== FORM CHECK ===== */
        .form-check-input {
            background-color: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.3);
        }
        .form-check-input:checked {
            background-color: var(--green);
            border-color: var(--green);
        }
        .form-check-label {
            font-size: 0.84rem;
            color: var(--muted);
        }

        /* ===== TOMBOL LOGIN ===== */
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--green) 0%, var(--green2) 100%);
            color: #fff;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform 0.18s, box-shadow 0.18s;
            box-shadow: 0 4px 20px rgba(15,107,79,0.45);
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(15,107,79,0.55);
        }
        .btn-login:active { transform: translateY(0); }
        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.18) 50%, transparent 100%);
            transform: translateX(-100%);
            transition: transform 0.55s;
        }
        .btn-login:hover::after { transform: translateX(100%); }

        /* ===== ALERT ERROR ===== */
        .alert-danger {
            background: rgba(220,53,69,0.18);
            border: 1px solid rgba(220,53,69,0.4);
            color: #f8a0a8;
            border-radius: 10px;
            font-size: 0.84rem;
            padding: 0.7rem 1rem;
        }

        /* ===== DIVIDER ===== */
        .divider {
            border-color: rgba(255,255,255,0.12);
            margin: 1.4rem 0;
        }

        /* ===== FOOTER TEXT ===== */
        .footer-text {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.35);
            text-align: center;
            margin-top: 1.2rem;
        }

        /* ===== PANEL ANIMASI MASUK ===== */
        .school-panel {
            opacity: 0;
            animation: slideLeft 0.7s ease-out 0.05s forwards;
        }
        @keyframes slideLeft {
            0%   { opacity: 0; transform: translateX(-30px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991.98px) {
            .school-panel { max-width: 100%; margin-bottom: 1.5rem; }
            .login-card { max-width: 100%; }
            .school-panel h1 { font-size: 1.85rem; }
        }
    </style>
</head>
<body>

<div class="login-shell d-flex align-items-center justify-content-between flex-wrap gap-4 mx-auto">

    {{-- ===== PANEL KIRI ===== --}}
    <div class="school-panel">
        {{-- Logo & Nama Sekolah --}}
        <div class="d-flex align-items-center gap-3 mb-4">
            <img class="brand-mark"
                 src="{{ asset('images/logo-perpus-sman-1-cikampek.jpeg') }}"
                 alt="Logo Perpustakaan SMAN 1 Cikampek">
            <div>
                <div style="font-weight:700;font-size:0.95rem;text-transform:uppercase;letter-spacing:0.04em;">
                    Perpustakaan Digital
                </div>
                <div style="font-size:0.82rem;color:rgba(255,255,255,0.65);">SMAN 1 Cikampek</div>
            </div>
        </div>

        <h1 class="mb-3">Portal Admin<br>Perpustakaan Sekolah</h1>
        <p class="lead mb-4">Kelola koleksi e-book, kelas, mata pelajaran, dan riwayat akses siswa dari satu ruang kerja yang rapi.</p>

        <ul class="feature-list">
            <li><i class="bi bi-check-circle-fill"></i> Manajemen e-book &amp; kategori</li>
            <li><i class="bi bi-check-circle-fill"></i> Laporan statistik akses</li>
            <li><i class="bi bi-check-circle-fill"></i> Manajemen kelas &amp; mata pelajaran</li>
        </ul>
    </div>

    {{-- ===== KARTU LOGIN ===== --}}
    <div class="login-card">
        <span class="login-badge">
            <i class="bi bi-shield-lock-fill"></i> Akses Admin Sekolah
        </span>

        <h2>Masuk ke Dashboard</h2>
        <p class="sub-title">Gunakan akun admin perpustakaan Anda.</p>

        @if($errors->any())
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.store') }}" id="loginForm">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label" for="email">
                    <i class="bi bi-envelope me-1"></i>Email Admin
                </label>
                <input
                    class="form-control"
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@perpus.sch.id"
                    required
                    autofocus>
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label class="form-label" for="password">
                    <i class="bi bi-lock me-1"></i>Password
                </label>
                <div class="pwd-wrapper">
                    <input
                        class="form-control"
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Masukkan password"
                        required>
                    <button
                        type="button"
                        class="eye-toggle"
                        id="eyeToggleBtn"
                        title="Tampilkan / sembunyikan password"
                        onclick="togglePassword()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            {{-- Kode keamanan --}}
            <div class="mb-4">
                <label class="form-label" for="captcha"><i class="bi bi-shield-check me-1"></i>Kode Keamanan</label>
                <div class="captcha-row mb-2">
                    <div class="captcha-image-wrap">
                        <img id="captchaImage" src="data:image/svg+xml;base64,{{ base64_encode($captchaSvg) }}" alt="Kode keamanan tiga karakter">
                    </div>
                    <button class="captcha-refresh" id="captchaRefresh" type="button" aria-label="Muat kode keamanan baru" title="Muat kode baru">
                        <i class="bi bi-arrow-repeat"></i>
                    </button>
                </div>
                <input class="form-control captcha-input" id="captcha" name="captcha" type="text" minlength="3" maxlength="3" pattern="[A-Za-z]{3}" autocomplete="off" placeholder="Masukkan 3 karakter di atas" required>
            </div>

            {{-- Ingat Saya --}}
            <div class="form-check mb-4">
                <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1">
                <label class="form-check-label" for="remember">Ingat saya di perangkat ini</label>
            </div>

            {{-- Tombol Login --}}
            <button class="btn-login" type="submit" id="submitBtn">
                <span id="btnText"><i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang</span>
            </button>
        </form>

        <hr class="divider">
        <p class="footer-text">
            &copy; {{ date('Y') }} Perpustakaan Digital SMAN 1 Cikampek. All rights reserved.
        </p>
    </div>

</div>

<script>
    document.getElementById('captchaRefresh').addEventListener('click', function () {
        const image = document.getElementById('captchaImage');
        image.src = @json(route('admin.login.captcha')) + '?_=' + Date.now();
        document.getElementById('captcha').value = '';
    });

    // ===== TOGGLE PASSWORD (EYE) =====
    function togglePassword() {
        const pwdInput = document.getElementById('password');
        const eyeIcon  = document.getElementById('eyeIcon');

        if (pwdInput.type === 'password') {
            pwdInput.type = 'text';
            eyeIcon.className = 'bi bi-eye-slash';
        } else {
            pwdInput.type = 'password';
            eyeIcon.className = 'bi bi-eye';
        }
    }

    // ===== LOADING STATE SAAT SUBMIT =====
    document.getElementById('loginForm').addEventListener('submit', function () {
        const btn  = document.getElementById('submitBtn');
        const text = document.getElementById('btnText');
        btn.disabled = true;
        text.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...';
    });
</script>

</body>
</html>
