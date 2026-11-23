<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') — Sanggar Seni Cakra Aji</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body class="admin-body">
    <div class="admin-shell">
        @include('components.navbar-admin')

        <div class="admin-overlay" data-admin-overlay></div>

        <div class="admin-main">
            <header class="admin-topbar">
                <div class="admin-topbar__left">
                    <button type="button" class="admin-menu-btn" data-admin-menu-open aria-label="Buka menu">
                        <x-admin.icon name="menu" />
                    </button>

                    <div>
                        <span class="admin-topbar__eyebrow">@yield('admin_eyebrow', 'Panel Admin')</span>
                        <h1 class="admin-topbar__title">@yield('admin_title', 'Dashboard')</h1>
                    </div>
                </div>

                <div class="admin-topbar__right">
                    <a href="{{ url('/') }}" target="_blank" rel="noopener noreferrer" class="admin-topbar__website">
                        <x-admin.icon name="external" />
                        <span>Lihat website</span>
                    </a>

                    <div class="admin-user">
                        <span class="admin-user__avatar">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="admin-user__meta">
                            <strong>{{ auth()->user()->name }}</strong>
                            <small>Admin</small>
                        </span>
                    </div>
                </div>
            </header>

            <main class="admin-content">
                <x-admin.flash />
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('assets/js/admin.js') }}" defer></script>
    @stack('scripts')
</body>
</html>