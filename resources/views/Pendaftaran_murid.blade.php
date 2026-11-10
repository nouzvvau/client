<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pendaftaran Murid | Cakra Aji</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --cream: #feffc4;
            --yellow: #ffbc4c;
            --green: #91a052;
            --brown: #3c1808;
            --white: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--cream);
            color: var(--brown);
        }

        /* NAVBAR */

        .navbar {
            background: var(--brown);
            border-bottom: 4px solid var(--yellow);
            padding: 18px 5%;
        }

        .nav-container {
            max-width: 1300px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .logo {
            color: var(--cream);
            font-family: 'Playfair Display', serif;
            font-size: 25px;
            font-weight: 700;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-links a {
            color: var(--cream);
            font-size: 11px;
            text-decoration: none;
            white-space: nowrap;
        }

        .nav-links a.active {
            background: var(--yellow);
            color: var(--brown);
            padding: 10px 18px;
            border-radius: 30px;
            font-weight: 700;
        }

        .nav-links a.booking {
            border: 1px solid var(--cream);
            padding: 9px 15px;
            border-radius: 30px;
        }

        /* MAIN */

        .main {
            max-width: 1300px;
            margin: auto;
            padding: 55px 5% 75px;
        }

        .heading {
            margin-bottom: 35px;
        }

        .heading-label {
            color: var(--green);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
        }

        .heading h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 4vw, 50px);
            line-height: 1.2;
            margin: 15px 0;
        }

        .heading p {
            max-width: 650px;
            font-size: 13px;
            line-height: 1.8;
        }

        .version {
            display: inline-block;
            background: var(--yellow);
            border: 1px solid var(--brown);
            padding: 6px 12px;
            font-size: 10px;
            margin-top: 15px;
        }

        /* CONTENT */

        .content {
            display: grid;
            grid-template-columns: minmax(0, 1.7fr) minmax(250px, 0.8fr);
            gap: 30px;
            align-items: start;
        }

        /* FORM */

        .form-card {
            background: var(--white);
            border: 1px solid var(--brown);
            box-shadow: 5px 5px 0 var(--yellow);
            padding: 30px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            margin-bottom: 25px;
        }

        .number {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--brown);
            color: var(--yellow);
            border-radius: 50%;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 9px;
        }

        .required {
            color: #c12727;
        }

        .helper {
            font-size: 10px;
            color: #777;
            margin-bottom: 9px;
            line-height: 1.7;
        }

        .form-control {
            width: 100%;
            min-height: 45px;
            padding: 12px 14px;
            border: 1px solid #8a7b70;
            background: white;
            color: var(--brown);
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            outline: none;
            border-radius: 0;
        }

        .form-control:focus {
            border-color: var(--yellow);
            box-shadow: 0 0 0 2px rgba(255, 188, 76, 0.3);
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
        }

        .form-divider {
            border: none;
            border-top: 1px solid #ddd;
            margin: 30px 0;
        }

        /* BUTTON */

        .submit-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            width: fit-content;
            background: var(--brown);
            color: var(--cream);
            border: 1px solid var(--brown);
            border-radius: 30px;
            padding: 14px 25px;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .submit-btn:hover {
            background: var(--yellow);
            color: var(--brown);
            transform: translateY(-2px);
        }

        .form-note {
            font-size: 10px;
            line-height: 1.8;
            color: #777;
            margin-top: 15px;
        }

        /* SIDEBAR */

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .side-card {
            background: white;
            border: 1px solid var(--brown);
            padding: 23px;
        }

        .side-card.dark {
            background: var(--brown);
            color: var(--cream);
            box-shadow: 4px 4px 0 var(--yellow);
        }

        .side-card.light {
            background: #f5f5d8;
        }

        .side-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 18px;
        }

        .side-list {
            list-style: none;
        }

        .side-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 10px;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .check {
            color: var(--yellow);
            font-weight: 700;
        }

        .step {
            min-width: 25px;
            height: 25px;
            background: var(--yellow);
            color: var(--brown);
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-weight: 700;
        }

        .side-list strong {
            display: block;
            font-size: 11px;
            margin-bottom: 5px;
        }

        .description {
            display: block;
            color: #777;
        }

        .dark .description {
            color: #e8d9c7;
        }

        .side-card p {
            font-size: 11px;
            line-height: 1.8;
        }

        .contact-link {
            color: var(--brown);
            font-weight: 700;
            text-decoration: underline;
            text-underline-offset: 4px;
        }

        /* ALERT */

        .alert {
            padding: 15px 20px;
            margin-bottom: 25px;
            font-size: 12px;
            line-height: 1.8;
            border: 1px solid var(--brown);
        }

        .alert-success {
            background: #e8f1d4;
        }

        .alert-error {
            background: #ffe1d8;
        }

        .error-text {
            display: block;
            color: #c12727;
            font-size: 10px;
            margin-top: 5px;
        }

        /* FOOTER */

        .footer {
            background: var(--brown);
            color: var(--cream);
            padding: 30px 5%;
        }

        .footer-container {
            max-width: 1300px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 23px;
            font-weight: 700;
        }

        .footer-text {
            font-size: 10px;
            line-height: 1.8;
            text-align: right;
        }

        /* TABLET */

        @media (max-width: 1000px) {

            .nav-container {
                flex-direction: column;
            }

            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .content {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* MOBILE */

        @media (max-width: 600px) {

            .navbar {
                padding: 18px 4%;
            }

            .nav-links {
                gap: 10px;
            }

            .nav-links a {
                font-size: 9px;
            }

            .nav-links a.active {
                padding: 8px 12px;
            }

            .nav-links a.booking {
                padding: 7px 10px;
            }

            .main {
                padding: 35px 5% 50px;
            }

            .heading h1 {
                font-size: 32px;
            }

            .heading p {
                font-size: 11px;
            }

            .form-card {
                padding: 20px 16px;
            }

            .section-title {
                font-size: 17px;
            }

            .sidebar {
                grid-template-columns: 1fr;
            }

            .submit-btn {
                width: 100%;
            }

            .footer-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .footer-text {
                text-align: left;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->

    <nav class="navbar">

        <div class="nav-container">

            <a href="/" class="logo">
                Cakra Aji
            </a>

            <div class="nav-links">

                <a href="/">Beranda</a>

                <a href="/tentang">Tentang Kami</a>

                <a href="/program">Program & Kegiatan</a>

                <a href="/galeri">Galeri</a>

                <a href="/kontak">Kontak</a>

                <a href="/pendaftaran" class="active">
                    Daftar Murid
                </a>

                <a href="/booking" class="booking">
                    Booking Acara
                </a>

            </div>

        </div>

    </nav>


    <!-- MAIN -->

    <main class="main">

        <!-- HEADING -->

        <section class="heading">

            <div class="heading-label">
                PENDAFTARAN MURID BARU
            </div>

            <span class="version">
                Versi A - Data masuk ke admin
            </span>

            <h1>
                Daftar jadi murid<br>
                Cakra Aji
            </h1>

            <p>
                Isi data calon murid di bawah ini.
                Cuma sekitar 3 menit.
                Tanda <span class="required">*</span>
                berarti wajib diisi.
            </p>

        </section>


        <!-- SUCCESS -->

        @if(session('success'))

            <div class="alert alert-success">

                ✓ {{ session('success') }}

                <br>

                Data pendaftaran berhasil disimpan.
                Admin akan menghubungi melalui WhatsApp.

            </div>

        @endif


        <!-- ERROR -->

        @if($errors->any())

            <div class="alert alert-error">

                Ada data yang belum sesuai.
                Silakan periksa kembali formulir.

            </div>

        @endif


        <!-- CONTENT -->

        <div class="content">


            <!-- FORM -->

            <section class="form-card">

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

                                <strong>Isi formulir ini</strong>

                                <span class="description">
                                    Lengkapi data calon murid dan wali.
                                </span>

                            </div>

                        </li>

                        <li>

                            <span class="step">2</span>

                            <div>

                                <strong>Tekan tombol kirim</strong>

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

                        <a href="/kontak" class="contact-link">
                            Kontak
                        </a>.

                    </p>

                </div>


                <!-- BOOKING -->

                <div class="side-card">

                    <p>

                        Ingin mengundang Cakra Aji ke acaramu?

                        <br><br>

                        <a href="/booking" class="contact-link">
                            Formulir booking acara →
                        </a>

                    </p>

                </div>


            </aside>


        </div>

    </main>


    <!-- FOOTER -->

    <footer class="footer">

        <div class="footer-container">

            <div class="footer-logo">
                Cakra Aji
            </div>

            <div class="footer-text">

                © {{ date('Y') }} Sanggar Seni Cakra Aji.

                Hak cipta dilindungi.

            </div>

        </div>

    </footer>


</body>

</html>