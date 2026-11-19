@extends('layouts.main')

@section('title', 'Program & Kegiatan — Sanggar Seni Cakra Aji')
@section('description', 'Program dan kegiatan Sanggar Seni Cakra Aji, dari ruang edukasi sampai pentas kampung.')
@section('page', 'program')
@section('activeNav', 'program')

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
      @if ($activities->isNotEmpty())
        @php
          $styles = [
            ['green', 'badge--green', 'EDUKASI'],
            ['amber', 'badge--amber', 'ANAK'],
            ['red', 'badge--red', 'PENTAS'],
          ];
        @endphp
        @foreach ($activities as $activity)
          @php
            $style = $styles[$loop->index % count($styles)];
            $photo = $activity->photos->first();
            $slug = \Illuminate\Support\Str::slug($activity->title);
          @endphp
          <article class="card card--{{ $style[0] }}">
            <div class="card__photo">
              @if ($photo)
                <img src="{{ Storage::url($photo->photo) }}" alt="{{ $photo->caption ?? $activity->title }}" loading="lazy">
              @endif
            </div>
            <div class="card__body">
              <span class="badge {{ $style[1] }}">{{ $style[2] }}</span>
              <h3>{{ $activity->title }}</h3>
              @if ($activity->description)
                <p>{{ $activity->description }}</p>
              @endif
              <div class="card__meta">
                @if ($activity->date)
                  <span>Tanggal: {{ $activity->date->translatedFormat('d F Y') }}</span>
                @endif
                @if ($photo->caption ?? null)
                  <span>{{ $photo->caption }}</span>
                @endif
              </div>
            </div>
            <div class="card__action">
              <a class="btn btn--primary" href="{{ route('program.detail', ['slug' => $slug]) }}" aria-label="Lihat dokumentasi {{ $activity->title }}">Lihat</a>
            </div>
          </article>
        @endforeach
      @else
        <article class="card card--green">
          <div class="card__photo"><img src="{{ asset('assets/images/galeri/galeri-01.jpeg') }}" alt="Dokumentasi kegiatan Ruang Edukasi &amp; Workshop Cakra Aji" width="960" height="1280"></div>
          <div class="card__body">
            <span class="badge badge--green">EDUKASI</span>
            <h3>Ruang Edukasi &amp; Workshop</h3>
            <p>Kelas karawitan terstruktur dari tingkat dasar hingga mahir, mencakup praktik, teori, dan pemahaman konsep seni.</p>
            <div class="card__meta"><span>Jadwal: Rabu &amp; Minggu, sesuai kelompok</span><span>Peserta: umum, anak hingga dewasa</span></div>
          </div>
          <div class="card__action"><a class="btn btn--primary" href="{{ route('galeri') }}" aria-label="Lihat dokumentasi Ruang Edukasi &amp; Workshop">Lihat</a></div>
        </article>
        <article class="card card--amber">
          <div class="card__photo"><img src="{{ asset('assets/images/galeri/galeri-02.jpeg') }}" alt="Dokumentasi kegiatan Kreteg Cakra Aji" width="1600" height="1200"></div>
          <div class="card__body">
            <span class="badge badge--amber">ANAK</span>
            <h3>Kreteg</h3>
            <p>Program kidung dan olah vokal untuk anak, mengenalkan lagu tradisi sekaligus melatih kepercayaan diri di atas panggung.</p>
            <div class="card__meta"><span>Jadwal: Minggu, sesuai kelompok</span><span>Peserta: anak-anak</span></div>
          </div>
          <div class="card__action"><a class="btn btn--primary" href="{{ route('galeri') }}" aria-label="Lihat dokumentasi Kreteg">Lihat</a></div>
        </article>
        <article class="card card--red">
          <div class="card__photo"><img src="{{ asset('assets/images/galeri/galeri-03.jpeg') }}" alt="Dokumentasi kegiatan Grebek Kampung Cakra Aji" width="1600" height="900"></div>
          <div class="card__body">
            <span class="badge badge--red">PENTAS</span>
            <h3>Grebek Kampung</h3>
            <p>Pentas keliling yang mempertemukan musik, gerak, dan cerita dengan warga di ruang-ruang kampung.</p>
            <div class="card__meta"><span>Jadwal: Agustus 2025</span><span>Lokasi: Boyolangu, Tulungagung</span></div>
          </div>
          <div class="card__action"><a class="btn btn--primary" href="{{ route('galeri') }}" aria-label="Lihat dokumentasi Grebek Kampung">Lihat</a></div>
        </article>
      @endif
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
      <x-form-link form="booking" class="btn">Isi formulir booking →</x-form-link>
    </div>
  </section>
@endsection
