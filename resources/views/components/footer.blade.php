{{-- Footer standar (acuan: beranda.blade.php) --}}
{{-- Variabel opsional: $footerKontakAnchor (bool) — set true bila halaman memakai #kontak yang menunjuk footer --}}
<footer class="footer" @if($footerKontakAnchor ?? false) id="kontak" @endif>

    <div class="footer-container">

        <!-- BRAND -->
        <div class="footer-brand">

            <img src="{{ asset('assets/images/logo-footer.png') }}"
                 alt="Logo Sanggar Cakra Aji">

            <p>
                {{ __('ui.footer.tagline') }}
            </p>

        </div>


        <!-- MENU -->
        <div class="footer-menu">

            <h4>{{ __('ui.footer.menu') }}</h4>

            <a href="{{ url('/') }}">{{ __('ui.nav.home') }}</a>
            <a href="{{ url('/tentang-kami') }}">{{ __('ui.nav.about') }}</a>
            <a href="{{ route('program') }}">{{ __('ui.nav.programs') }}</a>
            <a href="{{ route('galeri') }}">{{ __('ui.nav.gallery') }}</a>
            <a href="{{ route('kontak') }}">{{ __('ui.nav.contact') }}</a>

        </div>


        <!-- TEAM -->
        <div class="footer-team">

            <h4>{{ __('ui.footer.builder') }}</h4>

            <p>{{ __('ui.footer.builder_school') }}</p>

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
        <p>{{ __('ui.footer.copyright') }}</p>
    </div>

</footer>
