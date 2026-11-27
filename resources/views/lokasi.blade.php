
@extends('layouts.main')

@section('title', __('ui.meta.lokasi.title'))
@section('description', __('ui.meta.lokasi.description'))
@section('page', 'lokasi')
@section('activeNav', 'lokasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lokasi.css') }}">
@endpush

@section('content')
    {{-- HERO --}}
    <section class="hero" aria-labelledby="hero-title">
        <div class="container">
            <p class="eyebrow eyebrow--red">
                {{ __('ui.lokasi.hero_eyebrow') }}
            </p>

            <h1 class="hero__title" id="hero-title">
                {{ __('ui.lokasi.hero_title_1') }}<br>
                {{ __('ui.lokasi.hero_title_2') }}
            </h1>

            <p class="hero__lead">
                {{ __('ui.lokasi.hero_lead') }}
            </p>
        </div>
    </section>

    {{-- DAFTAR LOKASI --}}
    <section class="locations" id="lokasi" aria-labelledby="locations-title">
        <div class="container">
            <h2 class="sr-only" id="locations-title">
                {{ __('ui.lokasi.locations_title') }}
            </h2>

            <div class="location-grid">

                {{-- LOKASI 1: BEJI --}}
                <article class="location-card">
                    <div
                        class="location-map location-map--pending"
                        role="img"
                        aria-label="{{ __('ui.lokasi.beji_map_aria') }}">

                        <span class="location-pin" aria-hidden="true">1</span>

                        <div class="location-map__pending-text">
                            <strong>
                                {{ __('ui.common.map_coming_soon') }}
                            </strong>

                            <span>
                                {{ __('ui.lokasi.beji_map_desc') }}
                            </span>
                        </div>
                    </div>

                    <div class="location-card__body">
                        <span class="location-card__tag">
                            {{ __('ui.lokasi.location_label', ['number' => 1]) }}
                        </span>

                        <h3 class="location-card__title">
                            {{ __('ui.lokasi.beji_name') }}
                        </h3>

                        <dl class="location-facts">
                            <div>
                                <dt>{{ __('ui.common.address') }}</dt>
                                <dd>
                                    {{ __('ui.lokasi.beji_address') }}
                                </dd>
                            </div>

                            <div>
                                <dt>{{ __('ui.common.practice_groups') }}</dt>
                                <dd>
                                    <ul class="location-groups">
                                        <li>{{ __('ui.lokasi.groups.dasar_2c') }}</li>
                                        <li>{{ __('ui.lokasi.groups.madya_1') }}</li>
                                        <li>{{ __('ui.lokasi.groups.dasar_2b') }}</li>
                                    </ul>
                                </dd>
                            </div>

                            <div>
                                <dt>{{ __('ui.common.schedule') }}</dt>
                                <dd>
                                    {{ __('ui.lokasi.beji_schedule') }}
                                </dd>
                            </div>

                            <div>
                                <dt>{{ __('ui.lokasi.guide_label') }}</dt>
                                <dd>
                                    {{ __('ui.lokasi.beji_guide') }}
                                </dd>
                            </div>
                        </dl>

                        <div class="location-actions">
                            <a class="btn btn--outline-brown" href="#kontak">
                                {{ __('ui.common.ask_location') }}
                            </a>
                        </div>
                    </div>
                </article>

                {{-- LOKASI 2: PLOSOKANDANG --}}
                <article class="location-card">
                    <div class="location-map">
                        <span class="location-pin" aria-hidden="true">2</span>

                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3950.249198233089!2d111.9205559!3d-8.0760474!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78e3007c0fba43%3A0x7166363c489ecc1e!2sSanggar%20Karawitan%20Cakra%20Aji%2C%20Cabang%20Plosokandang!5e0!3m2!1sid!2sid!4v1795668788907!5m2!1sid!2sid"
                            title="{{ __('ui.lokasi.plosokandang_map_title') }}"
                            loading="lazy"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allowfullscreen>
                        </iframe>
                    </div>

                    <div class="location-card__body">
                        <span class="location-card__tag">
                            {{ __('ui.lokasi.location_label', ['number' => 2]) }}
                        </span>

                        <h3 class="location-card__title">
                            {{ __('ui.lokasi.plosokandang_name') }}
                        </h3>

                        <dl class="location-facts">
                            <div>
                                <dt>{{ __('ui.common.address') }}</dt>
                                <dd>
                                    {{ __('ui.lokasi.plosokandang_address') }}
                                </dd>
                            </div>

                            <div>
                                <dt>{{ __('ui.common.practice_groups') }}</dt>
                                <dd>
                                    <ul class="location-groups">
                                        <li>{{ __('ui.lokasi.groups.mahir') }}</li>
                                        <li>{{ __('ui.lokasi.groups.dasar_1a') }}</li>
                                        <li>{{ __('ui.lokasi.groups.dasar_1b') }}</li>
                                        <li>{{ __('ui.lokasi.groups.dasar_2a') }}</li>
                                        <li>{{ __('ui.lokasi.groups.madya_2') }}</li>
                                    </ul>
                                </dd>
                            </div>

                            <div>
                                <dt>{{ __('ui.common.schedule') }}</dt>
                                <dd>
                                    {{ __('ui.lokasi.plosokandang_schedule') }}
                                </dd>
                            </div>

                            <div>
                                <dt>{{ __('ui.lokasi.guide_label') }}</dt>
                                <dd>
                                    {{ __('ui.lokasi.plosokandang_guide') }}
                                </dd>
                            </div>
                        </dl>

                        <div class="location-actions">
                            <a
                                class="btn btn--brown"
                                href="https://maps.app.goo.gl/6WFmpALAXroBMsF1A"
                                target="_blank"
                                rel="noopener">
                                {{ __('ui.common.open_maps') }}
                            </a>

                            <a
                                class="btn btn--outline-brown"
                                href="https://maps.app.goo.gl/6WFmpALAXroBMsF1A"
                                target="_blank"
                                rel="noopener">
                                {{ __('ui.common.directions') }}
                            </a>
                        </div>
                    </div>
                </article>

            </div>

            {{-- LOCATION NOTE --}}
            <p class="location-note">
                {{ __('ui.lokasi.note') }}
            </p>
        </div>
    </section>
@endsection
