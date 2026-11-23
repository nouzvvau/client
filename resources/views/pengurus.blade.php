@extends('layouts.main')

@section('title', __('ui.meta.pengurus.title'))
@section('description', __('ui.meta.pengurus.description'))
@section('page', 'pengurus')
@section('activeNav', 'tentang')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pengurus.css') }}">
@endpush

@section('content')

{{-- BAGIAN PENGURUS --}}
<section class="about-section">

    <p class="section-label">{{ __('ui.pengurus.label') }}</p>

    <h1 class="main-title">
        {{ __('ui.pengurus.title_1') }}<br>
        {{ __('ui.pengurus.title_2') }}
    </h1>

    <p class="main-description">
        {{ __('ui.pengurus.description') }}
    </p>

    <p class="section-label team-label">
        {{ __('ui.pengurus.team_label') }}
    </p>

    <div class="team-grid">

        @foreach ($pengurus as $orang)
            <div class="team-card">

                <div class="team-photo {{ $orang['warna'] }}">

                    @if ($orang['foto'])
                        <img
                            src="{{ asset($orang['foto']) }}"
                            alt="{{ $orang['nama'] }}"
                        >
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

                    <span class="role {{ ($orang['tipe'] ?? '') === 'coach' ? 'yellow' : 'green' }}">
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
                        <img
                            src="{{ asset($orang['foto']) }}"
                            alt="{{ $orang['nama'] }}"
                        >
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


{{-- AJAKAN MENDAFTAR --}}
<section class="cta-section">

    <div class="cta-box">

        <div>
            <h2 class="cta-title">
                {{ __('ui.pengurus.cta_title') }}
            </h2>

            <p class="cta-description">
                {{ __('ui.pengurus.cta_desc') }}
            </p>
        </div>

        <x-form-link form="registration" class="cta-button">
            {{ __('ui.pengurus.cta_button') }}
        </x-form-link>

    </div>

</section>
@endsection