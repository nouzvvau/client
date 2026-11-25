
@extends('layouts.main')

@section('title', __('ui.meta.pengurus.title'))
@section('description', __('ui.meta.pengurus.description'))
@section('page', 'pengurus')
@section('activeNav', 'tentang')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pengurus.css') }}">
@endpush

@section('content')

{{-- ============================= --}}
{{-- HEADER PENGURUS --}}
{{-- ============================= --}}

<section class="about-section">

    <p class="section-label">
        {{ __('ui.pengurus.label') }}
    </p>

    <h1 class="main-title">
        {{ __('ui.pengurus.title_1') }}<br>
        {{ __('ui.pengurus.title_2') }}
    </h1>

    <p class="main-description">
        {{ __('ui.pengurus.description') }}
    </p>

</section>


{{-- ============================= --}}
{{-- PROFIL PENDIRI / TOTTI --}}
{{-- ============================= --}}

<section class="founder-section">

    <div class="founder-layout">

        {{-- KOLOM KIRI --}}
        <div class="founder-sidebar">

            {{-- KARTU FOTO --}}
            <div class="founder-photo-card">

                <div class="founder-photo">
                    <span class="founder-initials">TW</span>
                    <span class="founder-photo-caption">
                        GANTI DENGAN FOTO
                    </span>
                </div>

                <div class="founder-photo-info">
                    <h2>Totti Wahyu Bathara</h2>
                    <span class="founder-role">Pembina</span>
                </div>

            </div>

            {{-- INFORMASI PROFIL TERPISAH --}}
            <div class="founder-extra-info">

                <div class="founder-info-group">
                    <h3>AKRAB DISAPA</h3>
                    <p>Totti</p>
                </div>

                <div class="founder-info-group">
                    <h3>KEAHLIAN</h3>

                    <div class="expertise-list">
                        <span>Pelinting Bunyi (Komposer)</span>
                        <span>Music Director &amp; Producer</span>
                        <span>Musisi</span>
                    </div>
                </div>

                <div class="founder-info-group education-group">
                    <h3>RIWAYAT PENDIDIKAN</h3>

                    <div class="education-item">
                        <strong>2022</strong>
                        <div>
                            <b>Sarjana Seni</b>
                            <small>Institut Seni Indonesia Surakarta</small>
                        </div>
                    </div>

                    <div class="education-item">
                        <strong>2025</strong>
                        <div>
                            <b>Magister Seni</b>
                            <small>Institut Seni Indonesia Surakarta</small>
                        </div>
                    </div>

                </div>

            </div>

        </div>


        {{-- KOLOM KANAN --}}
        <div class="founder-content">

            <div class="founder-heading">

                <p class="section-label">
                    PENDIRI / PIMPINAN
                </p>

                <h2>Totti Wahyu Bathara, M.Sn.</h2>

                <p class="founder-nickname">
                    Akrab disapa <strong>Totti</strong>
                </p>

            </div>


            {{-- ALASAN DAN HARAPAN --}}
            <div class="founder-story-grid">

                <div class="story-card">

                    <h3>ALASAN MENDIRIKAN SANGGAR</h3>

                    <p>
                        Saat berkuliah di ISI Surakarta pada 2020,
                        saya melihat besar potensinya karawitan di
                        Tulungagung. Namun, pembelajarannya masih
                        sebatas hafalan lagu tanpa pemahaman teori
                        dan konsep. Melihat hal itu, saya mendirikan
                        Sanggar Cakra Aji untuk menyediakan wadah
                        belajar karawitan yang terstruktur dan
                        sistematis — mulai dari dasar hingga mahir,
                        baik secara teori maupun praktik.
                    </p>

                </div>


                <div class="story-card">

                    <h3>HARAPAN KE DEPAN</h3>

                    <p>
                        Semoga sanggar ini terus berkembang menjadi
                        acuan dan sumber inspirasi bagi generasi muda
                        maupun senior. Dengan terus beradaptasi secara
                        digital serta menghadirkan metode pembelajaran
                        yang inovatif, sanggar ini diharapkan mampu
                        mencetak generasi seniman karawitan yang unggul
                        dan kompeten di masa depan.
                    </p>

                </div>

            </div>


            {{-- SOSIAL MEDIA --}}
            <div class="founder-social">

                <h3>SOSIAL MEDIA</h3>

                <div class="social-grid">

                    <a href="https://www.instagram.com/twbathara/"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="social-link">

                        <span class="social-icon">◎</span>
                        <span>Instagram @Twbathara</span>

                    </a>

                    <a href="https://www.tiktok.com/@tottiwahyu"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="social-link">

                        <span class="social-icon">♪</span>
                        <span>TikTok @tottiwahyu</span>

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- ============================= --}}
{{-- PELATIH DAN ADMIN --}}
{{-- ============================= --}}

<section class="team-section">

    <p class="section-label team-label">
        {{ __('ui.pengurus.team_label') }}
    </p>

    <div class="team-grid">

        @foreach ($pengurus as $orang)

            <div class="team-card">

                <div class="team-photo {{ $orang['warna'] }}">

                    @if ($orang['foto'])

                        <img src="{{ asset($orang['foto']) }}"
                             alt="{{ $orang['nama'] }}">

                    @else

                        <span class="initials">
                            {{ $orang['inisial'] }}
                        </span>

                        <span class="photo-caption">
                            {{ __('ui.common.photo_replace') }}
                        </span>

                    @endif

                </div>

                <div class="team-info">

                    <h3 class="team-name">
                        {{ $orang['nama'] }}
                    </h3>

                    <span class="role {{ $orang['tipe'] === 'coach' ? 'yellow' : 'green' }}">
                        {{ $orang['jabatan'] }}
                    </span>

                </div>

            </div>

        @endforeach

    </div>

</section>


{{-- ============================= --}}
{{-- ASISTEN PELATIH --}}
{{-- ============================= --}}

<section class="assistant-section">

    <p class="section-label">
        {{ __('ui.pengurus.assistant_label') }}
    </p>

    <h2 class="assistant-title">
        {{ __('ui.pengurus.assistant_title') }}
    </h2>

    <div class="team-grid">

        @foreach ($asisten as $orang)

            <div class="team-card assistant-card">

                <div class="team-photo {{ $orang['warna'] }}">

                    @if ($orang['foto'])

                        <img src="{{ asset($orang['foto']) }}"
                             alt="{{ $orang['nama'] }}">

                    @else

                        <span class="initials">
                            {{ $orang['inisial'] }}
                        </span>

                        <span class="photo-caption">
                            {{ __('ui.common.photo_replace') }}
                        </span>

                    @endif

                </div>

                <div class="team-info">

                    <h3 class="team-name">
                        {{ $orang['nama'] }}
                    </h3>

                </div>

            </div>

        @endforeach

    </div>

</section>


{{-- ============================= --}}
{{-- DAFTAR SELURUH NAMA MURID --}}
{{-- ============================= --}}

<section class="cta-section">

    <div class="cta-box">

        <div>
            <h2 class="cta-title">
                Daftar Seluruh Nama Murid
            </h2>

            <p class="cta-description">
                Lihat daftar lengkap murid Sanggar Seni Cakra Aji.
            </p>
        </div>

        <x-form-link form="registration" class="cta-button">
            Selengkapnya
        </x-form-link>

    </div>

</section>

@endsection
