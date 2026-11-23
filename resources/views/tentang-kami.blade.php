@extends('layouts.main')

@section('title', __('ui.meta.tentang.title'))
@section('description', __('ui.meta.tentang.description'))
@section('page', 'tentang')
@section('activeNav', 'tentang')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/tentang-kami.css') }}">
@endpush

@section('content')
    <div class="main-content" id="tentang">

        {{-- JUDUL HALAMAN --}}
        <section class="page-heading">

            <span class="section-label">
                {{ __('ui.tentang.label') }}
            </span>

            <h1>
                {{ __('ui.tentang.title_1') }}<br>
                {{ __('ui.tentang.title_2') }}
            </h1>

        </section>


        {{-- PROFIL & SEJARAH --}}
        <section class="profile-card">

            {{-- LOGO SEBELAH KIRI --}}
            <div class="profile-image">
                <img
                    src="{{ asset('assets/images/logo-footer.png') }}"
                    alt="{{ __('ui.tentang.logo_alt') }}"
                >
            </div>

            {{-- TEKS SEBELAH KANAN --}}
            <div class="profile-content">

                <span class="profile-label">
                    {{ __('ui.tentang.profile_label') }}
                </span>

                <h2>
                    {{ __('ui.tentang.profile_title') }}
                </h2>

                <p>
                    {{ __('ui.tentang.p1') }}
                </p>

                <blockquote>
                    <p>
                        {{ __('ui.tentang.quote') }}
                    </p>
                </blockquote>

                <p>
                    {{ __('ui.tentang.p2') }}
                </p>

                <p>
                    {{ __('ui.tentang.p3') }}
                </p>

                <p>
                    {{ __('ui.tentang.p4') }}
                </p>

                <p>
                    {{ __('ui.tentang.p5') }}
                </p>

                <p>
                    {{ __('ui.tentang.p6') }}
                </p>

            </div>

        </section>


        {{-- VISI DAN MISI --}}
        <section class="vision-mission">

            {{-- KOTAK VISI --}}
            <div class="vision-card">

                <h2>
                    {{ __('ui.tentang.vision_title') }}
                </h2>

                <p>
                    {{ __('ui.tentang.vision_text') }}
                </p>

            </div>

            {{-- KOTAK MISI --}}
            <div class="mission-card">

                <h2>
                    {{ __('ui.tentang.mission_title') }}
                </h2>

                <ol>
                    <li>
                        {{ __('ui.tentang.mission_1') }}
                    </li>

                    <li>
                        {{ __('ui.tentang.mission_2') }}
                    </li>

                    <li>
                        {{ __('ui.tentang.mission_3') }}
                    </li>
                </ol>

            </div>

        </section>


        {{-- AJAKAN MELIHAT DAFTAR MURID --}}
        <section class="student-section">

            <div class="student-card">

                <div class="student-text">
                    <h2>
                        {{ __('ui.tentang.student_title') }}
                    </h2>

                    <p>
                        {{ __('ui.tentang.student_desc') }}
                    </p>
                </div>

                <a href="{{ route('murid.index') }}" class="student-button">
                    {{ __('ui.tentang.student_cta') }}
                </a>

            </div>

        </section>


        {{-- LOKASI SANGGAR --}}
        <section class="location-section">

            <div class="location-container">

                <div class="location-text">

                    <span class="location-label">
                        {{ __('ui.tentang.location_label') }}
                    </span>

                    <h2>
                        {{ __('ui.tentang.location_title_1') }}<br>
                        {{ __('ui.tentang.location_title_2') }}
                    </h2>

                    <p>
                        {{ __('ui.tentang.location_desc') }}
                    </p>

                </div>

                <a href="{{ route('lokasi') }}" class="location-button">
                    {{ __('ui.tentang.location_cta') }}
                </a>

            </div>

        </section>

    </div>
@endsection