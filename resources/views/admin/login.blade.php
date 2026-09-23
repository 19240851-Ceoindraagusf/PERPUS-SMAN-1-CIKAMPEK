<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --school-green: #0f6b4f;
            --school-blue: #1956a3;
            --school-ink: #10233f;
            --school-line: #d8e2ee;
            --school-soft: #eef6f3;
        }
        body {
            min-height: 100vh;
            background:
                linear-gradient(135deg, rgba(15, 107, 79, .92), rgba(25, 86, 163, .88)),
                url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1600&q=80') center/cover;
            color: var(--school-ink);
        }
        .login-shell { min-height: 100vh; padding: 2rem 0; }
        .school-panel {
            color: #fff;
            max-width: 520px;
        }
        .brand-mark {
            width: 58px;
            height: 58px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .16);
            border: 1px solid rgba(255, 255, 255, .26);
            display: grid;
            place-items: center;
            font-weight: 800;
            letter-spacing: 0;
        }
        .login-card {
            width: 100%;
            max-width: 430px;
            border: 1px solid rgba(255, 255, 255, .7);
            border-radius: 8px;
            box-shadow: 0 24px 60px rgba(15, 35, 63, .28);
        }
        .form-control, .form-check-input, .btn { border-radius: 8px; }
        .form-control {
            border-color: var(--school-line);
            padding: .75rem .9rem;
        }
        .form-control:focus {
            border-color: var(--school-green);
            box-shadow: 0 0 0 .2rem rgba(15, 107, 79, .15);
        }
        .btn-success {
            background: var(--school-green);
            border-color: var(--school-green);
            padding: .75rem 1rem;
            font-weight: 700;
        }
        .login-badge {
            background: var(--school-soft);
            color: var(--school-green);
            border-radius: 999px;
            padding: .35rem .75rem;
            font-size: .75rem;
            font-weight: 700;
        }
        @media (max-width: 991.98px) {
            .school-panel { max-width: 430px; }
        }
    </style>
</head>
<body>
<main class="container login-shell d-flex align-items-center">
    <div class="row align-items-center justify-content-between g-4 w-100">
        <div class="col-lg-6">
            <div class="school-panel">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="brand-mark">S1C</div>
                    <div>
                        <div class="fw-bold text-uppercase">Perpustakaan Digital</div>
                        <div class="opacity-75">SMAN 1 Cikampek</div>
                    </div>
                </div>
                <h1 class="display-6 fw-bold mb-3">Portal admin perpustakaan sekolah.</h1>
                <p class="lead opacity-75 mb-0">Kelola kelas, mata pelajaran, e-book, dan riwayat akses siswa dari satu ruang kerja yang rapi.</p>
            </div>
        </div>
        <div class="col-lg-5 d-flex justify-content-lg-end">
            <div class="card login-card">
                <div class="card-body p-4 p-md-5">
            <span class="login-badge d-inline-block mb-3">AKSES ADMIN SEKOLAH</span>
            <h2 class="h4 fw-bold mb-1">Masuk ke Dashboard</h2>
            <p class="text-muted mb-4">Gunakan akun admin perpustakaan.</p>
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('admin.login.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" id="password" name="password" type="password" required>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
                <button class="btn btn-success w-100" type="submit">Login</button>
            </form>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
