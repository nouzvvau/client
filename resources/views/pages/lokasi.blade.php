@extends('layouts.main')

@section('title', 'Lokasi & Kontak — Sanggar Seni Cakra Aji')
@section('description', 'Lokasi latihan Sanggar Cakra Aji di Beji dan Plosokandang, beserta informasi kontak.')
@section('page', 'lokasi')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/lokasi.css') }}">
@endpush

@push('scripts')
  <script src="{{ asset('assets/js/navigation.js') }}" defer></script>
@endpush

@section('content')
  <section class="hero" aria-labelledby="hero-title">
    <div class="container">
      <p class="eyebrow eyebrow--red">Lokasi latihan</p>
      <h1 class="hero__title" id="hero-title">
        Temukan kami<br>
        di dua tempat.
      </h1>
      <p class="hero__lead">
        Sanggar Cakra Aji berlatih di dua lokasi. Pilih yang paling dekat
        denganmu, lalu buka petunjuk arahnya di Google Maps.
      </p>
    </div>
  </section>

  <section class="locations" id="lokasi" aria-labelledby="locations-title">
    <div class="container">
      <h2 class="sr-only" id="locations-title">Lokasi latihan</h2>

      <div class="location-grid">
        <article class="location-card">
          <div class="location-map location-map--pending" role="img" aria-label="Peta lokasi Sanggar Cakra Aji Beji belum tersedia">
            <span class="location-pin" aria-hidden="true">1</span>
            <div class="location-map__pending-text">
              <strong>Peta menyusul</strong>
              <span>Alamat lengkap dan koordinat cabang Beji belum tersedia.</span>
            </div>
          </div>

          <div class="location-card__body">
            <span class="location-card__tag">Lokasi 1</span>
            <h3 class="location-card__title">Sanggar Cakra Aji Beji</h3>

            <dl class="location-facts">
              <div>
                <dt>Alamat</dt>
                <dd>
                  Alamat lengkap belum tersedia. Silakan hubungi pengurus untuk
                  informasi lokasi.
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
                <dd>Belum tersedia. Hubungi pengurus untuk petunjuk arah.</dd>
              </div>
            </dl>

            <div class="location-actions">
              <a class="btn btn--outline-brown" href="#kontak">Tanya lokasi</a>
            </div>
          </div>
        </article>

        <article class="location-card">
          <div class="location-map">
            <span class="location-pin" aria-hidden="true">2</span>
            <iframe
              src="https://www.google.com/maps?q=Jl.+Tembus+Manggisan,+Manggisan,+Plosokandang,+Kec.+Kedungwaru,+Kabupaten+Tulungagung,+Jawa+Timur&amp;output=embed"
              title="Peta lokasi Sanggar Cakra Aji Plosokandang"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              allowfullscreen></iframe>
          </div>

          <div class="location-card__body">
            <span class="location-card__tag">Lokasi 2</span>
            <h3 class="location-card__title">Sanggar Cakra Aji Plosokandang</h3>

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
                <dd>Belum tersedia. Gunakan peta di atas untuk panduan arah.</dd>
              </div>
            </dl>

            <div class="location-actions">
              <a
                class="btn btn--brown"
                href="https://www.google.com/maps/search/?api=1&amp;query=Jl.+Tembus+Manggisan%2C+Manggisan%2C+Plosokandang%2C+Kec.+Kedungwaru%2C+Kabupaten+Tulungagung%2C+Jawa+Timur"
                target="_blank"
                rel="noopener">Buka di Google Maps</a>
              <a
                class="btn btn--outline-brown"
                href="https://www.google.com/maps/dir/?api=1&amp;destination=Jl.+Tembus+Manggisan%2C+Manggisan%2C+Plosokandang%2C+Kec.+Kedungwaru%2C+Kabupaten+Tulungagung%2C+Jawa+Timur"
                target="_blank"
                rel="noopener">Petunjuk arah</a>
            </div>
          </div>
        </article>
      </div>

      <p class="location-note">
        Peta cabang Beji akan ditambahkan setelah alamat lengkap dan koordinat
        tersedia. Jarak dan waktu tempuh antar lokasi belum tersedia.
      </p>

      <div class="contact-panel" id="kontak">
        <div>
          <p class="eyebrow eyebrow--red">Kontak</p>
          <h2 class="contact-panel__title">Ingin bergabung?</h2>
          <p class="contact-panel__text">
            Datang langsung ke sanggar saat jadwal latihan, atau tanyakan
            informasi pendaftaran dan lokasi cabang Beji kepada pengurus
            Sanggar Seni Cakra Aji.
          </p>
          <dl class="contact-list">
            <div>
              <dt>Lokasi</dt>
              <dd>Sanggar Plosokandang &amp; Sanggar Beji</dd>
            </div>
            <div>
              <dt>Jadwal</dt>
              <dd>Rabu dan Minggu</dd>
            </div>
            <div>
              <dt>Pendaftaran</dt>
              <dd>Datang langsung saat jadwal latihan atau hubungi pengurus</dd>
            </div>
          </dl>
          <a class="btn btn--brown contact-panel__button" href="{{ route('program') }}#program">Lihat program latihan</a>
        </div>

        <div class="faq" id="faq">
          <p class="eyebrow eyebrow--red">Tanya jawab</p>
          <h2 class="contact-panel__title">Pertanyaan yang sering diajukan</h2>
          <details>
            <summary>Apakah pemula bisa ikut latihan?</summary>
            <p>
              Bisa. Tersedia kelas Karawitan Dasar Tingkat I untuk anggota
              yang baru mulai mengenal gamelan.
            </p>
          </details>
          <details>
            <summary>Kapan latihan rutin dilaksanakan?</summary>
            <p>
              Latihan rutin berlangsung setiap Rabu dan Minggu. Waktu
              masing-masing kelompok dapat dilihat pada jadwal lengkap di
              halaman Program &amp; Kegiatan.
            </p>
          </details>
          <details>
            <summary>Di mana lokasi latihan?</summary>
            <p>
              Latihan dilaksanakan di Sanggar Plosokandang dan Sanggar Beji.
              Lokasi menyesuaikan kelompok dan jadwal latihan. Alamat lengkap
              Sanggar Plosokandang tersedia di halaman ini, sedangkan alamat
              Sanggar Beji dapat ditanyakan kepada pengurus.
            </p>
          </details>
          <details>
            <summary>Bagaimana cara menuju Sanggar Plosokandang?</summary>
            <p>
              Gunakan peta atau tombol petunjuk arah pada kartu Sanggar
              Plosokandang. Alamatnya berada di Jl. Tembus Manggisan,
              Plosokandang, Kec. Kedungwaru, Kabupaten Tulungagung.
            </p>
          </details>
          <details>
            <summary>Bagaimana cara mendaftar?</summary>
            <p>
              Silakan datang langsung ke sanggar saat jadwal latihan atau
              hubungi pengurus untuk informasi lebih lanjut.
            </p>
          </details>
        </div>
      </div>
    </div>
  </section>
@endsection
