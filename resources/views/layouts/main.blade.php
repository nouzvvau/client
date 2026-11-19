<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Sanggar Seni Cakra Aji')</title>
  <meta name="description" content="@yield('description', 'Sanggar Seni Cakra Aji, ruang pelestarian musik tradisi dan kontemporer.')">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700;800&display=swap" rel="stylesheet">
  @stack('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/design-system.css') }}">
</head>
<body data-page="@yield('page')">
  @if ($showSkipLink ?? true)
    <a class="skip-link" href="#main-content">Langsung ke konten</a>
  @endif

  @include($navbarView ?? 'components.navbar', ['activeNav' => trim($__env->yieldContent('activeNav')) ?: null])

  <main id="main-content">
    @yield('content')
  </main>

  @include($footerView ?? 'components.footer')

  <script src="{{ asset('assets/js/script2.js') }}" defer></script>
  @stack('scripts')
</body>
</html>
