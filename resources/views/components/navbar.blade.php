{{-- Navbar standar (acuan: beranda.blade.php) --}}
{{-- Variabel opsional: $activeNav ('beranda'|'tentang'|'program'|'galeri'|'lokasi') --}}
<header class="navbar">
    <div class="nav-container">

        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('assets/images/logo-navbar.png') }}" alt="Logo Cakra Aji">
        </a>

        <div class="mobile-actions">
            <div class="language-switch">
                <button class="language-option active" data-lang="id">IDN</button>
                <button class="language-option" data-lang="en">ENG</button>
            </div>

            <button class="menu-toggle" id="menuToggle" aria-label="Buka menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>

        <nav class="nav-menu" id="navMenu">
            <a href="{{ url('/') }}" @if(($activeNav ?? null) === 'beranda') class="active" @endif>Beranda</a>
            <a href="{{ url('/tentang-kami') }}" @if(($activeNav ?? null) === 'tentang-kami' || request()->is('tentang-kami')) class="active" @endif>Tentang Kami</a>
            <a href="{{ route('pengurus') }}" @if(($activeNav ?? null) === 'pengurus' || request()->is('pengurus')) class="active" @endif>Profil</a>
            <a href="{{ route('program') }}" @if(($activeNav ?? null) === 'program') class="active" @endif>Program &amp; Kegiatan</a>
            <a href="{{ route('galeri') }}" @if(($activeNav ?? null) === 'galeri') class="active" @endif>Galeri</a>
            <a href="{{ route('lokasi') }}#kontak" @if(($activeNav ?? null) === 'kontak') class="active" @endif>Kontak</a>
            <a href="{{ route('lokasi') }}#faq">Tanya Jawab</a>
            <a href="{{ route('lokasi') }}" @if(($activeNav ?? null) === 'lokasi') class="active" @endif>Lokasi</a>

            <div class="nav-actions">
                <a href="{{ route('pendaftaran.index') }}" class="btn-daftar">Daftar Murid</a>
                <a href="{{ route('lokasi') }}#kontak" class="btn-booking">Booking Acara</a>
            </div>

            <div class="language-switch">
                <button class="language-option active" data-lang="id">IDN</button>
                <button class="language-option" data-lang="en">ENG</button>
            </div>

        </nav>

    </div>
</header>
