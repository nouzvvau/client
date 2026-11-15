{{-- Footer standar (acuan: beranda.blade.php) --}}
{{-- Variabel opsional: $footerKontakAnchor (bool) — set true bila halaman memakai #kontak yang menunjuk footer --}}
<footer class="footer" @if($footerKontakAnchor ?? false) id="kontak" @endif>

    <div class="footer-container">

        <!-- BRAND -->
        <div class="footer-brand">

            <img src="{{ asset('assets/images/logo-footer.png') }}"
                 alt="Logo Sanggar Cakra Aji">

            <p>
                Ruang pelestarian musik tradisi dan kontemporer.
            </p>

        </div>


        <!-- MENU -->
        <div class="footer-menu">

            <h4>MENU</h4>

            <a href="{{ url('/') }}">Beranda</a>
            <a href="{{ url('/tentang-kami') }}">Tentang Kami</a>
            <a href="{{ route('program') }}">Program &amp; Kegiatan</a>
            <a href="{{ route('galeri') }}">Galeri</a>
            <a href="{{ route('lokasi') }}">Kontak</a>

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
