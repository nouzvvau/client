@extends('layouts.main')

@section('title', 'Tentang Kami | Sanggar Seni Cakra Aji')
@section('description', 'Profil, sejarah, visi, dan misi Sanggar Seni Cakra Aji, ruang pelestarian musik tradisi dan kontemporer di Tulungagung.')
@section('page', 'tentang')
@section('activeNav', 'tentang')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/tentang-kami.css') }}">
@endpush

@push('scripts')
  <script src="{{ asset('assets/js/script2.js') }}" defer></script>
@endpush

@section('content')
  <div class="main-content" id="tentang">
        <!-- JUDUL HALAMAN -->

        <section class="page-heading">

            <span class="section-label">
                TENTANG KAMI
            </span>

            <h1>
                Dari satu bunyi,<br>
                tumbuh satu ruang.
            </h1>

        </section>


        <!-- ================= PROFIL & SEJARAH ================= -->

        <section class="profile-card">

            <!-- LOGO SEBELAH KIRI -->

            <div class="profile-image">

                <img src="{{ asset('assets/images/logo-footer.png') }}"
                     alt="Logo Cakra Aji">

            </div>


            <!-- TEKS SEBELAH KANAN -->

            <div class="profile-content">

                <span class="profile-label">
                    PROFIL & SEJARAH
                </span>

                <h2>
                    Perjalanan Cakra Aji
                </h2>

                <p>
                    Pada tahun 2020, saat saya semester 5 di ISI Surakarta,
                    terlintas sebuah pemikiran dalam diri saya:
                </p>

                <blockquote>
                    <p>
                        "Kabupaten Tulungagung memiliki potensi kesenian yang
                        sangat kaya serta Sumber Daya Manusia (SDM) yang luar
                        biasa lintas generasi, mulai dari generasi muda hingga
                        para senior. Setiap tahunnya, Tulungagung juga rutin
                        menyelenggarakan berbagai perlombaan, khususnya seni
                        karawitan."
                    </p>
                </blockquote>

                <p>
                    Namun, di balik besarnya potensi tersebut, timbul sebuah
                    keprihatinan. Banyak penabuh kendang yang berbakat, tetapi
                    ingatan ketukan kendang mereka hanya sebatas per lagu.
                </p>

                <p>
                    Begitu pula dengan para pesinden yang belum sepenuhnya
                    siap ketika disajikan beragam jenis gendhing secara
                    spontan, karena cenderung harus menghafal terlebih dahulu
                    sebelum membawakannya.
                </p>

                <p>
                    Setelah dicermati, kendala utamanya terletak pada metode
                    pembelajaran. Saat itu, belum ada sanggar maupun forum
                    kesenian di Tulungagung yang menerapkan metode pembelajaran
                    secara terstruktur dan sistematis. Mulai dari tingkat
                    dasar hingga mahir, yang mencakup praktik, teori, serta
                    pemahaman konsep seni secara menyeluruh.
                </p>

                <p>
                    Berangkat dari keprihatinan tersebut, saya bersama
                    rekan-rekan berinisiatif mendirikan Sanggar Cakra Aji.
                </p>

                <p>
                    Tujuan awal kami sederhana namun mendasar yaitu
                    menyediakan forum dan sarana pembelajaran kesenian yang
                    terstruktur serta sistematis, sehingga para peserta dapat
                    menjadi seniman karawitan yang mahir, kompeten, dan
                    memiliki pemahaman mendalam secara teoritis maupun praktis.
                </p>

            </div>

        </section>


        <!-- ================= VISI DAN MISI ================= -->

        <section class="vision-mission">

            <!-- KOTAK VISI -->

            <div class="vision-card">

                <h2>VISI</h2>

                <p>
                    Menciptakan ruang edukasi dan pembinaan bakat di bidang
                    kesenian khususnya karawitan, guna membentuk generasi
                    seniman muda masa depan yang kompeten secara teoritis,
                    praktis, dan konseptual, serta mampu mengimplementasikan
                    nilai-nilai esensial karawitan seperti adab, etika,
                    dan tata krama dalam kehidupan sehari-hari.
                </p>

            </div>


            <!-- KOTAK MISI -->

            <div class="mission-card">

                <h2>MISI</h2>

                <ol>

                    <li>
                        Melestarikan Budaya: Menanamkan rasa cinta dan
                        kepedulian siswa terhadap seni tradisional Indonesia,
                        khususnya karawitan.
                    </li>

                    <li>
                        Mengembangkan Bakat & Potensi: Menumbuhkan minat,
                        bakat, serta kecerdasan siswa di bidang seni karawitan.
                    </li>

                    <li>
                        Membentuk Karakter & Kedisiplinan: Melatih ketepatan
                        waktu, etika, sopan santun, rasa tanggung jawab,
                        dan solidaritas antar sesama.
                    </li>

                </ol>

            </div>

        </section>


     <!-- =====================================
         AJAKAN DAFTAR NAMA MURID
    ====================================== -->

    <section class="student-section">

        <div class="student-card">

            <div class="student-text">
                <h2>Mengenal para penerus seni tradisi</h2>

                <p>
                    Daftar resmi seluruh murid aktif Sanggar Karawitan Cakra Aji
                </p>
            </div>

            <a href="{{ route('murid.index') }}" class="student-button">
                Daftar Nama Murid →
            </a>

        </div>

    </section>


    <!-- =====================================
         LOKASI SANGGAR
    ====================================== -->

    <section class="location-section">

        <div class="location-container">

            <div class="location-text">

                <span class="location-label">
                    LOKASI SANGGAR
                </span>

                <h2>
                    Ingin datang ke Sanggar Cakra Aji?<br>
                    Yukk.. segera cek lokasinya.
                </h2>

                <p>
                    Sanggar Karawitan Cakra Aji hadir di dua lokasi tempat latihan<br>
                    untuk memudahkan Anda mempelajari dan melestarikan seni karawitan.
                </p>

            </div>

            <a href="{{ route('lokasi') }}" class="location-button">
                Info alamat sanggar →
            </a>

        </div>

        </section>

    </div>
@endsection
