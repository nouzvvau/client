@extends('layouts.main')

@section('title', __('Lokasi & Kontak — Sanggar Seni Cakra Aji'))
@section('description', __('Lokasi latihan Sanggar Cakra Aji di Beji dan Plosokandang, beserta informasi kontak.'))
@section('page', 'lokasi')
@section('activeNav', 'lokasi')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/lokasi.css') }}">
@endpush


@section('content')
  {{-- HERO --}}
  <section class="hero" aria-labelledby="hero-title">
    <div class="container">
      <p class="eyebrow eyebrow--red">{{ __('Lokasi latihan') }}</p>

      <h1 class="hero__title" id="hero-title">
        {!! __('Temukan kami<br>di dua tempat.') !!}
      </h1>

      <p class="hero__lead">
        {{ __('Sanggar Cakra Aji berlatih di beberapa lokasi. Pilih yang paling dekat denganmu, lalu buka petunjuk arahnya di Google Maps.') }}
      </p>
    </div>
  </section>

  {{-- DAFTAR LOKASI --}}
  <section class="locations" id="lokasi" aria-labelledby="locations-title">
    <div class="container">
      <h2 class="sr-only" id="locations-title">{{ __('Lokasi latihan') }}</h2>

      <div class="location-grid">
        @if ($locations->isNotEmpty())

          @foreach ($locations as $location)
            @php
              $mapsQuery = rawurlencode($location->address ?? $location->name);

              $programNames = $location->schedules
                  ->filter(fn ($schedule) => $schedule->program)
                  ->map(fn ($schedule) => $schedule->program->name)
                  ->unique()
                  ->values();

              $days = $location->schedules
                  ->pluck('day_of_week')
                  ->unique()
                  ->values()
                  ->map(fn ($day) => __($day))
                  ->implode(' '.__('dan').' ');
            @endphp

            <article class="location-card">
              {{-- MAP --}}
              <div class="location-map">
                <span class="location-pin" aria-hidden="true">
                  {{ $loop->iteration }}
                </span>

                @if ($location->google_maps_url || $location->address)
                  <iframe
                    src="https://www.google.com/maps?q={{ $mapsQuery }}&amp;output=embed"
                    title="{{ __('Peta lokasi :name', ['name' => $location->name]) }}"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen>
                  </iframe>
                @else
                  <div
                    class="location-map location-map--pending"
                    role="img"
                    aria-label="{{ __('Peta lokasi :name belum tersedia', ['name' => $location->name]) }}">

                    <span class="location-map__pending-text">
                      <strong>{{ __('Peta menyusul') }}</strong>
                      <span>
                        {{ __('Alamat lengkap dan koordinat :name belum tersedia.', ['name' => $location->name]) }}
                      </span>
                    </span>
                  </div>
                @endif
              </div>

              {{-- LOCATION INFORMATION --}}
              <div class="location-card__body">
                <span class="location-card__tag">
                  {{ __('Lokasi :number', ['number' => $loop->iteration]) }}
                </span>

                <h3 class="location-card__title">
                  {{ $location->name }}
                </h3>

                <dl class="location-facts">
                  {{-- ADDRESS --}}
                  <div>
                    <dt>{{ __('Alamat') }}</dt>
                    <dd>
                      {{ $location->address ?? __('Alamat lengkap belum tersedia. Silakan hubungi pengurus untuk informasi lokasi.') }}
                    </dd>
                  </div>

                  {{-- PROGRAM GROUP --}}
                  <div>
                    <dt>{{ __('Kelompok latihan') }}</dt>
                    <dd>
                      @if ($programNames->isNotEmpty())
                        <ul class="location-groups">
                          @foreach ($programNames as $programName)
                            <li>{{ __($programName) }}</li>
                          @endforeach
                        </ul>
                      @else
                        <ul class="location-groups">
                          <li>{{ __('Belum ada kelompok yang terdaftar di lokasi ini.') }}</li>
                        </ul>
                      @endif
                    </dd>
                  </div>

                  {{-- SCHEDULE --}}
                  <div>
                    <dt>{{ __('Jadwal') }}</dt>
                    <dd>
                      {{ $days !== '' ? __(':days, sesuai jadwal kelompok', ['days' => $days]) : __('Belum tersedia. Hubungi pengurus untuk informasi jadwal.') }}
                    </dd>
                  </div>

                  {{-- LOCATION GUIDE --}}
                  <div>
                    <dt>{{ __('Patokan / petunjuk') }}</dt>
                    <dd>
                      {{ $location->description ?? __('Belum tersedia. Gunakan peta di atas untuk panduan arah.') }}
                    </dd>
                  </div>
                </dl>

                {{-- MAP BUTTONS --}}
                <div class="location-actions">
                  @if ($location->address)
                    <a
                      class="btn btn--brown"
                      href="https://www.google.com/maps/search/?api=1&amp;query={{ $mapsQuery }}"
                      target="_blank"
                      rel="noopener">
                      {{ __('Buka di Google Maps') }}
                    </a>

                    <a
                      class="btn btn--outline-brown"
                      href="https://www.google.com/maps/dir/?api=1&amp;destination={{ $mapsQuery }}"
                      target="_blank"
                      rel="noopener">
                      {{ __('Petunjuk arah') }}
                    </a>
                  @else
                    <a
                      class="btn btn--outline-brown"
                      href="#kontak">
                      {{ __('Tanya lokasi') }}
                    </a>
                  @endif
                </div>
              </div>
            </article>
          @endforeach

        @else

          {{-- DEFAULT LOCATION: BEJI --}}
          <article class="location-card">
            <div
              class="location-map location-map--pending"
              role="img"
              aria-label="{{ __('Peta lokasi Sanggar Cakra Aji Beji belum tersedia') }}">

              <span class="location-pin" aria-hidden="true">1</span>

              <div class="location-map__pending-text">
                <strong>{{ __('Peta menyusul') }}</strong>
                <span>
                  {{ __('Alamat lengkap dan koordinat cabang Beji belum tersedia.') }}
                </span>
              </div>
            </div>

            <div class="location-card__body">
              <span class="location-card__tag">{{ __('Lokasi :number', ['number' => 1]) }}</span>

              <h3 class="location-card__title">
                {{ __('Sanggar Cakra Aji Beji') }}
              </h3>

              <dl class="location-facts">
                <div>
                  <dt>{{ __('Alamat') }}</dt>
                  <dd>
                    {{ __('Alamat lengkap belum tersedia. Silakan hubungi pengurus untuk informasi lokasi.') }}
                  </dd>
                </div>

                <div>
                  <dt>{{ __('Kelompok latihan') }}</dt>
                  <dd>
                    <ul class="location-groups">
                      <li>{{ __('Karawitan Dasar Tingkat II (C)') }}</li>
                      <li>{{ __('Karawitan Madya I') }}</li>
                      <li>{{ __('Karawitan Dasar Tingkat II (B)') }}</li>
                    </ul>
                  </dd>
                </div>

                <div>
                  <dt>{{ __('Jadwal') }}</dt>
                  <dd>{{ __('Minggu, sesuai jadwal kelompok') }}</dd>
                </div>

                <div>
                  <dt>{{ __('Patokan / petunjuk') }}</dt>
                  <dd>
                    {{ __('Belum tersedia. Hubungi pengurus untuk petunjuk arah.') }}
                  </dd>
                </div>
              </dl>

              <div class="location-actions">
                <a class="btn btn--outline-brown" href="#kontak">
                  {{ __('Tanya lokasi') }}
                </a>
              </div>
            </div>
          </article>

          {{-- DEFAULT LOCATION: PLOSOKANDANG --}}
          <article class="location-card">
            <div class="location-map">
              <span class="location-pin" aria-hidden="true">2</span>

              <iframe
                src="https://www.google.com/maps?q=Jl.+Tembus+Manggisan,+Manggisan,+Plosokandang,+Kec.+Kedungwaru,+Kabupaten+Tulungagung,+Jawa+Timur&amp;output=embed"
                title="{{ __('Peta lokasi Sanggar Cakra Aji Plosokandang') }}"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen>
              </iframe>
            </div>

            <div class="location-card__body">
              <span class="location-card__tag">{{ __('Lokasi :number', ['number' => 2]) }}</span>

              <h3 class="location-card__title">
                {{ __('Sanggar Cakra Aji Plosokandang') }}
              </h3>

              <dl class="location-facts">
                <div>
                  <dt>{{ __('Alamat') }}</dt>
                  <dd>
                    Jl. Tembus Manggisan, Manggisan, Plosokandang,
                    Kec. Kedungwaru, Kabupaten Tulungagung, Jawa Timur
                  </dd>
                </div>

                <div>
                  <dt>{{ __('Kelompok latihan') }}</dt>
                  <dd>
                    <ul class="location-groups">
                      <li>{{ __('Karawitan Mahir') }}</li>
                      <li>{{ __('Karawitan Dasar Tingkat I (A)') }}</li>
                      <li>{{ __('Karawitan Dasar Tingkat I (B)') }}</li>
                      <li>{{ __('Karawitan Dasar Tingkat II (A)') }}</li>
                      <li>{{ __('Karawitan Madya II') }}</li>
                    </ul>
                  </dd>
                </div>

                <div>
                  <dt>{{ __('Jadwal') }}</dt>
                  <dd>{{ __('Rabu dan Minggu, sesuai jadwal kelompok') }}</dd>
                </div>

                <div>
                  <dt>{{ __('Patokan / petunjuk') }}</dt>
                  <dd>
                    {{ __('Belum tersedia. Gunakan peta di atas untuk panduan arah.') }}
                  </dd>
                </div>
              </dl>

              <div class="location-actions">
                <a
                  class="btn btn--brown"
                  href="https://www.google.com/maps/search/?api=1&amp;query=Jl.+Tembus+Manggisan%2C+Manggisan%2C+Plosokandang%2C+Kec.+Kedungwaru%2C+Kabupaten+Tulungagung%2C+Jawa+Timur"
                  target="_blank"
                  rel="noopener">
                  {{ __('Buka di Google Maps') }}
                </a>

                <a
                  class="btn btn--outline-brown"
                  href="https://www.google.com/maps/dir/?api=1&amp;destination=Jl.+Tembus+Manggisan%2C+Manggisan%2C+Plosokandang%2C+Kec.+Kedungwaru%2C+Kabupaten+Tulungagung%2C+Jawa+Timur"
                  target="_blank"
                  rel="noopener">
                  {{ __('Petunjuk arah') }}
                </a>
              </div>
            </div>
          </article>
        @endif
      </div>

      {{-- LOCATION NOTE --}}
      @if ($locations->isEmpty())
        <p class="location-note">
          {{ __('Peta cabang Beji akan ditambahkan setelah alamat lengkap dan koordinat tersedia. Jarak dan waktu tempuh antar lokasi belum tersedia.') }}
        </p>
      @endif

      {{-- CONTACT --}}
      <div class="contact-panel" id="kontak">
        <div class="contact-panel__content">
          <p class="eyebrow eyebrow--red">{{ __('Kontak') }}</p>

          <h2 class="contact-panel__title">
            {{ __('Ingin bergabung?') }}
          </h2>

          <p class="contact-panel__text">
            {{ __('Datang langsung ke sanggar saat jadwal latihan, atau tanyakan informasi pendaftaran dan lokasi cabang kepada pengurus Sanggar Seni Cakra Aji.') }}
          </p>

          <dl class="contact-list">
            <div>
              <dt>{{ __('Lokasi') }}</dt>
              <dd>
                @foreach ($locations as $location)
                  {{ $location->name }}{{ ! $loop->last ? ' & ' : '' }}
                @endforeach

                @if ($locations->isEmpty())
                  {{ __('Sanggar Plosokandang & Sanggar Beji') }}
                @endif
              </dd>
            </div>

            <div>
              <dt>{{ __('Jadwal') }}</dt>
              <dd>{{ __('Rabu dan Minggu') }}</dd>
            </div>

            <div>
              <dt>{{ __('Pendaftaran') }}</dt>
              <dd>
                {{ __('Datang langsung saat jadwal latihan untuk mendapatkan informasi pendaftaran.') }}
              </dd>
            </div>
          </dl>

          <a
            class="btn btn--brown contact-panel__button"
            href="{{ route('program') }}#program">
            {{ __('Lihat program latihan') }}
          </a>
        </div>
      </div>

    </div>
  </section>
@endsection