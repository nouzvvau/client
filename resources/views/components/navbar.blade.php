<header class="site-header">
  <div class="container navbar">
    <a class="brand" href="{{ route('program') }}" aria-label="Beranda Sanggar Seni Cakra Aji">
      <img class="brand__logo" src="{{ asset('assets/images/logo-navbar.png') }}" alt="Logo Sanggar Seni Cakra Aji" width="83" height="68">
    </a>

    <input class="nav-toggle" type="checkbox" id="nav-toggle" aria-label="Buka menu navigasi">
    <label class="nav-toggle-label" for="nav-toggle" aria-hidden="true">
      <span></span>
      <span></span>
      <span></span>
    </label>

    <div class="navbar__panel">
      <nav class="nav-links" aria-label="Menu utama">
        <a href="{{ route('program') }}">Beranda</a>
        <a href="{{ route('program') }}#tentang">Tentang Kami</a>
        <a data-nav="program" href="{{ route('program') }}">Program &amp; Kegiatan</a>
        <a data-nav="galeri" href="{{ route('galeri') }}">Galeri</a>
        <a data-nav="lokasi" href="{{ route('lokasi') }}">Kontak</a>
        <a href="{{ route('lokasi') }}#faq">Tanya Jawab</a>
      </nav>
      <div class="nav-actions">
        <a class="btn btn--amber" href="{{ route('program') }}#program">Daftar Murid</a>
        <a class="btn btn--outline" href="{{ route('lokasi') }}#kontak">Booking Acara</a>
        <span class="lang-switch" role="group" aria-label="Pilihan bahasa">
          <span class="lang-switch__option lang-switch__option--active" aria-current="true">IDN</span>
          <span class="lang-switch__option" title="Bahasa Inggris belum tersedia">ENG</span>
        </span>
      </div>
    </div>
  </div>
</header>
