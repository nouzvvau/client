@extends('layouts.main')

@section('title', __('ui.meta.beranda.title'))
@section('description', __('ui.meta.beranda.description'))
@section('page', 'beranda')
@section('activeNav', 'beranda')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/beranda.css') }}">
    <style>
        .program-image-placeholder {
            width: 100%;
            height: 100%;
            min-height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f1f1;
            color: #999;
        }

        .program-image-placeholder svg {
            width: 56px;
            height: 56px;
        }
    </style>
@endpush

@section('content')

    {{-- HERO SECTION --}}
    <section class="hero" id="beranda">
        <div class="hero-container">

            <div class="hero-content">
                <span class="eyebrow">
                    {{ __('ui.beranda.eyebrow') }}
                </span>

                <h1>Cakra Aji</h1>

                <p>
                    {{ __('ui.beranda.intro') }}
                </p>
                <p class="alumni-text">
                    {{ __('ui.beranda.alumni') }}
                </p>

                <div class="hero-buttons">
                    <x-form-link form="registration" class="btn btn-gold">
                        {{ __('ui.beranda.register_cta') }}
                    </x-form-link>

                    <x-form-link form="booking" class="btn btn-cream">
                        {{ __('ui.beranda.booking_cta') }}
                    </x-form-link>

                    <a href="{{ url('/tentang-kami') }}" class="btn btn-outline">
                        {{ __('ui.beranda.know_us') }}
                    </a>
                </div>
            </div>

            <div class="hero-image">
                <img
                    src="{{ asset('assets/images/logo-navbar.png') }}"
                    alt="{{ __('ui.beranda.logo_alt') }}"
                >
            </div>

        </div>
    </section>


    {{-- PROGRAM SECTION --}}
    <section class="program-section" id="program">
        <div class="section-container">

            <div class="section-heading">
                <div>
                    <span class="eyebrow red-text">
                        {{ __('ui.beranda.program_eyebrow') }}
                    </span>

                    <h2>
                        {{ __('ui.beranda.program_title') }}
                    </h2>
                </div>

                <a href="{{ route('program') }}" class="see-all">
                    {{ __('ui.common.see_all_programs') }} →
                </a>
            </div>


            {{-- PROGRAM GRID --}}
            <div class="program-grid">

                @foreach ($programs as $program)
                    @php
                        $thumbnail = $program->thumbnail_photo;
                    @endphp

                    <article class="program-card">

                        {{-- FOTO PROGRAM --}}
                        <div class="program-image">
                            @if ($thumbnail)
                                <img
                                    src="{{ $thumbnail->url }}"
                                    alt="{{ $program->localized_name }}"
                                    loading="lazy"
                                >
                            @else
                                <div
                                    class="program-image-placeholder"
                                    aria-label="Belum ada foto thumbnail"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        aria-hidden="true"
                                    >
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <path d="m21 15-5-5L5 21" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- KONTEN PROGRAM --}}
                        <div class="program-content">

                            @if (!empty($program->year))
                                <span class="program-tag">
                                    {{ $program->year }}
                                </span>
                            @endif

                            <h3>
                                {{ $program->localized_name }}
                            </h3>

                            <p>
                                {{ Str::limit($program->localized_description ?? '', 100) }}
                            </p>

                            <a
                                href="{{ route('program.detail', ['slug' => $program->slug]) }}"
                                class="program-link"
                            >
                                {{ __('ui.common.read_more') }} →
                            </a>

                        </div>
                    </article>
                @endforeach


                {{-- PROGRAM LAINNYA --}}
                <article class="other-program">

                    <span>
                        {{ __('ui.beranda.other_eyebrow') }}
                    </span>

                    <h3>
                        {{ __('ui.beranda.other_title_1') }}<br>
                        {{ __('ui.beranda.other_title_2') }}
                    </h3>

                    <p>
                        {{ __('ui.beranda.other_desc') }}
                    </p>

                    <a
                        href="{{ route('galeri') }}#jadwal"
                        class="btn btn-gold"
                    >
                        {{ __('ui.beranda.other_cta') }}
                    </a>

                </article>

            </div>
        </div>
    </section>


    {{-- BOOKING SECTION --}}
    <section class="booking-section" id="booking">
        <div class="section-container">

            <div class="booking-content">
                <span class="eyebrow">
                    {{ __('ui.beranda.booking_eyebrow') }}
                </span>

                <h2>
                    {{ __('ui.beranda.booking_title_1') }}
                    {{ __('ui.beranda.booking_title_2') }}
                </h2>

                <p>
                    {{ __('ui.beranda.booking_desc') }}
                </p>

                <x-form-link form="booking" class="btn btn-gold">
                    {{ __('ui.beranda.booking_cta') }}
                </x-form-link>
            </div>

        </div>
    </section>

@endsection