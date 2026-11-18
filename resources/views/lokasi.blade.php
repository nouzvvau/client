@extends('layouts.main')

@section('title', 'Lokasi & Kontak — Sanggar Seni Cakra Aji')
@section('description', 'Lokasi latihan Sanggar Cakra Aji di Beji dan Plosokandang, beserta informasi kontak.')
@section('page', 'lokasi')
@section('activeNav', 'lokasi')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/lokasi.css') }}">
@endpush

@push('scripts')
  <script src="{{ asset('assets/js/script2.js') }}" defer></script>
@endpush

@section('content')
  {{-- HERO --}}
  <section class="hero" aria-labelledby="hero-title">
    <div class="container">
      <p class="eyebrow eyebrow--red">Lokasi latihan</p>

      <h1 class="hero__title" id="hero-title">
        Temukan kami<br>
        di dua tempat.
      </h1>

      <p class="hero__lead">
        Sanggar Cakra Aji berlatih di beberapa lokasi. Pilih yang paling dekat
        denganmu, lalu buka petunjuk arahnya di Google Maps.
      </p>
    </div>
  </section>

  {{-- DAFTAR LOKASI --}}
  <section class="locations" id="lokasi" aria-labelledby="locations-title">
    <div class="container">
      <h2 class="sr-only" id="locations-title">Lokasi latihan</h2>

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
                  ->implode(' dan ');
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
                    title="Peta lokasi {{ $location->name }}"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen>
                  </iframe>
                @else
                  <div
                    class="location-map location-map--pending"
                    role="img"
                    aria-label="Peta lokasi {{ $location->name }} belum tersedia">

                    <span class="location-map__pending-text">
                      <strong>Peta menyusul</strong>
                      <span>
                        Alamat lengkap dan koordinat {{ $location->name }}
                        belum tersedia.
                      </span>
                    </span>
                  </div>
                @endif
              </div>

              {{-- LOCATION INFORMATION --}}
              <div class="location-card__body">
                <span class="location-card__tag">
                  Lokasi {{ $loop->iteration }}
                </span>

                <h3 class="location-card__title">
                  {{ $location->name }}
                </h3>

                <dl class="location-facts">
                  {{-- ADDRESS --}}
                  <div>
                    <dt>Alamat</dt>
                    <dd>
                      {{ $location->address ?? 'Alamat lengkap belum tersedia. Silakan hubungi pengurus untuk informasi lokasi.' }}
                    </dd>
                  </div>

                  {{-- PROGRAM GROUP --}}
                  <div>
                    <dt>Kelompok latihan</dt>
                    <dd>
                      @if ($programNames->isNotEmpty())
                        <ul class="location-groups">
                          @foreach ($programNames as $programName)
                            <li>{{ $programName }}</li>
                          @endforeach
                        </ul>
                      @else
                        <ul class="location-groups">
                          <li>Belum ada kelompok yang terdaftar di lokasi ini.</li>
                        </ul>
                      @endif
                    </dd>
                  </div>

                  {{-- SCHEDULE --}}
                  <div>
                    <dt>Jadwal</dt>
                    <dd>
                      {{ $days !== '' ? $days . ', sesuai jadwal kelompok' : 'Belum tersedia. Hubungi pengurus untuk informasi jadwal.' }}
                    </dd>
                  </div>

                  {{-- LOCATION GUIDE --}}
                  <div>
                    <dt>Patokan / petunjuk</dt>
                    <dd>
                      {{ $location->description ?? 'Belum tersedia. Gunakan peta di atas untuk panduan arah.' }}
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
                      Buka di Google Maps
                    </a>

                    <a
                      class="btn btn--outline-brown"
                      href="https://www.google.com/maps/dir/?api=1&amp;destination={{ $mapsQuery }}"
                      target="_blank"
                      rel="noopener">
                      Petunjuk arah
                    </a>
                  @else
                    <a
                      class="btn btn--outline-brown"
                      href="#kontak">
                      Tanya lokasi
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
              aria-label="Peta lokasi Sanggar Cakra Aji Beji belum tersedia">

              <span class="location-pin" aria-hidden="true">1</span>

              <div class="location-map__pending-text">
                <strong>Peta menyusul</strong>
                <span>
                  Alamat lengkap dan koordinat cabang Beji belum tersedia.
                </span>
              </div>
            </div>

            <div class="location-card__body">
              <span class="location-card__tag">Lokasi 1</span>

              <h3 class="location-card__title">
                Sanggar Cakra Aji Beji
              </h3>

              <dl class="location-facts">
                <div>
                  <dt>Alamat</dt>
                  <dd>
                    Alamat lengkap belum tersedia. Silakan hubungi pengurus
                    untuk informasi lokasi.
                  </dd>
                </div>

                <div>
                  <dt>Kelompok latihan</dt>
                  <dd>
                    <ul class="location-groups">
                      <li>Karawitan Dasar Tingkat II (C)</li>
                      <li>Karawitan Madya I</li>
                      <li>Karawitan Dasar Tingkat II (B)</li>
                    </ul>
                  </dd>
                </div>

                <div>
                  <dt>Jadwal</dt>
                  <dd>Minggu, sesuai jadwal kelompok</dd>
                </div>

                <div>
                  <dt>Patokan / petunjuk</dt>
                  <dd>
                    Belum tersedia. Hubungi pengurus untuk petunjuk arah.
                  </dd>
                </div>
              </dl>

              <div class="location-actions">
                <a class="btn btn--outline-brown" href="#kontak">
                  Tanya lokasi
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
                title="Peta lokasi Sanggar Cakra Aji Plosokandang"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen>
              </iframe>
            </div>

            <div class="location-card__body">
              <span class="location-card__tag">Lokasi 2</span>

              <h3 class="location-card__title">
                Sanggar Cakra Aji Plosokandang
              </h3>

              <dl class="location-facts">
                <div>
                  <dt>Alamat</dt>
                  <dd>
                    Jl. Tembus Manggisan, Manggisan, Plosokandang,
                    Kec. Kedungwaru, Kabupaten Tulungagung, Jawa Timur
                  </dd>
                </div>

                <div>
                  <dt>Kelompok latihan</dt>
                  <dd>
                    <ul class="location-groups">
                      <li>Karawitan Mahir</li>
                      <li>Karawitan Dasar Tingkat I (A)</li>
                      <li>Karawitan Dasar Tingkat I (B)</li>
                      <li>Karawitan Dasar Tingkat II (A)</li>
                      <li>Karawitan Madya II</li>
                    </ul>
                  </dd>
                </div>

                <div>
                  <dt>Jadwal</dt>
                  <dd>Rabu dan Minggu, sesuai jadwal kelompok</dd>
                </div>

                <div>
                  <dt>Patokan / petunjuk</dt>
                  <dd>
                    Belum tersedia. Gunakan peta di atas untuk panduan arah.
                  </dd>
                </div>
              </dl>

              <div class="location-actions">
                <a
                  class="btn btn--brown"
                  href="https://www.google.com/maps/search/?api=1&amp;query=Jl.+Tembus+Manggisan%2C+Manggisan%2C+Plosokandang%2C+Kec.+Kedungwaru%2C+Kabupaten+Tulungagung%2C+Jawa+Timur"
                  target="_blank"
                  rel="noopener">
                  Buka di Google Maps
                </a>

                <a
                  class="btn btn--outline-brown"
                  href="https://www.google.com/maps/dir/?api=1&amp;destination=Jl.+Tembus+Manggisan%2C+Manggisan%2C+Plosokandang%2C+Kec.+Kedungwaru%2C+Kabupaten+Tulungagung%2C+Jawa+Timur"
                  target="_blank"
                  rel="noopener">
                  Petunjuk arah
                </a>
              </div>
            </div>
          </article>
        @endif
      </div>

      {{-- LOCATION NOTE --}}
      @if ($locations->isEmpty())
        <p class="location-note">
          Peta cabang Beji akan ditambahkan setelah alamat lengkap dan koordinat
          tersedia. Jarak dan waktu tempuh antar lokasi belum tersedia.
        </p>
      @endif

      {{-- CONTACT --}}
      <div class="contact-panel" id="kontak">
        <div class="contact-panel__content">
          <p class="eyebrow eyebrow--red">Kontak</p>

          <h2 class="contact-panel__title">
            Ingin bergabung?
          </h2>

          <p class="contact-panel__text">
            Datang langsung ke sanggar saat jadwal latihan, atau tanyakan
            informasi pendaftaran dan lokasi cabang kepada pengurus
            Sanggar Seni Cakra Aji.
          </p>

          <dl class="contact-list">
            <div>
              <dt>Lokasi</dt>
              <dd>
                @foreach ($locations as $location)
                  {{ $location->name }}{{ ! $loop->last ? ' & ' : '' }}
                @endforeach

                @if ($locations->isEmpty())
                  Sanggar Plosokandang &amp; Sanggar Beji
                @endif
              </dd>
            </div>

            <div>
              <dt>Jadwal</dt>
              <dd>Rabu dan Minggu</dd>
            </div>

            <div>
              <dt>Pendaftaran</dt>
              <dd>
                Datang langsung saat jadwal latihan untuk mendapatkan
                informasi pendaftaran.
              </dd>
            </div>
          </dl>

          <a
            class="btn btn--brown contact-panel__button"
            href="{{ route('program') }}#program">
            Lihat program latihan
          </a>
        </div>
      </div>

    </div>
  </section>
@endsection