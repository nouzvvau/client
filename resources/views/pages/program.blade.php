@extends('layouts.main', [
    'navbarView' => 'components.program-navbar',
    'footerView' => 'components.program-footer',
    'showSkipLink' => false,
])

@section('title', 'Program & Kegiatan — Sanggar Seni Cakra Aji')
@section('description', 'Program dan kegiatan Sanggar Seni Cakra Aji, dari ruang edukasi sampai pentas kampung.')
@section('page', 'program')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/program-kegiatan.css') }}">
@endpush

@section('content')
  <section class="hero" id="tentang">
    <div class="container">
      <div class="eyebrow">KOLABORASI</div>
      <h1>Dalam kolaborasi Cakra Aji, setiap ide dirajut menjadi karya yang menawan</h1>
      <p class="hero__lead">Dari ruang belajar sampai panggung kampung, berikut kegiatan yang berjalan di Cakra Aji.</p>
      <h2 id="program">Kolaborasi Cakra Aji</h2>
      <div class="cards">
      <article class="card card--green">
        <div class="card__photo"><img src="{{ asset('assets/images/galeri/galeri-01.jpeg') }}" alt="Dokumentasi kegiatan Ruang Edukasi &amp; Workshop Cakra Aji" width="960" height="1280"></div>
        <div class="card__body">
          <span class="badge badge--green">EDUKASI</span>
          <h3>Ruang Edukasi &amp; Workshop</h3>
          <p>Kelas karawitan terstruktur dari tingkat dasar hingga mahir, mencakup praktik, teori, dan pemahaman konsep seni.</p>
          <div class="card__meta"><span>Jadwal: Rabu &amp; Minggu, sesuai kelompok</span><span>Peserta: umum, anak hingga dewasa</span></div>
        </div>
        <div class="card__action"><a class="btn btn--primary" href="{{ route('galeri') }}" aria-label="Lihat dokumentasi Ruang Edukasi &amp; Workshop">View</a></div>
      </article>
      <article class="card card--amber">
        <div class="card__photo"><img src="{{ asset('assets/images/galeri/galeri-02.jpeg') }}" alt="Dokumentasi kegiatan Kreteg Cakra Aji" width="1600" height="1200"></div>
        <div class="card__body">
          <span class="badge badge--amber">ANAK</span>
          <h3>Kreteg</h3>
          <p>Program kidung dan olah vokal untuk anak, mengenalkan lagu tradisi sekaligus melatih kepercayaan diri di atas panggung.</p>
          <div class="card__meta"><span>Jadwal: Minggu, sesuai kelompok</span><span>Peserta: anak-anak</span></div>
        </div>
        <div class="card__action"><a class="btn btn--primary" href="{{ route('galeri') }}" aria-label="Lihat dokumentasi Kreteg">View</a></div>
      </article>
      <article class="card card--red">
        <div class="card__photo"><img src="{{ asset('assets/images/galeri/galeri-03.jpeg') }}" alt="Dokumentasi kegiatan Grebek Kampung Cakra Aji" width="1600" height="900"></div>
        <div class="card__body">
          <span class="badge badge--red">PENTAS</span>
          <h3>Grebek Kampung</h3>
          <p>Pentas keliling yang mempertemukan musik, gerak, dan cerita dengan warga di ruang-ruang kampung.</p>
          <div class="card__meta"><span>Jadwal: Agustus 2025</span><span>Lokasi: Boyolangu, Tulungagung</span></div>
        </div>
        <div class="card__action"><a class="btn btn--primary" href="{{ route('galeri') }}" aria-label="Lihat dokumentasi Grebek Kampung">View</a></div>
      </article>
      <article class="card card--green">
        <div class="card__photo"><img src="{{ asset('assets/images/galeri/galeri-04.jpeg') }}" alt="Dokumentasi kegiatan Ruang Edukasi &amp; Workshop Cakra Aji" width="1600" height="1200"></div>
        <div class="card__body">
          <span class="badge badge--green">EDUKASI</span>
          <h3>Ruang Edukasi &amp; Workshop</h3>
          <p>Kelas karawitan terstruktur dari tingkat dasar hingga mahir, mencakup praktik, teori, dan pemahaman konsep seni.</p>
          <div class="card__meta"><span>Jadwal: Rabu &amp; Minggu, sesuai kelompok</span><span>Peserta: umum, anak hingga dewasa</span></div>
        </div>
        <div class="card__action"><a class="btn btn--primary" href="{{ route('galeri') }}" aria-label="Lihat dokumentasi Ruang Edukasi &amp; Workshop">View</a></div>
      </article>
      <article class="card card--amber">
        <div class="card__photo"><img src="{{ asset('assets/images/galeri/galeri-05.jpeg') }}" alt="Dokumentasi kegiatan Kreteg Cakra Aji" width="1280" height="720"></div>
        <div class="card__body">
          <span class="badge badge--amber">ANAK</span>
          <h3>Kreteg</h3>
          <p>Program kidung dan olah vokal untuk anak, mengenalkan lagu tradisi sekaligus melatih kepercayaan diri di atas panggung.</p>
          <div class="card__meta"><span>Jadwal: Minggu, sesuai kelompok</span><span>Peserta: anak-anak</span></div>
        </div>
        <div class="card__action"><a class="btn btn--primary" href="{{ route('galeri') }}" aria-label="Lihat dokumentasi Kreteg">View</a></div>
      </article>
      <article class="card card--red">
        <div class="card__photo"><img src="{{ asset('assets/images/galeri/galeri-06.jpeg') }}" alt="Dokumentasi kegiatan Grebek Kampung Cakra Aji" width="1536" height="864"></div>
        <div class="card__body">
          <span class="badge badge--red">PENTAS</span>
          <h3>Grebek Kampung</h3>
          <p>Pentas keliling yang mempertemukan musik, gerak, dan cerita dengan warga di ruang-ruang kampung.</p>
          <div class="card__meta"><span>Jadwal: Agustus 2025</span><span>Lokasi: Boyolangu, Tulungagung</span></div>
        </div>
        <div class="card__action"><a class="btn btn--primary" href="{{ route('galeri') }}" aria-label="Lihat dokumentasi Grebek Kampung">View</a></div>
      </article>
      </div>
    </div>
  </section>

  <section class="more">
    <div class="container">
      <div class="eyebrow">KEGIATAN LAINNYA</div>
      <h2>Dan masih banyak lagi</h2>
      <div class="chips"><span class="chip">Karawitan Dasar</span><span class="chip">Karawitan Madya</span><span class="chip">Karawitan Mahir</span><span class="chip">Pentas Kampung</span></div>
    </div>
  </section>

  <section class="cta">
    <div class="container">
      <h2>Punya acara? Cakra Aji siap mengisi.</h2>
      <a class="btn" href="{{ route('lokasi') }}#kontak">Isi formulir booking →</a>
    </div>
  </section>
@endsection
