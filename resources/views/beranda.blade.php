
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sanggar Seni Cakra Aji</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<!-- NAVBAR -->
<header class="navbar">
    <div class="nav-container">

        <a href="#" class="logo">
            <img src="assets/images/logo_Cakra_Aji.jpeg" alt="Logo Cakra Aji">
        </a>

        <div class="mobile-actions">
            <div class="language-switch">
                <button class="language-option active" data-lang="id">IDN</button>
                <button class="language-option" data-lang="en">ENG</button>
            </div>

            <button class="menu-toggle" id="menuToggle" aria-label="Buka menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>

        <nav class="nav-menu" id="navMenu">
            <a href="#beranda" class="active">Beranda</a>
            <a href="#tentang">Tentang Kami</a>
            <a href="#profil">Profil</a>
            <a href="#program">Program & Kegiatan</a>
            <a href="#galeri">Galeri</a>
            <a href="#kontak">Kontak</a>
            <a href="#faq">Tanya Jawab</a>
            <a href="#lokasi">Lokasi</a>

            <div class="nav-actions">
                <a href="#daftar" class="btn-daftar">Daftar Murid</a>
                <a href="#booking" class="btn-booking">Booking Acara</a>
            </div>

            <div class="language-switch">
                <button class="language-option active" data-lang="id">IDN</button>
                <button class="language-option" data-lang="en">ENG</button>
            </div>

        </nav>

    </div>
</header>


<!-- HERO SECTION -->
<section class="hero" id="beranda">

    <div class="hero-container">

        <div class="hero-content">

            <span class="eyebrow">SANGGAR SENI · SEJAK 2020</span>

            <h1>Cakra Aji</h1>

            <p>
                Sanggar Seni Cakra Aji adalah ruang pelestarian musik
                tradisi dan kontemporer. Di sini anak-anak, pemuda,
                dan masyarakat belajar, berlatih, dan berkarya bersama.
                Pintu kami terbuka untuk workshop, pentas, dan kolaborasi.
            </p>

            <div class="hero-buttons">
                <a href="#daftar" class="btn btn-gold">Daftar Jadi Murid</a>
                <a href="#booking" class="btn btn-cream">Booking Acara</a>
                <a href="#tentang" class="btn btn-outline">Kenali Sanggar</a>
            </div>

        </div>

        <div class="hero-image">
            <img src="assets/images/logo_Cakra_Aji.jpeg"
                 alt="Logo Sanggar Seni Cakra Aji">
        </div>

    </div>

</section>


<!-- PROGRAM SECTION -->
<section class="program-section" id="program">

    <div class="section-container">

        <div class="section-heading">

            <div>
                <span class="eyebrow red-text">SOROTAN PROGRAM</span>
                <h2>Tempat bunyi tumbuh</h2>
            </div>

            <a href="#galeri" class="see-all">
                Lihat semua program →
            </a>

        </div>


        <div class="program-grid">

            <!-- CARD 1 -->
            <article class="program-card card-green">

                <div class="program-image">
                    <img src="assets/images/kegiatan-1.jpg"
                         alt="Ruang edukasi dan workshop"
                         onerror="this.style.display='none'">
                    <span>[Foto kegiatan]</span>
                </div>

                <div class="program-content">

                    <span class="program-tag tag-green">EDUKASI</span>

                    <h3>Ruang Edukasi<br>& Workshop</h3>

                    <p>
                        Kelas dan workshop musik tradisi untuk
                        yang ingin mulai belajar.
                    </p>

                    <a href="#galeri">Selengkapnya →</a>

                </div>

            </article>


            <!-- CARD 2 -->
            <article class="program-card card-yellow">

                <div class="program-image">
                    <img src="assets/images/kegiatan-2.jpg"
                         alt="Kidung Bocah Tradisi"
                         onerror="this.style.display='none'">
                    <span>[Foto kegiatan]</span>
                </div>

                <div class="program-content">

                    <span class="program-tag tag-yellow">ANAK</span>

                    <h3>Kidung Bocah<br>Tradisi</h3>

                    <p>
                        Mengenalkan kidung dan bunyi tradisi
                        kepada anak-anak sejak dini.
                    </p>

                    <a href="#galeri">Selengkapnya →</a>

                </div>

            </article>


            <!-- CARD 3 -->
            <article class="program-card card-red">

                <div class="program-image">
                    <img src="assets/images/kegiatan-3.jpg"
                         alt="Grebek Kampung"
                         onerror="this.style.display='none'">
                    <span>[Foto kegiatan]</span>
                </div>

                <div class="program-content">

                    <span class="program-tag tag-red">PENTAS</span>

                    <h3>Grebek<br>Kampung</h3>

                    <p>
                        Pentas keliling dari kampung ke kampung
                        bersama warga.
                    </p>

                    <a href="#galeri">Selengkapnya →</a>

                </div>

            </article>


            <!-- CARD 4 -->
            <article class="other-program">

                <span>DAN LAINNYA</span>

                <h3>Latihan rutin &<br>project khusus</h3>

                <p>
                    Jadwal latihan dan proyek yang sedang berjalan
                    ada di halaman program.
                </p>

                <a href="#galeri" class="btn btn-gold">
                    Lihat jadwal
                </a>

            </article>

        </div>

    </div>

</section>


<!-- BOOKING SECTION -->
<section class="booking-section" id="booking">

    <div class="booking-container">

        <div class="booking-content">

            <span class="eyebrow">BOOKING ACARA</span>

            <h2>
                Undang Cakra Aji untuk mengisi<br class="desktop-break">
                acaramu
            </h2>

            <p>
                Pentas, workshop, atau pengisian acara lainnya.
                Isi formulir booking dan tim kami akan menghubungi kembali.
            </p>

            <a href="#daftar" class="booking-link">
                Ingin ikut belajar? Daftar jadi murid →
            </a>

        </div>

        <a href="#kontak" class="btn booking-button">
            Isi formulir booking →
        </a>

    </div>

</section>


<!-- FOOTER -->
<footer class="footer" id="kontak">

    <div class="footer-container">

        <!-- BRAND -->
        <div class="footer-brand">

            <img src="assets/images/logo_Cakra_Aji.jpeg"
                 alt="Logo Sanggar Cakra Aji">

            <p>
                Ruang pelestarian musik tradisi dan kontemporer.
            </p>

        </div>


        <!-- MENU -->
        <div class="footer-menu">

            <h4>MENU</h4>

            <a href="#beranda">Beranda</a>
            <a href="#tentang">Tentang Kami</a>
            <a href="#program">Program & Kegiatan</a>
            <a href="#galeri">Galeri</a>
            <a href="#kontak">Kontak</a>

        </div>


        <!-- TEAM -->
        <div class="footer-team">

            <h4>WEBSITE BUILDER</h4>

            <p>From students of SMKN 1 Boyolangu<br>
               majoring in Software Engineering</p>

            <ul>
                <li>BYAN</li>
                <li>ANWAR</li>
                <li>ZAHWA</li>
                <li>REN</li>
                <li>FLORIS</li>
            </ul>

        </div>

    </div>


    <div class="footer-bottom">
        <p>© 2026 Sanggar Seni Cakra Aji. Hak cipta dilindungi.</p>
    </div>

</footer>


<script src="js/script.js"></script>

</body>
</html>