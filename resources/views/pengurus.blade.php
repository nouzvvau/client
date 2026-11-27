
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

<section class="founder-section">

    <div class="founder-layout">

        <div class="founder-sidebar">

            <div class="founder-photo-card">

                <div class="founder-photo">
                    <span class="founder-initials">TW</span>
                    <span class="founder-photo-caption">
                        {{ __('ui.common.photo_replace') }}
                    </span>
                </div>

                <div class="founder-photo-info">
                    <h2>Totti Wahyu Bathara</h2>
                    <span class="founder-role">
                        {{ __('ui.pengurus.mentor_label') }}
                    </span>
                </div>

            </div>

            <div class="founder-extra-info">

                <div class="founder-info-group">
                    <h3>{{ __('ui.pengurus.nickname_label') }}</h3>
                    <p>Totti</p>
                </div>

                <div class="founder-info-group">
                    <h3>{{ __('ui.pengurus.expertise_label') }}</h3>

                    <div class="expertise-list">
                        <span>{{ __('ui.pengurus.expertise_composer') }}</span>
                        <span>{{ __('ui.pengurus.expertise_music_director') }}</span>
                        <span>{{ __('ui.pengurus.expertise_musician') }}</span>
                    </div>
                </div>

                <div class="founder-info-group education-group">
                    <h3>{{ __('ui.pengurus.education_label') }}</h3>

                    <div class="education-item">
                        <strong>2022</strong>
                        <div>
                            <b>{{ __('ui.pengurus.degree_bachelor') }}</b>
                            <small>{{ __('ui.pengurus.institution') }}</small>
                        </div>
                    </div>

                    <div class="education-item">
                        <strong>2025</strong>
                        <div>
                            <b>{{ __('ui.pengurus.degree_master') }}</b>
                            <small>{{ __('ui.pengurus.institution') }}</small>
                        </div>
                    </div>

                </div>

            </div>

        </div>


        <div class="founder-content">

            <div class="founder-heading">

                <p class="section-label">
                    {{ __('ui.pengurus.founder_role') }}
                </p>

                <h2>Totti Wahyu Bathara, M.Sn.</h2>

                <p class="founder-nickname">
                    {{ __('ui.pengurus.nickname_intro') }}
                    <strong>Totti</strong>
                </p>

            </div>


            <div class="founder-story-grid">

                <div class="story-card">
                    <h3>{{ __('ui.pengurus.founder_reason_label') }}</h3>
                    <p>{{ __('ui.pengurus.founder_reason') }}</p>
                </div>

                <div class="story-card">
                    <h3>{{ __('ui.pengurus.future_hope_label') }}</h3>
                    <p>{{ __('ui.pengurus.future_hope') }}</p>
                </div>

            </div>


            <div class="founder-social">

                <h3>{{ __('ui.pengurus.social_media_label') }}</h3>

                <div class="social-grid">

                    <a href="https://www.instagram.com/twbathara/"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="social-link">

                        <span class="social-icon">◎</span>
                        <span>{{ __('ui.pengurus.instagram') }} @Twbathara</span>

                    </a>

                    <a href="https://www.tiktok.com/@tottiwb"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="social-link">

                        <span class="social-icon">♪</span>
                        <span>{{ __('ui.pengurus.tiktok') }} @tottiwb</span>

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
                        {{ $orang['tipe'] === 'coach'
                            ? __('ui.pengurus.role_coach')
                            : __('ui.pengurus.role_admin') }}
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
                {{ __('ui.pengurus.student_list_title') }}
            </h2>

            <p class="cta-description">
                {{ __('ui.pengurus.student_list_desc') }}
            </p>
        </div>

        <a href="{{ route('murid.index') }}" class="cta-button">
            {{ __('ui.common.read_more') }}
        </a>

    </div>

</section>

@endsection
