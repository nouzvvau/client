@extends('layouts.main')

@section('title', 'Pendaftaran Murid | Sanggar Seni Cakra Aji')
@section('description', 'Formulir pendaftaran murid Sanggar Seni Cakra Aji. Isi data calon murid, orang tua/wali, dan program yang diminati.')
@section('page', 'pendaftaran')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/pendaftaran.css') }}">
@endpush


@section('content')
@php
  $registrationExternal = \App\Support\GoogleForms::isExternal('registration');
  $registrationUrl = \App\Support\GoogleForms::url('registration');
@endphp
<!-- MAIN -->

<div class="main">

    <!-- HEADING -->

    <section class="heading">

        <div class="heading-label">
            PENDAFTARAN MURID BARU
        </div>

        <span class="version">
            {{ $registrationExternal ? 'Pendaftaran via Google Forms' : 'Pendaftaran langsung lewat website' }}
        </span>

        <h1>
            Daftar jadi murid<br>
            Cakra Aji
        </h1>

        <p>
            @if ($registrationExternal)
                Isi formulir pendaftaran resmi melalui Google Forms.
                Cuma sekitar 3 menit.
            @else
                Isi data calon murid di bawah ini.
                Cuma sekitar 3 menit.
                Tanda <span class="required">*</span>
                berarti wajib diisi.
            @endif
        </p>

    </section>


    <!-- SUCCESS -->

    @if(! $registrationExternal && session('success'))

        <div class="alert alert-success">

            ✓ {{ session('success') }}

            <br>

            Data pendaftaran berhasil disimpan.
            Admin akan menghubungi melalui WhatsApp.

        </div>

    @endif


    <!-- ERROR -->

    @if(! $registrationExternal && $errors->any())

        <div class="alert alert-error">

            Ada data yang belum sesuai.
            Silakan periksa kembali formulir.

        </div>

    @endif


    <!-- CONTENT -->

    <div class="content">


        <!-- FORM -->

        <section class="form-card{{ $registrationExternal ? ' form-external' : '' }}">

            @if ($registrationExternal)

                <p class="heading-label">Formulir resmi</p>

                <h2 class="section-title">Pendaftaran murid baru</h2>

                <p class="form-external__text">
                    Pendaftaran dilakukan melalui Google Forms agar data
                    langsung diterima admin. Formulir akan terbuka di tab baru.
                </p>

                <a href="{{ $registrationUrl }}"
                   class="submit-btn"
                   target="_blank"
                   rel="noopener noreferrer">
                    ↗
                    Buka formulir pendaftaran
                </a>

                <p class="form-note">
                    Setelah formulir dikirim, admin akan menghubungi
                    melalui WhatsApp.
                </p>

            @else

            <form action="{{ route('pendaftaran.store') }}"
                  method="POST">

                @csrf


                <!-- DATA MURID -->

                <h2 class="section-title">

                    <span class="number">1</span>

                    Data calon murid

                </h2>


                <div class="form-group">

                    <label>
                        Nama lengkap calon murid
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="nama_murid"
                        class="form-control"
                        placeholder="Contoh: Rina Putri"
                        value="{{ old('nama_murid') }}"
                        required
                    >

                    @error('nama_murid')
                        <span class="error-text">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Tanggal lahir
                        <span class="required">*</span>
                    </label>

                    <p class="helper">
                        Supaya kami bisa memilih kelas yang sesuai usia.
                    </p>

                    <input
                        type="date"
                        name="tanggal_lahir"
                        class="form-control"
                        value="{{ old('tanggal_lahir') }}"
                        max="{{ date('Y-m-d') }}"
                        required
                    >

                    @error('tanggal_lahir')
                        <span class="error-text">{{ $message }}</span>
                    @enderror

                </div>


                <hr class="form-divider">


                <!-- DATA WALI -->

                <h2 class="section-title">

                    <span class="number">2</span>

                    Data orang tua / wali

                </h2>


                <div class="form-group">

                    <label>
                        Nama orang tua / wali
                        <span class="required">*</span>
                    </label>

                    <p class="helper">
                        Jika calon murid sudah dewasa,
                        isi dengan namanya sendiri.
                    </p>

                    <input
                        type="text"
                        name="nama_wali"
                        class="form-control"
                        placeholder="Contoh: Bapak Budi"
                        value="{{ old('nama_wali') }}"
                        required
                    >

                    @error('nama_wali')
                        <span class="error-text">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Nomor WhatsApp yang aktif
                        <span class="required">*</span>
                    </label>

                    <p class="helper">
                        Kami akan menghubungi nomor ini.
                    </p>

                    <input
                        type="tel"
                        name="whatsapp"
                        class="form-control"
                        placeholder="08xx xxxx xxxx"
                        value="{{ old('whatsapp') }}"
                        required
                    >

                    @error('whatsapp')
                        <span class="error-text">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Alamat / kampung tempat tinggal
                    </label>

                    <input
                        type="text"
                        name="alamat"
                        class="form-control"
                        placeholder="Nama kampung atau kota"
                        value="{{ old('alamat') }}"
                    >

                </div>

                <hr class="form-divider">


                <!-- PROGRAM -->

                <h2 class="section-title">

                    <span class="number">3</span>

                    Program yang diminati

                </h2>


                <div class="form-group">

                    <label>
                        Pilih program
                        <span class="required">*</span>
                    </label>

                    <p class="helper">
                        Detail program ada di halaman
                        Program & Kegiatan.
                    </p>

                    <select
                        name="program"
                        class="form-control"
                        required
                    >

                        <option value="">
                            Pilih program
                        </option>

                        <option value="Ruang Edukasi & Workshop">
                            Ruang Edukasi & Workshop
                        </option>

                        <option value="Karawitan">
                            Karawitan
                        </option>

                        <option value="Tari">
                            Tari
                        </option>

                        <option value="Seni Tradisional">
                            Seni Tradisional
                        </option>

                    </select>

                    @error('program')
                        <span class="error-text">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Pengalaman bermusik
                    </label>

                    <select
                        name="pengalaman"
                        class="form-control"
                    >

                        <option value="Belum pernah">
                            Belum pernah
                        </option>

                        <option value="Pernah belajar">
                            Pernah belajar
                        </option>

                        <option value="Sudah berpengalaman">
                            Sudah berpengalaman
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Catatan atau pertanyaan
                    </label>

                    <textarea
                        name="catatan"
                        class="form-control"
                        placeholder="Misalnya: hari yang diinginkan atau pertanyaan untuk admin"
                    >{{ old('catatan') }}</textarea>

                </div>


                <hr class="form-divider">


                <!-- BUTTON -->

                <button type="submit" class="submit-btn">

                    ↗

                    Kirim pendaftaran

                </button>


                <p class="form-note">

                    Setelah ditekan, data langsung diterima admin
                    dan disimpan di database.

                    Admin akan menghubungi lewat WhatsApp.

                </p>


            </form>

            @endif

        </section>


        <!-- SIDEBAR -->

        <aside class="sidebar">


            <!-- PERSIAPAN -->

            <div class="side-card dark">

                <h3 class="side-title">
                    SIAPKAN DULU
                </h3>

                <ul class="side-list">

                    <li>
                        <span class="check">✓</span>
                        <div>Nama dan tanggal lahir calon murid</div>
                    </li>

                    <li>
                        <span class="check">✓</span>
                        <div>Nomor WhatsApp yang aktif</div>
                    </li>

                    <li>
                        <span class="check">✓</span>
                        <div>Program yang ingin diikuti</div>
                    </li>

                </ul>

            </div>


            <!-- CARA PENDAFTARAN -->

            <div class="side-card">

                <h3 class="side-title">
                    CARANYA GAMPANG
                </h3>

                <ul class="side-list">

                    <li>

                        <span class="step">1</span>

                        <div>

                            <strong>{{ $registrationExternal ? 'Buka Google Forms' : 'Isi formulir ini' }}</strong>

                            <span class="description">
                                Lengkapi data calon murid dan wali.
                            </span>

                        </div>

                    </li>

                    <li>

                        <span class="step">2</span>

                        <div>

                            <strong>{{ $registrationExternal ? 'Kirim formulir pendaftaran' : 'Tekan tombol kirim' }}</strong>

                            <span class="description">
                                Datanya langsung diterima admin sanggar.
                            </span>

                        </div>

                    </li>

                    <li>

                        <span class="step">3</span>

                        <div>

                            <strong>Admin menghubungi kamu</strong>

                            <span class="description">
                                Kami kabari jadwal dan informasi
                                lewat WhatsApp.
                            </span>

                        </div>

                    </li>

                </ul>

            </div>


            <!-- BANTUAN -->

            <div class="side-card light">

                <h3 class="side-title">
                    Butuh bantuan mengisi?
                </h3>

                <p>

                    Hubungi kontak person kami langsung
                    di halaman

                    <a href="{{ route('lokasi') }}#kontak" class="contact-link">
                        Kontak
                    </a>.

                </p>

            </div>


            <!-- BOOKING -->

            <div class="side-card">

                <p>

                    Ingin mengundang Cakra Aji ke acaramu?

                    <br><br>

                    <x-form-link form="booking" class="contact-link">
                        Formulir booking acara →
                    </x-form-link>

                </p>

            </div>


        </aside>


    </div>

</div>
@endsection
