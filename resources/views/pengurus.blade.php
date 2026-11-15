@extends('layouts.main')

@section('title', 'Pengurus | Sanggar Seni Cakra Aji')
@section('description', 'Pelatih, asisten, dan admin Sanggar Seni Cakra Aji yang menemani setiap latihan.')
@section('page', 'pengurus')
@section('activeNav', 'tentang')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/pengurus.css') }}">
@endpush

@push('scripts')
  <script src="{{ asset('assets/js/script2.js') }}" defer></script>
@endpush

@section('content')
{{-- BAGIAN PENGURUS --}}
<section class="about-section">

    <p class="section-label">Pengurus</p>

    <h1 class="main-title">
        Tangan-tangan yang<br>
        merawat bunyi.
    </h1>

    <p class="main-description">
        Pelatih, asisten, dan admin yang menemani setiap latihan
        di Sanggar Seni Cakra Aji.
    </p>

    <p class="section-label team-label">
        Pelatih & Admin
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
                            GANTI DENGAN FOTO
                        </span>
                    @endif

                </div>

                <div class="team-info">

                    <h3 class="team-name">
                        {{ $orang['nama'] }}
                    </h3>

                    <span class="role {{ $orang['jabatan'] === 'Pelatih' ? 'yellow' : 'green' }}">
                        {{ $orang['jabatan'] }}
                    </span>

                </div>

            </div>

        @endforeach

    </div>

</section>


{{-- BAGIAN ASISTEN PELATIH --}}
<section class="assistant-section">

    <p class="section-label">
        Bersama Para Pelatih
    </p>

    <h2 class="assistant-title">
        Asisten Pelatih
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
                            GANTI DENGAN FOTO
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


{{-- AJAKAN MENDAFTAR --}}
<section class="cta-section">

    <div class="cta-box">

        <div>
            <h2 class="cta-title">
                Ingin ikut berlatih bersama kami?
            </h2>

            <p class="cta-description">
                Daftar jadi murid dan mulai belajar karawitan
                di Sanggar Seni Cakra Aji.
            </p>
        </div>

        <a href="{{ route('pendaftaran.index') }}" class="cta-button">
            Daftar Murid
        </a>

    </div>

</section>
@endsection
