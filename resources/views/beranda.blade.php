@extends('layouts.main')

@section('title', 'Sanggar Seni Cakra Aji')
@section('description', 'Sanggar Seni Cakra Aji adalah ruang pelestarian musik tradisi dan kontemporer. Workshop, pentas, dan kolaborasi terbuka untuk siapa saja.')
@section('page', 'beranda')
@section('activeNav', 'beranda')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/beranda.css') }}">
@endpush


@section('content')

  <!-- HERO SECTION -->
  <section class="hero" id="beranda">

      <div class="hero-container">

          <div class="hero-content">

              <span class="eyebrow">SANGGAR SENI · SEJAK 2020</span>

              <h1>Cakra Aji</h1>

              <p>
                  Sanggar Seni Cakra Aji adalah ruang pelestarian musik
                  tradisi dan kontemporer. Di sini anak-anak, pemuda,
                  dan masyarakat belajar, berlatih, dan berkarya bersama.
                  Pintu kami terbuka untuk workshop, pentas, dan kolaborasi.
              </p>

              <div class="hero-buttons">
                  <x-form-link form="registration" class="btn btn-gold">Daftar Jadi Murid</x-form-link>
                  <x-form-link form="booking" class="btn btn-cream">Booking Acara</x-form-link>
                  <a href="{{ url('/tentang-kami') }}" class="btn btn-outline">Kenali Sanggar</a>
              </div>

          </div>

          <div class="hero-image">
              <img src="{{ asset('assets/images/logo-navbar.png') }}"
                   alt="Logo Sanggar Seni Cakra Aji">
          </div>

      </div>

  </section>


  <!-- PROGRAM SECTION -->
  <section class="program-section" id="program">

      <div class="section-container">

          <div class="section-heading">

              <div>
                  <span class="eyebrow red-text">SOROTAN PROGRAM</span>
                  <h2>Tempat bunyi tumbuh</h2>
              </div>

              <a href="{{ route('galeri') }}" class="see-all">
                  Lihat semua program →
              </a>

          </div>


          <div class="program-grid">

              <!-- CARD 1 -->
              <article class="program-card card-green">

                  <div class="program-image">
                      <img src="{{ asset('assets/images/galeri/galeri-01.jpeg') }}"
                           alt="Ruang edukasi dan workshop"
                           onerror="this.style.display='none'">
                      <span>[Foto kegiatan]</span>
                  </div>

                  <div class="program-content">

                      <span class="program-tag tag-green">EDUKASI</span>

                      <h3>Ruang Edukasi<br>& Workshop</h3>

                      <p>
                          Kelas dan workshop musik tradisi untuk
                          yang ingin mulai belajar.
                      </p>

                      <a href="{{ route('galeri') }}">Selengkapnya →</a>

                  </div>

              </article>


              <!-- CARD 2 -->
              <article class="program-card card-yellow">

                  <div class="program-image">
                      <img src="{{ asset('assets/images/galeri/galeri-02.jpeg') }}"
                           alt="Kidung Bocah Tradisi"
                           onerror="this.style.display='none'">
                      <span>[Foto kegiatan]</span>
                  </div>

                  <div class="program-content">

                      <span class="program-tag tag-yellow">ANAK</span>

                      <h3>Kidung Bocah<br>Tradisi</h3>

                      <p>
                          Mengenalkan kidung dan bunyi tradisi
                          kepada anak-anak sejak dini.
                      </p>

                      <a href="{{ route('galeri') }}">Selengkapnya →</a>

                  </div>

              </article>


              <!-- CARD 3 -->
              <article class="program-card card-red">

                  <div class="program-image">
                      <img src="{{ asset('assets/images/galeri/galeri-03.jpeg') }}"
                           alt="Grebek Kampung"
                           onerror="this.style.display='none'">
                      <span>[Foto kegiatan]</span>
                  </div>

                  <div class="program-content">

                      <span class="program-tag tag-red">PENTAS</span>

                      <h3>Grebek<br>Kampung</h3>

                      <p>
                          Pentas keliling dari kampung ke kampung
                          bersama warga.
                      </p>

                      <a href="{{ route('galeri') }}">Selengkapnya →</a>

                  </div>

              </article>


              <!-- CARD 4 -->
              <article class="other-program">

                  <span>DAN LAINNYA</span>

                  <h3>Latihan rutin &<br>project khusus</h3>

                  <p>
                      Jadwal latihan dan proyek yang sedang berjalan
                      ada di halaman program.
                  </p>

                  <a href="{{ route('galeri') }}" class="btn btn-gold">
                      Lihat jadwal
                  </a>

              </article>

          </div>

      </div>

  </section>


  <!-- BOOKING SECTION -->
  <section class="booking-section" id="booking">

      <div class="booking-container">

          <div class="booking-content">

              <span class="eyebrow">BOOKING ACARA</span>

              <h2>
                  Undang Cakra Aji untuk mengisi<br class="desktop-break">
                  acaramu
              </h2>

              <p>
                  Pentas, workshop, atau pengisian acara lainnya.
                  Isi formulir booking dan tim kami akan menghubungi kembali.
              </p>

              <x-form-link form="registration" class="booking-link">
                  Ingin ikut belajar? Daftar jadi murid →
              </x-form-link>

          </div>

          <x-form-link form="booking" class="btn booking-button">
              Isi formulir booking
          </x-form-link>

      </div>

  </section>

@endsection
