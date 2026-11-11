<header class="nav">
  <nav class="container" aria-label="Navigasi utama">
    <a class="logo" href="{{ route('program') }}" aria-label="Beranda Cakra Aji">Cakra<br>Aji</a>
    <div class="nav__links">
      <a href="{{ route('program') }}">Beranda</a>
      <a href="{{ route('program') }}#tentang">Tentang Kami</a>
      <a href="{{ route('program') }}" class="is-active" aria-current="page">Program &amp; Kegiatan</a>
      <a href="{{ route('galeri') }}">Galeri</a>
      <a href="{{ route('lokasi') }}">Kontak</a>
      <a href="{{ route('program') }}#program" class="btn btn--amber">Daftar Murid</a>
      <a href="{{ route('lokasi') }}#kontak" class="btn btn--outline">Booking Acara</a>
      <span class="lang-switch" role="group" aria-label="Pilihan bahasa">
        <span class="lang-switch__option lang-switch__option--active" aria-current="true">IDN</span>
        <span class="lang-switch__option" title="Bahasa Inggris belum tersedia">ENG</span>
      </span>
    </div>
  </nav>
</header>
