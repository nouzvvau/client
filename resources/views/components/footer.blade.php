{{-- Footer standar --}}
{{-- Variabel opsional: $footerKontakAnchor (bool) --}}
<footer class="footer" @if($footerKontakAnchor ?? false) id="kontak" @endif>

    <div class="footer-container">

        <!-- BRAND -->
        <div class="footer-brand">

            <img src="{{ asset('assets/images/logo-footer.png') }}"
                 alt="{{ __('ui.common.logo_alt') }}">

            <p>
                {{ __('ui.footer.tagline') }}
            </p>

        </div>

        <!-- MENU -->
        <div class="footer-menu">

            <h4>{{ __('ui.footer.menu') }}</h4>

            <a href="{{ url('/') }}">{{ __('ui.nav.home') }}</a>
            <a href="{{ url('/tentang-kami') }}">{{ __('ui.nav.about') }}</a>
            <a href="{{ url('/pengurus') }}">Profil</a>
            <a href="{{ route('program') }}">{{ __('ui.nav.programs') }}</a>
            <a href="{{ route('galeri') }}">{{ __('ui.nav.gallery') }}</a>
            <a href="{{ route('kontak') }}">{{ __('ui.nav.contact') }}</a>
            <a href="{{ route('faq') }}">Tanya Jawab</a>
            <a href="{{ url('/lokasi') }}">Lokasi</a>

        </div>

        <!-- TEAM -->
        <div class="footer-team">

            <h4>{{ __('ui.footer.builder') }}</h4>

            <p>{{ __('ui.footer.builder_school') }}</p>

            <ul>
                <li>BYAN</li>
                <li>NAZ</li>
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