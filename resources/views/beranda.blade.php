@extends('layouts.main')

@section('title', __('Sanggar Seni Cakra Aji'))
@section('description', __('Sanggar Seni Cakra Aji adalah ruang pelestarian musik tradisi dan kontemporer. Workshop, pentas, dan kolaborasi terbuka untuk siapa saja.'))
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

              <span class="eyebrow">{{ __('SANGGAR SENI · SEJAK 2020') }}</span>

              <h1>Cakra Aji</h1>

              <p>
                  {{ __('Sanggar Seni Cakra Aji adalah ruang pelestarian musik tradisi dan kontemporer. Di sini anak-anak, pemuda, dan masyarakat belajar, berlatih, dan berkarya bersama. Pintu kami terbuka untuk workshop, pentas, dan kolaborasi.') }}
              </p>

              <div class="hero-buttons">
                  <x-form-link form="registration" class="btn btn-gold">{{ __('Daftar Jadi Murid') }}</x-form-link>
                  <x-form-link form="booking" class="btn btn-cream">{{ __('Booking Acara') }}</x-form-link>
                  <a href="{{ url('/tentang-kami') }}" class="btn btn-outline">{{ __('Kenali Sanggar') }}</a>
              </div>

          </div>

          <div class="hero-image">
              <img src="{{ asset('assets/images/logo-navbar.png') }}"
                   alt="{{ __('Logo Sanggar Seni Cakra Aji') }}">
          </div>

      </div>

  </section>


  <!-- PROGRAM SECTION -->
  <section class="program-section" id="program">

      <div class="section-container">

          <div class="section-heading">

              <div>
                  <span class="eyebrow red-text">{{ __('SOROTAN PROGRAM') }}</span>
                  <h2>{{ __('Tempat bunyi tumbuh') }}</h2>
              </div>

              <a href="{{ route('galeri') }}" class="see-all">
                  {{ __('Lihat semua program →') }}
              </a>

          </div>


          <div class="program-grid">

              <!-- CARD 1 -->
              <article class="program-card card-green">

                  <div class="program-image">
                      <img src="{{ asset('assets/images/galeri/galeri-01.jpeg') }}"
                           alt="{{ __('Ruang edukasi dan workshop') }}"
                           onerror="this.style.display='none'">
                      <span>{{ __('[Foto kegiatan]') }}</span>
                  </div>

                  <div class="program-content">

                      <span class="program-tag tag-green">{{ __('EDUKASI') }}</span>

                      <h3>{!! __('Ruang Edukasi<br>& Workshop') !!}</h3>

                      <p>
                          {{ __('Kelas dan workshop musik tradisi untuk yang ingin mulai belajar.') }}
                      </p>

                      <a href="{{ route('galeri') }}">{{ __('Selengkapnya →') }}</a>

                  </div>

              </article>


              <!-- CARD 2 -->
              <article class="program-card card-yellow">

                  <div class="program-image">
                      <img src="{{ asset('assets/images/galeri/galeri-02.jpeg') }}"
                           alt="{{ __('Kidung Bocah Tradisi') }}"
                           onerror="this.style.display='none'">
                      <span>{{ __('[Foto kegiatan]') }}</span>
                  </div>

                  <div class="program-content">

                      <span class="program-tag tag-yellow">{{ __('ANAK') }}</span>

                      <h3>{!! __('Kidung Bocah<br>Tradisi') !!}</h3>

                      <p>
                          {{ __('Mengenalkan kidung dan bunyi tradisi kepada anak-anak sejak dini.') }}
                      </p>

                      <a href="{{ route('galeri') }}">{{ __('Selengkapnya →') }}</a>

                  </div>

              </article>


              <!-- CARD 3 -->
              <article class="program-card card-red">

                  <div class="program-image">
                      <img src="{{ asset('assets/images/galeri/galeri-03.jpeg') }}"
                           alt="{{ __('Grebek Kampung') }}"
                           onerror="this.style.display='none'">
                      <span>{{ __('[Foto kegiatan]') }}</span>
                  </div>

                  <div class="program-content">

                      <span class="program-tag tag-red">{{ __('PENTAS') }}</span>

                      <h3>{!! __('Grebek<br>Kampung') !!}</h3>

                      <p>
                          {{ __('Pentas keliling dari kampung ke kampung bersama warga.') }}
                      </p>

                      <a href="{{ route('galeri') }}">{{ __('Selengkapnya →') }}</a>

                  </div>

              </article>


              <!-- CARD 4 -->
              <article class="other-program">

                  <span>{{ __('DAN LAINNYA') }}</span>

                  <h3>{!! __('Latihan rutin &<br>project khusus') !!}</h3>

                  <p>
                      {{ __('Jadwal latihan dan proyek yang sedang berjalan ada di halaman program.') }}
                  </p>

                  <a href="{{ route('galeri') }}" class="btn btn-gold">
                      {{ __('Lihat jadwal') }}
                  </a>

              </article>

          </div>

      </div>

  </section>


  <!-- BOOKING SECTION -->
  <section class="booking-section" id="booking">

      <div class="booking-container">

          <div class="booking-content">

              <span class="eyebrow">{{ __('BOOKING ACARA') }}</span>

              <h2>
                  {!! __('Undang Cakra Aji untuk mengisi<br class="desktop-break"> acaramu') !!}
              </h2>

              <p>
                  {{ __('Pentas, workshop, atau pengisian acara lainnya. Isi formulir booking dan tim kami akan menghubungi kembali.') }}
              </p>

              <x-form-link form="registration" class="booking-link">
                  {{ __('Ingin ikut belajar? Daftar jadi murid →') }}
              </x-form-link>

          </div>

          <x-form-link form="booking" class="btn booking-button">
              {{ __('Isi formulir booking') }}
          </x-form-link>

      </div>

  </section>

@endsection