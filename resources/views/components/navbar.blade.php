{{-- Navbar standar Sanggar Cakra Aji --}}
{{-- Variabel opsional: $activeNav --}}

@php($locale = app()->getLocale())

<header class="navbar">
    <div class="nav-container">

        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('assets/images/logo-navbar.png') }}" alt="Logo Cakra Aji">
        </a>

        <div class="mobile-actions">
            <div class="language-switch" role="group" aria-label="{{ __('ui.language') }}">
                <a href="{{ route('language.switch', 'id') }}"
                   class="language-option @if ($locale === 'id') active @endif"
                   hreflang="id"
                   lang="id"
                   @if ($locale === 'id') aria-current="true" @endif>IDN</a>
                <a href="{{ route('language.switch', 'en') }}"
                   class="language-option @if ($locale === 'en') active @endif"
                   hreflang="en"
                   lang="en"
                   @if ($locale === 'en') aria-current="true" @endif>ENG</a>
            </div>

            <button class="menu-toggle" id="menuToggle" aria-label="Buka menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

        <nav class="nav-menu" id="navMenu">
            <a href="{{ url('/') }}"
               @if(($activeNav ?? null) === 'beranda') class="active" @endif>
                {{ __('ui.nav.home') }}
            </a>

            <a href="{{ url('/tentang-kami') }}"
               @if(($activeNav ?? null) === 'tentang-kami' || request()->is('tentang-kami')) class="active" @endif>
                {{ __('ui.nav.about') }}
            </a>

            <a href="{{ route('pengurus') }}"
               @if(($activeNav ?? null) === 'pengurus' || request()->is('pengurus')) class="active" @endif>
                {{ __('ui.nav.profile') }}
            </a>

            <a href="{{ route('program') }}"
               @if(($activeNav ?? null) === 'program') class="active" @endif>
                {{ __('ui.nav.programs') }}
            </a>

            <a href="{{ route('galeri') }}"
               @if(($activeNav ?? null) === 'galeri') class="active" @endif>
                {{ __('ui.nav.gallery') }}
            </a>

            <a href="{{ route('kontak') }}"
               @if(($activeNav ?? null) === 'kontak') class="active" @endif>
                {{ __('ui.nav.contact') }}
            </a>

            <a href="{{ route('faq') }}"
               @if(($activeNav ?? null) === 'faq') class="active" @endif>
                {{ __('ui.nav.faq') }}
            </a>

            <a href="{{ route('lokasi') }}"
               @if(($activeNav ?? null) === 'lokasi') class="active" @endif>
                {{ __('ui.nav.location') }}
            </a>

            <div class="nav-actions">
                <x-form-link form="registration" class="btn-daftar">
                    {{ __('ui.nav.register') }}
                </x-form-link>

                <x-form-link form="booking" class="btn-booking">
                    {{ __('ui.nav.booking') }}
                </x-form-link>
            </div>

            <div class="language-switch" role="group" aria-label="{{ __('ui.language') }}">
                <a href="{{ route('language.switch', 'id') }}"
                   class="language-option @if ($locale === 'id') active @endif"
                   hreflang="id"
                   lang="id"
                   @if ($locale === 'id') aria-current="true" @endif>IDN</a>
                <a href="{{ route('language.switch', 'en') }}"
                   class="language-option @if ($locale === 'en') active @endif"
                   hreflang="en"
                   lang="en"
                   @if ($locale === 'en') aria-current="true" @endif>ENG</a>
            </div>

        </nav>
    </div>
</header>
