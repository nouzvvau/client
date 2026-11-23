@extends('layouts.main')

@section('title', __('Program & Kegiatan — Sanggar Seni Cakra Aji'))
@section('description', __('Program dan kegiatan Sanggar Seni Cakra Aji, dari ruang edukasi sampai pentas kampung.'))
@section('page', 'program')
@section('activeNav', 'program')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/program-kegiatan.css') }}">
@endpush


@section('content')
  <section class="hero" id="tentang">
    <div class="container">
      <div class="eyebrow">{{ __('KOLABORASI') }}</div>
      <h1>{{ __('Dalam kolaborasi Cakra Aji, setiap ide dirajut menjadi karya yang menawan') }}</h1>
      <p class="hero__lead">{{ __('Dari ruang belajar sampai panggung kampung, berikut kegiatan yang berjalan di Cakra Aji.') }}</p>
      <h2 id="program">{{ __('Kolaborasi Cakra Aji') }}</h2>
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
              <span class="badge {{ $style[1] }}">{{ __($style[2]) }}</span>
              <h3>{{ $activity->title }}</h3>
              @if ($activity->description)
                <p>{{ $activity->description }}</p>
              @endif
              <div class="card__meta">
                @if ($activity->date)
                  <span>{{ __('Tanggal: :date', ['date' => $activity->date->translatedFormat('d F Y')]) }}</span>
                @endif
                @if ($photo->caption ?? null)
                  <span>{{ $photo->caption }}</span>
                @endif
              </div>
            </div>
            <div class="card__action">
              <a class="btn btn--primary" href="{{ route('program.detail', ['slug' => $slug]) }}" aria-label="{{ __('Lihat dokumentasi :title', ['title' => $activity->title]) }}">{{ __('Lihat') }}</a>
            </div>
          </article>
        @endforeach
      @else
        <article class="card card--green">
          <div class="card__photo"><img src="{{ asset('assets/images/galeri/galeri-01.jpeg') }}" alt="{{ __('Dokumentasi kegiatan Ruang Edukasi & Workshop Cakra Aji') }}" width="960" height="1280"></div>
          <div class="card__body">
            <span class="badge badge--green">{{ __('EDUKASI') }}</span>
            <h3>{{ __('Ruang Edukasi & Workshop') }}</h3>
            <p>{{ __('Kelas karawitan terstruktur dari tingkat dasar hingga mahir, mencakup praktik, teori, dan pemahaman konsep seni.') }}</p>
            <div class="card__meta"><span>{{ __('Jadwal: Rabu & Minggu, sesuai kelompok') }}</span><span>{{ __('Peserta: umum, anak hingga dewasa') }}</span></div>
          </div>
          <div class="card__action"><a class="btn btn--primary" href="{{ route('galeri') }}" aria-label="{{ __('Lihat dokumentasi Ruang Edukasi & Workshop') }}">{{ __('Lihat') }}</a></div>
        </article>
        <article class="card card--amber">
          <div class="card__photo"><img src="{{ asset('assets/images/galeri/galeri-02.jpeg') }}" alt="{{ __('Dokumentasi kegiatan Kreteg Cakra Aji') }}" width="1600" height="1200"></div>
          <div class="card__body">
            <span class="badge badge--amber">{{ __('ANAK') }}</span>
            <h3>Kreteg</h3>
            <p>{{ __('Program kidung dan olah vokal untuk anak, mengenalkan lagu tradisi sekaligus melatih kepercayaan diri di atas panggung.') }}</p>
            <div class="card__meta"><span>{{ __('Jadwal: Minggu, sesuai kelompok') }}</span><span>{{ __('Peserta: anak-anak') }}</span></div>
          </div>
          <div class="card__action"><a class="btn btn--primary" href="{{ route('galeri') }}" aria-label="{{ __('Lihat dokumentasi Kreteg') }}">{{ __('Lihat') }}</a></div>
        </article>
        <article class="card card--red">
          <div class="card__photo"><img src="{{ asset('assets/images/galeri/galeri-03.jpeg') }}" alt="{{ __('Dokumentasi kegiatan Grebek Kampung Cakra Aji') }}" width="1600" height="900"></div>
          <div class="card__body">
            <span class="badge badge--red">{{ __('PENTAS') }}</span>
            <h3>Grebek Kampung</h3>
            <p>{{ __('Pentas keliling yang mempertemukan musik, gerak, dan cerita dengan warga di ruang-ruang kampung.') }}</p>
            <div class="card__meta"><span>{{ __('Jadwal: Agustus 2025') }}</span><span>{{ __('Lokasi: Boyolangu, Tulungagung') }}</span></div>
          </div>
          <div class="card__action"><a class="btn btn--primary" href="{{ route('galeri') }}" aria-label="{{ __('Lihat dokumentasi Grebek Kampung') }}">{{ __('Lihat') }}</a></div>
        </article>
      @endif
      </div>
    </div>
  </section>

  <section class="more">
    <div class="container">
      <div class="eyebrow">{{ __('KEGIATAN LAINNYA') }}</div>
      <h2>{{ __('Dan masih banyak lagi') }}</h2>
      <div class="chips"><span class="chip">{{ __('Karawitan Dasar') }}</span><span class="chip">{{ __('Karawitan Madya') }}</span><span class="chip">{{ __('Karawitan Mahir') }}</span><span class="chip">{{ __('Pentas Kampung') }}</span></div>
    </div>
  </section>

  <section class="cta">
    <div class="container">
      <h2>{{ __('Punya acara? Cakra Aji siap mengisi.') }}</h2>
      <x-form-link form="booking" class="btn">{{ __('Isi formulir booking →') }}</x-form-link>
    </div>
  </section>
@endsection