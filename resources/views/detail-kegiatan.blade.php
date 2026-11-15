@extends('layouts.main')

@section('title', $activity->title . ' — Program & Kegiatan Cakra Aji')
@section('description', \Illuminate\Support\Str::limit(strip_tags($activity->description ?? ''), 150))
@section('page', 'program')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/program-kegiatan.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/galeri.css') }}">
@endpush

@push('scripts')
  <script src="{{ asset('assets/js/navigation.js') }}" defer></script>
@endpush

@section('content')
  @php
    $photos = $activity->photos;
    $mainPhoto = $photos->first();
    $galleryPhotos = $photos->skip(1);
  @endphp

  {{-- Hero --}}
  <section class="hero hero--detail">
    <div class="container">
      <p class="eyebrow">DOKUMENTASI KEGIATAN</p>
      <h1>{{ $activity->title }}</h1>

      @if (filled($activity->date))
        <p class="hero__meta">{{ $activity->date->format('d M Y') }}</p>
      @endif

      @if (filled($activity->description))
        <p class="hero__lead">{{ $activity->description }}</p>
      @endif
    </div>
  </section>

  {{-- Foto utama --}}
  @if ($mainPhoto)
    <section class="activity-feature">
      <div class="container">
        <figure class="activity-feature__figure">
          <div class="activity-feature__media">
            <img
              src="{{ Storage::url($mainPhoto->photo) }}"
              alt="{{ $mainPhoto->caption ?? $activity->title }}"
            >
          </div>

          <figcaption class="activity-feature__caption">
            <span class="eyebrow">MOMEN UTAMA</span>
            <p>{{ $mainPhoto->caption ?? $activity->title }}</p>
          </figcaption>
        </figure>
      </div>
    </section>
  @endif

  {{-- Cerita kegiatan --}}
  @if (filled($activity->description))
    <section class="activity-story">
      <div class="container">
        <div class="activity-story__layout">
          <div class="activity-story__heading">
            <p class="eyebrow">CERITA KEGIATAN</p>
            <h2>Merayakan momen bersama Cakra Aji</h2>
          </div>

          <div class="activity-story__text">
            {{ $activity->description }}
          </div>
        </div>
      </div>
    </section>
  @endif

  {{-- Dokumentasi tambahan --}}
  @if ($galleryPhotos->isNotEmpty())
    <section class="gallery gallery--activity">
      <div class="container">
        <div class="gallery__head">
          <div class="gallery__intro">
            <p class="eyebrow">DOKUMENTASI</p>
            <h2 class="gallery__title">Momen kegiatan lainnya</h2>
          </div>

          <a class="btn btn--outline-primary" href="{{ route('program') }}">
            Semua kegiatan →
          </a>
        </div>

        <div class="activity-gallery">
          @foreach ($galleryPhotos as $photo)
            <figure class="activity-gallery__item">
              <div class="activity-gallery__media">
                <img
                  src="{{ Storage::url($photo->photo) }}"
                  alt="{{ $photo->caption ?? $activity->title }}"
                  loading="lazy"
                >
              </div>

              <figcaption>
                <span class="activity-gallery__number">
                  {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                </span>
                <span>{{ $photo->caption ?? $activity->title }}</span>
              </figcaption>
            </figure>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- Kegiatan lainnya --}}
  @if ($others->isNotEmpty())
    <section class="more">
      <div class="container">
        <p class="eyebrow">JELAJAHI LAGI</p>
        <h2>Kegiatan Cakra Aji lainnya</h2>

        <div class="chips">
          @foreach ($others as $other)
            <a
              class="chip"
              href="{{ route('program.detail', ['slug' => $other['slug']]) }}"
            >
              {{ $other['title'] }}
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- CTA --}}
  <section class="cta">
    <div class="container">
      <h2>Punya acara? Cakra Aji siap mengisi.</h2>
      <a class="btn" href="{{ route('lokasi') }}#kontak">
        Isi formulir booking →
      </a>
    </div>
  </section>
@endsection