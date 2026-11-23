<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Admin — Sanggar Seni Cakra Aji</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body class="admin-login-body">
    <main class="admin-login">
        <section class="admin-login__intro">
            <div class="admin-login__brand">
                <img src="{{ asset('assets/images/logo-navbar.png') }}" alt="Logo Sanggar Seni Cakra Aji">
                <div>
                    <strong>Sanggar Seni</strong>
                    <span>Cakra Aji</span>
                    <small>Est. 2020</small>
                </div>
            </div>

            <h1 class="admin-login__heading">Ruang kelola<br>website sanggar.</h1>

            <p class="admin-login__lead">
                Kelola pendaftar siswa, booking acara, dokumentasi kegiatan, program, dan
                pengaturan WhatsApp dari satu panel admin.
            </p>
        </section>

        <section class="admin-login__panel">
            <div class="admin-login__card">
                <div class="admin-login__card-head">
                    <span>Masuk Admin</span>
                    <h2>Selamat datang kembali</h2>
                </div>

                @if ($errors->any())
                    <div class="admin-alert admin-alert--error" role="alert">
                        <x-admin.icon name="x" />
                        <div>
                            <strong>Login gagal.</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="admin-alert admin-alert--success" role="status">
                        <x-admin.icon name="check" />
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('login.proses') }}" method="POST" class="admin-login__form">
                    @csrf

                    <div class="admin-field">
                        <label for="email">Email admin</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="admin@email.com"
                            autocomplete="username"
                            required
                            autofocus
                            class="admin-input"
                        >
                    </div>

                    <div class="admin-field">
                        <label for="password">Kata sandi</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Kata sandi"
                            autocomplete="current-password"
                            required
                            class="admin-input"
                        >
                    </div>

                    <div class="admin-login__row">
                        <label>
                            <input type="checkbox" name="remember" value="1">
                            <span>Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="admin-btn admin-btn--primary admin-btn--block">
                        Masuk ke panel
                    </button>
                </form>

                <a href="{{ url('/') }}" class="admin-login__back">← Kembali ke website</a>
            </div>
        </section>
    </main>
</body>
</html>
