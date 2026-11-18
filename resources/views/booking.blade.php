
@extends('layouts.main')

@section('title', 'Booking Acara | Sanggar Seni Cakra Aji')
@section('description', 'Ajukan permintaan booking Sanggar Seni Cakra Aji untuk pentas, pertunjukan seni, workshop, dan acara lainnya.')
@section('page', 'booking')
@section('activeNav', 'booking')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lokasi.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/booking-acara.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/script2.js') }}" defer></script>
    <script src="{{ asset('assets/js/booking-acara.js') }}" defer></script>
@endpush

@section('content')
    <section class="hero" aria-labelledby="hero-title">
        <div class="container">
            <p class="eyebrow eyebrow--red">Booking acara</p>

            <h1 class="hero__title" id="hero-title">
                Undang Cakra Aji<br>
                ke acaramu.
            </h1>

            <p class="hero__lead">
                Isi rencana acaramu melalui formulir berikut.
                Tim kami akan menghubungi untuk membahas detail acara.
                Tanda <strong>*</strong> berarti wajib diisi.
            </p>
        </div>
    </section>

    <section class="booking-page">
        <div class="container">

            @if (session('success'))
                <div class="booking-form__alert booking-form__alert--success" role="status">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="booking-form__alert booking-form__alert--error" role="alert">
                    <strong>Periksa kembali formulir kamu:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="content-grid">

                {{-- FORM BOOKING --}}
                <section class="form-card" aria-labelledby="booking-form-title">

                    <form id="booking-form"
                          action="{{ route('booking.store') }}"
                          method="POST">

                        @csrf

                        <section class="form-section">
                            <h2 class="section-title" id="booking-form-title">
                                <span class="section-number">1</span>
                                Data pemesan
                            </h2>

                            <div class="field">
                                <label for="booking-name">
                                    Nama pemesan <b>*</b>
                                </label>
                                <input
                                    id="booking-name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name') }}"
                                    placeholder="Contoh: Ibu Sari"
                                    maxlength="255"
                                    autocomplete="name"
                                    required>
                                @error('name')
                                    <small class="booking-form__error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="booking-phone">
                                    Nomor WhatsApp aktif <b>*</b>
                                </label>
                                <input
                                    id="booking-phone"
                                    name="phone"
                                    type="tel"
                                    value="{{ old('phone') }}"
                                    placeholder="08xx xxxx xxxx"
                                    maxlength="255"
                                    autocomplete="tel"
                                    inputmode="tel"
                                    required>
                                <small>Kami akan menghubungi kamu melalui nomor ini.</small>
                                @error('phone')
                                    <small class="booking-form__error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="booking-institution">
                                    Nama instansi / kelompok penyelenggara
                                    <span>(boleh dikosongkan)</span>
                                </label>
                                <input
                                    id="booking-institution"
                                    name="institution_name"
                                    type="text"
                                    value="{{ old('institution_name') }}"
                                    placeholder="Contoh: Karang Taruna, sekolah, kantor desa"
                                    maxlength="255">
                                @error('institution_name')
                                    <small class="booking-form__error">{{ $message }}</small>
                                @enderror
                            </div>
                        </section>

                        <section class="form-section">
                            <h2 class="section-title">
                                <span class="section-number">2</span>
                                Rencana acara
                            </h2>

                            <div class="field">
                                <label for="booking-service">
                                    Kebutuhan acara <b>*</b>
                                </label>
                                <select id="booking-service" name="service_type" required>
                                    <option value="">Pilih kebutuhan acara</option>
                                    @foreach ([
                                        'Pentas / pengisi acara',
                                        'Pertunjukan seni',
                                        'Workshop / pelatihan',
                                        'Kolaborasi acara',
                                        'Lainnya'
                                    ] as $type)
                                        <option value="{{ $type }}"
                                            @selected(old('service_type') === $type)>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_type')
                                    <small class="booking-form__error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="booking-event">
                                    Nama acara <b>*</b>
                                </label>
                                <input
                                    id="booking-event"
                                    name="event_name"
                                    type="text"
                                    value="{{ old('event_name') }}"
                                    placeholder="Contoh: Pentas Hari Jadi Desa"
                                    maxlength="255"
                                    required>
                                @error('event_name')
                                    <small class="booking-form__error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="booking-date">
                                    Tanggal acara <b>*</b>
                                </label>
                                <input
                                    id="booking-date"
                                    name="event_date"
                                    type="date"
                                    value="{{ old('event_date') }}"
                                    min="{{ now()->toDateString() }}"
                                    required>
                                <small>Kalau belum pasti, pilih tanggal perkiraan.</small>
                                @error('event_date')
                                    <small class="booking-form__error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="booking-time">
                                    Jam mulai <span>(boleh dikosongkan)</span>
                                </label>
                                <input
                                    id="booking-time"
                                    name="start_time"
                                    type="time"
                                    value="{{ old('start_time') }}">
                                @error('start_time')
                                    <small class="booking-form__error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="booking-location">
                                    Lokasi acara <b>*</b>
                                </label>
                                <input
                                    id="booking-location"
                                    name="event_location"
                                    type="text"
                                    value="{{ old('event_location') }}"
                                    placeholder="Nama tempat dan kota"
                                    required>
                                @error('event_location')
                                    <small class="booking-form__error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="booking-audience">
                                    Perkiraan jumlah penonton
                                    <span>(boleh dikosongkan)</span>
                                </label>
                                <input
                                    id="booking-audience"
                                    name="estimated_audience"
                                    type="number"
                                    min="0"
                                    value="{{ old('estimated_audience') }}"
                                    placeholder="Contoh: 200">
                                @error('estimated_audience')
                                    <small class="booking-form__error">{{ $message }}</small>
                                @enderror
                            </div>
                        </section>

                        <section class="form-section">
                            <h2 class="section-title">
                                <span class="section-number">3</span>
                                Catatan tambahan
                            </h2>

                            <div class="field">
                                <label for="booking-notes">
                                    Ceritakan kebutuhanmu
                                    <span>(boleh dikosongkan)</span>
                                </label>
                                <textarea
                                    id="booking-notes"
                                    name="additional_notes"
                                    rows="4"
                                    placeholder="Misalnya: tema acara, durasi tampil, atau fasilitas panggung yang tersedia">{{ old('additional_notes') }}</textarea>
                                @error('additional_notes')
                                    <small class="booking-form__error">{{ $message }}</small>
                                @enderror
                            </div>
                        </section>

                        <div class="submit-area">
                            <button
                                class="submit-button"
                                type="submit"
                                id="submit-button">
                                <span>Kirim permintaan booking →</span>
                            </button>

                            <p>
                                Setelah dikirim, permintaan akan diterima admin
                                dan tersimpan di database. Admin akan menghubungi
                                kamu melalui WhatsApp.
                            </p>
                        </div>

                    </form>
                </section>

                {{-- SIDEBAR INFORMASI --}}
                <aside class="sidebar">

                    <section class="prepare-card">
                        <h2>SIAPKAN DULU</h2>
                        <ul>
                            <li><span>✓</span> Tanggal dan lokasi acara</li>
                            <li><span>✓</span> Nomor WhatsApp yang aktif</li>
                            <li><span>✓</span> Gambaran acara, tema, dan durasi</li>
                        </ul>
                    </section>

                    <section class="steps-card">
                        <h2>CARANYA GAMPANG</h2>
                        <ol>
                            <li>
                                <span class="step-number">1</span>
                                <div>
                                    <strong>Isi formulir ini</strong>
                                    <p>Lengkapi data pemesan dan rencana acara.</p>
                                </div>
                            </li>
                            <li>
                                <span class="step-number">2</span>
                                <div>
                                    <strong>Tekan tombol kirim</strong>
                                    <p>Permintaan langsung diterima admin sanggar.</p>
                                </div>
                            </li>
                            <li>
                                <span class="step-number">3</span>
                                <div>
                                    <strong>Admin menghubungi kamu</strong>
                                    <p>Kami membahas jadwal dan detail acara melalui WhatsApp.</p>
                                </div>
                            </li>
                        </ol>
                    </section>

                    <section class="help-card">
                        <strong>Butuh bantuan mengisi?</strong>
                        <p>
                            Hubungi contact person kami melalui halaman
                            <a href="{{ route('kontak') }}">Kontak</a>.
                        </p>
                    </section>

                    <a class="join-link" href="{{ route('pendaftaran.index') }}">
                        Ingin ikut belajar di sanggar?
                        Daftar menjadi murid <span aria-hidden="true">→</span>
                    </a>

                </aside>
            </div>
        </div>
    </section>
@endsection