<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Acara | Sanggar Cakra Aji</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/booking-acara.css') }}">
</head>
<body>
<header class="site-header">
    <nav class="navbar container" aria-label="Navigasi utama">
        <a class="brand" href="/" aria-label="Sanggar Cakra Aji - Beranda">
            <img src="{{ asset('images/logo-cakra-aji.png') }}" alt="Logo Sanggar Cakra Aji"
                 onerror="this.hidden=true; this.nextElementSibling.hidden=false;">
            <span class="brand-fallback" hidden><strong>CA</strong><small>AKRA AJI</small></span>
        </a>
        <button class="menu-toggle" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="nav-menu">
            <span></span><span></span><span></span>
        </button>
        <div class="nav-menu" id="nav-menu">
            <a href="/">Beranda</a>
            <a href="/tentang-kami">Tentang Kami</a>
            <a href="/program-kegiatan">Program &amp; Kegiatan</a>
            <a href="/galeri">Galeri</a>
            <a class="active" href="/kontak">Kontak</a>
            <a class="nav-pill" href="/daftar-murid">Daftar Murid</a>
            <a class="nav-pill nav-pill-filled" href="{{ route('booking.create') }}" aria-current="page">Booking Acara</a>
        </div>
    </nav>
</header>

<main class="page-main">
    <div class="container">
        <section class="intro">
            <div class="intro-labels">
                <span class="eyebrow">BOOKING ACARA</span>
                <span class="version-label">Versi A · Data masuk ke admin</span>
            </div>
            <h1>Undang Cakra Aji<br>ke acaramu</h1>
            <p>Isi rencana acaramu di bawah ini. Tim kami akan menghubungi untuk<br class="desktop-break">
                membahas detailnya. Tanda <strong class="required-star">*</strong> berarti wajib diisi.</p>
        </section>

        @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error" role="alert">
                <strong>Periksa kembali formulir kamu:</strong>
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="content-grid">
            <section class="form-card">
                <form id="booking-form" action="{{ route('booking.store') }}" method="POST">
                    @csrf
                    <section class="form-section">
                        <h2 class="section-title"><span class="section-number">1</span>Data pemesan</h2>
                        <div class="field">
                            <label for="customer_name">Nama kamu <b>*</b></label>
                            <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name') }}" placeholder="Contoh: Ibu Sari" maxlength="120" autocomplete="name" required>
                        </div>
                        <div class="field">
                            <label for="whatsapp">Nomor WhatsApp yang aktif <b>*</b></label>
                            <input id="whatsapp" name="whatsapp" type="tel" value="{{ old('whatsapp') }}" placeholder="08xx xxxx xxxx" maxlength="20" autocomplete="tel" inputmode="tel" pattern="[0-9+() -]{8,20}" title="Masukkan nomor WhatsApp yang valid." required>
                            <small>Kami akan menghubungi kamu lewat nomor ini.</small>
                        </div>
                        <div class="field">
                            <label for="organization">Nama instansi / kelompok penyelenggara <span>(boleh dikosongkan)</span></label>
                            <input id="organization" name="organization" type="text" value="{{ old('organization') }}" placeholder="Contoh: Karang Taruna, sekolah, kantor desa" maxlength="160">
                        </div>
                    </section>

                    <section class="form-section">
                        <h2 class="section-title"><span class="section-number">2</span>Rencana acara</h2>
                        <div class="field">
                            <label for="event_type">Kamu butuh apa dari Cakra Aji? <b>*</b></label>
                            <select id="event_type" name="event_type" required>
                                <option value="">Pilih kebutuhan acara</option>
                                @foreach (['Pentas / pengisi acara', 'Pertunjukan seni', 'Workshop / pelatihan', 'Kolaborasi acara', 'Lainnya'] as $type)
                                    <option value="{{ $type }}" @selected(old('event_type') === $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label for="event_name">Nama acara <b>*</b></label>
                            <input id="event_name" name="event_name" type="text" value="{{ old('event_name') }}" placeholder="Contoh: Pentas Hari Jadi Desa" maxlength="160" required>
                        </div>
                        <div class="field">
                            <label for="event_date">Tanggal acara <b>*</b></label>
                            <input id="event_date" name="event_date" type="date" value="{{ old('event_date') }}" min="{{ now()->toDateString() }}" required>
                            <small>Kalau belum pasti, pilih tanggal perkiraan.</small>
                        </div>
                        <div class="field">
                            <label for="start_time">Jam mulai <span>(boleh dikosongkan)</span></label>
                            <input id="start_time" name="start_time" type="time" value="{{ old('start_time') }}">
                        </div>
                        <div class="field">
                            <label for="event_location">Lokasi acara <b>*</b></label>
                            <input id="event_location" name="event_location" type="text" value="{{ old('event_location') }}" placeholder="Nama tempat dan kota" maxlength="200" required>
                        </div>
                        <div class="field">
                            <label for="audience_estimate">Perkiraan jumlah penonton <span>(boleh dikosongkan)</span></label>
                            <input id="audience_estimate" name="audience_estimate" type="number" min="1" max="1000000" value="{{ old('audience_estimate') }}" placeholder="Contoh: 200 orang">
                        </div>
                    </section>

                    <section class="form-section">
                        <h2 class="section-title"><span class="section-number">3</span>Catatan tambahan</h2>
                        <div class="field">
                            <label for="notes">Ceritakan kebutuhanmu <span>(boleh dikosongkan)</span></label>
                            <textarea id="notes" name="notes" rows="3" maxlength="2000" placeholder="Misalnya: tema acara, durasi tampil, atau fasilitas panggung yang tersedia">{{ old('notes') }}</textarea>
                        </div>
                    </section>

                    <div class="submit-area">
                        <button class="submit-button" type="submit" id="submit-button">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 11.1 21 3.5l-7.6 18-2.2-7.1-8.7-3.3Zm9.7 2.1 3.8 1.5 2.9-6.8-6.7 5.3Z"/></svg>
                            <span>Kirim permintaan booking</span>
                        </button>
                        <p>Setelah ditekan, datamu langsung diterima admin dan tersimpan di database.<br class="desktop-break">
                            <strong>Tidak perlu membuka aplikasi lain.</strong> Admin akan menghubungi lewat WhatsApp.</p>
                    </div>
                </form>
            </section>

            <aside class="sidebar">
                <section class="prepare-card">
                    <h2>SIAPKAN DULU</h2>
                    <ul>
                        <li><span>✓</span>Tanggal dan lokasi acara</li>
                        <li><span>✓</span>Nomor WhatsApp yang aktif</li>
                        <li><span>✓</span>Gambaran acara (tema dan durasi)</li>
                    </ul>
                </section>
                <section class="steps-card">
                    <h2>CARANYA GAMPANG</h2>
                    <ol>
                        <li><span class="step-number">1</span><div><strong>Isi formulir ini</strong><p>Lengkapi data pemesan dan rencana acara.</p></div></li>
                        <li><span class="step-number">2</span><div><strong>Tekan tombol kirim</strong><p>Permintaan langsung diterima admin sanggar.</p></div></li>
                        <li><span class="step-number">3</span><div><strong>Admin menghubungi kamu</strong><p>Kami bahas jadwal dan detailnya lewat WhatsApp.</p></div></li>
                    </ol>
                </section>
                <section class="help-card">
                    <strong>Butuh bantuan mengisi?</strong>
                    <p>Hubungi contact person kami langsung di halaman <a href="/kontak">Kontak</a>.</p>
                </section>
                <a class="join-link" href="/daftar-murid">Ingin ikut belajar di sanggar? Daftar jadi murid <span aria-hidden="true">→</span></a>
            </aside>
        </div>
    </div>
</main>
<script src="{{ asset('js/booking-acara.js') }}" defer></script>
</body>
</html>
