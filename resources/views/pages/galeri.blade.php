@extends('layouts.main')

@section('title', 'Galeri — Sanggar Seni Cakra Aji')
@section('description', 'Galeri latihan dan dokumentasi kegiatan Sanggar Seni Cakra Aji.')
@section('page', 'galeri')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/schedule.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/galeri.css') }}">
@endpush

@push('scripts')
  <script src="{{ asset('assets/js/navigation.js') }}" defer></script>
@endpush

@section('content')
  <section class="hero" aria-labelledby="hero-title">
    <div class="container">
      <p class="eyebrow eyebrow--red">Galeri latihan bersama Cakra Aji</p>
      <h1 class="hero__title" id="hero-title">
        Bukan sekadar menabuh,<br>
        tapi merawat tradisi dan meresapi nada
      </h1>
    </div>
  </section>

  <section class="gallery" aria-labelledby="gallery-title">
    <div class="container">
      <div class="gallery__head">
        <div class="gallery__intro">
          <p class="eyebrow eyebrow--red">Dokumentasi</p>
          <h2 class="gallery__title" id="gallery-title">Momen di ruang latihan</h2>
          <p class="gallery__lead">
            Potret keseharian anggota Cakra Aji saat berlatih, berkarya, dan
            tampil bersama.
          </p>
        </div>
        <p class="gallery__count">9 foto</p>
      </div>

      <div class="gallery-grid">
      <div class="gallery-row gallery-row--lead">
        <figure class="gallery-card">
          <div class="gallery-card__media">
            <img src="{{ asset('assets/images/galeri/galeri-02.jpeg') }}" width="1600" height="1200" alt="Dokumentasi latihan gamelan Sanggar Seni Cakra Aji" loading="eager">
          </div>
          <figcaption class="gallery-card__body">
            <span class="gallery-card__index" aria-hidden="true">01</span>
            <span class="gallery-card__title">Dokumentasi latihan gamelan</span>
          </figcaption>
        </figure>
        <figure class="gallery-card">
          <div class="gallery-card__media">
            <img src="{{ asset('assets/images/galeri/galeri-01.jpeg') }}" width="960" height="1280" alt="Peserta latihan karawitan Sanggar Seni Cakra Aji" loading="lazy" decoding="async">
          </div>
          <figcaption class="gallery-card__body">
            <span class="gallery-card__index" aria-hidden="true">02</span>
            <span class="gallery-card__title">Peserta latihan karawitan</span>
          </figcaption>
        </figure>
      </div>
      <div class="gallery-row gallery-row--split">
        <figure class="gallery-card">
          <div class="gallery-card__media">
            <img src="{{ asset('assets/images/galeri/galeri-03.jpeg') }}" width="1600" height="900" alt="Suasana latihan karawitan Cakra Aji" loading="lazy" decoding="async">
          </div>
          <figcaption class="gallery-card__body">
            <span class="gallery-card__index" aria-hidden="true">03</span>
            <span class="gallery-card__title">Suasana latihan karawitan</span>
          </figcaption>
        </figure>
        <figure class="gallery-card">
          <div class="gallery-card__media">
            <img src="{{ asset('assets/images/galeri/galeri-04.jpeg') }}" width="1600" height="1200" alt="Anggota Sanggar Seni Cakra Aji saat berlatih" loading="lazy" decoding="async">
          </div>
          <figcaption class="gallery-card__body">
            <span class="gallery-card__index" aria-hidden="true">04</span>
            <span class="gallery-card__title">Anggota saat berlatih</span>
          </figcaption>
        </figure>
        <figure class="gallery-card">
          <div class="gallery-card__media">
            <img src="{{ asset('assets/images/galeri/galeri-05.jpeg') }}" width="1280" height="720" alt="Dokumentasi kegiatan Sanggar Seni Cakra Aji" loading="lazy" decoding="async">
          </div>
          <figcaption class="gallery-card__body">
            <span class="gallery-card__index" aria-hidden="true">05</span>
            <span class="gallery-card__title">Dokumentasi kegiatan</span>
          </figcaption>
        </figure>
      </div>
      <div class="gallery-row gallery-row--strip">
        <figure class="gallery-card">
          <div class="gallery-card__media">
            <img src="{{ asset('assets/images/galeri/galeri-06.jpeg') }}" width="1536" height="864" alt="Latihan bersama anggota Cakra Aji" loading="lazy" decoding="async">
          </div>
          <figcaption class="gallery-card__body">
            <span class="gallery-card__index" aria-hidden="true">06</span>
            <span class="gallery-card__title">Latihan bersama anggota</span>
          </figcaption>
        </figure>
        <figure class="gallery-card">
          <div class="gallery-card__media">
            <img src="{{ asset('assets/images/galeri/galeri-07.jpeg') }}" width="1600" height="900" alt="Dokumentasi latihan karawitan di sanggar" loading="lazy" decoding="async">
          </div>
          <figcaption class="gallery-card__body">
            <span class="gallery-card__index" aria-hidden="true">07</span>
            <span class="gallery-card__title">Latihan di sanggar</span>
          </figcaption>
        </figure>
        <figure class="gallery-card">
          <div class="gallery-card__media">
            <img src="{{ asset('assets/images/galeri/galeri-08.jpeg') }}" width="1152" height="864" alt="Dokumentasi kegiatan Sanggar Seni Cakra Aji" loading="lazy" decoding="async">
          </div>
          <figcaption class="gallery-card__body">
            <span class="gallery-card__index" aria-hidden="true">08</span>
            <span class="gallery-card__title">Dokumentasi kegiatan sanggar</span>
          </figcaption>
        </figure>
        <figure class="gallery-card">
          <div class="gallery-card__media">
            <img src="{{ asset('assets/images/galeri/galeri-09.jpeg') }}" width="1280" height="720" alt="Kegiatan bersama anggota Sanggar Seni Cakra Aji" loading="lazy" decoding="async">
          </div>
          <figcaption class="gallery-card__body">
            <span class="gallery-card__index" aria-hidden="true">09</span>
            <span class="gallery-card__title">Kegiatan anggota</span>
          </figcaption>
        </figure>
      </div>
      </div>
    </div>
  </section>

  <section class="schedule" id="jadwal" aria-labelledby="schedule-title">
    <div class="container">
      <p class="eyebrow eyebrow--amber">Latihan rutin</p>
      <h2 class="schedule__title" id="schedule-title">Jadwal latihan</h2>

      <div class="table-wrap">
        <table class="schedule-table">
          <colgroup>
            <col class="col-kelompok">
            <col class="col-hari">
            <col class="col-jam">
            <col class="col-tempat">
          </colgroup>
          <thead>
            <tr>
              <th scope="col">Kelompok</th>
              <th scope="col">Hari</th>
              <th scope="col">Jam</th>
              <th scope="col">Tempat</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td data-label="Kelompok">Karawitan Mahir</td>
              <td data-label="Hari">Rabu</td>
              <td data-label="Jam">19.30 - 21.00</td>
              <td data-label="Tempat">Sanggar Plosokandang</td>
            </tr>
            <tr>
              <td data-label="Kelompok">Karawitan Dasar Tingkat I (A)</td>
              <td data-label="Hari">Minggu</td>
              <td data-label="Jam">13.00 - 14.30</td>
              <td data-label="Tempat">Sanggar Plosokandang</td>
            </tr>
            <tr>
              <td data-label="Kelompok">Karawitan Dasar Tingkat I (B)</td>
              <td data-label="Hari">Minggu</td>
              <td data-label="Jam">14.30 - 16.00</td>
              <td data-label="Tempat">Sanggar Plosokandang</td>
            </tr>
            <tr>
              <td data-label="Kelompok">Karawitan Dasar Tingkat II (A)</td>
              <td data-label="Hari">Minggu</td>
              <td data-label="Jam">16.00 - 17.30</td>
              <td data-label="Tempat">Sanggar Plosokandang</td>
            </tr>
            <tr>
              <td data-label="Kelompok">Karawitan Madya II</td>
              <td data-label="Hari">Rabu</td>
              <td data-label="Jam">14.30 - 16.00</td>
              <td data-label="Tempat">Sanggar Plosokandang</td>
            </tr>
            <tr>
              <td data-label="Kelompok">Karawitan Dasar Tingkat II (C)</td>
              <td data-label="Hari">Minggu</td>
              <td data-label="Jam">13.00 - 14.30</td>
              <td data-label="Tempat">Sanggar Beji</td>
            </tr>
            <tr>
              <td data-label="Kelompok">Karawitan Madya I</td>
              <td data-label="Hari">Minggu</td>
              <td data-label="Jam">14.30 - 16.00</td>
              <td data-label="Tempat">Sanggar Beji</td>
            </tr>
            <tr>
              <td data-label="Kelompok">Karawitan Dasar Tingkat II (B)</td>
              <td data-label="Hari">Minggu</td>
              <td data-label="Jam">16.00 - 17.30</td>
              <td data-label="Tempat">Sanggar Beji</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
@endsection
