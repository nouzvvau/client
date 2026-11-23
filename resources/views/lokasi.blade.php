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
            <p class="eyebrow eyebrow--red">{{ __('ui.lokasi.hero_eyebrow') }}</p>

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
                @if ($locations->isNotEmpty())

                    @foreach ($locations as $location)
                        @php
                            $mapsQuery = rawurlencode($location->address ?? $location->name);

                            $programNames = $location->schedules
                                ->filter(fn ($schedule) => $schedule->program)
                                ->map(fn ($schedule) => $schedule->program->name)
                                ->unique()
                                ->values();

                            $days = $location->schedules
                                ->pluck('day_of_week')
                                ->unique()
                                ->values()
                                ->map(fn ($day) => __($day))
                                ->implode(' '.__('ui.common.and').' ');
                        @endphp

                        <article class="location-card">
                            {{-- MAP --}}
                            <div class="location-map">
                                <span class="location-pin" aria-hidden="true">
                                    {{ $loop->iteration }}
                                </span>

                                @if ($location->google_maps_url || $location->address)
                                    <iframe
                                        src="https://www.google.com/maps?q={{ $mapsQuery }}&amp;output=embed"
                                        title="{{ __('ui.lokasi.map_title', ['name' => $location->name]) }}"
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        allowfullscreen>
                                    </iframe>
                                @else
                                    <div
                                        class="location-map location-map--pending"
                                        role="img"
                                        aria-label="{{ __('ui.lokasi.map_pending_aria', ['name' => $location->name]) }}">

                                        <span class="location-map__pending-text">
                                            <strong>{{ __('ui.common.map_coming_soon') }}</strong>
                                            <span>
                                                {{ __('ui.lokasi.map_pending_desc', ['name' => $location->name]) }}
                                            </span>
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- LOCATION INFORMATION --}}
                            <div class="location-card__body">
                                <span class="location-card__tag">
                                    {{ __('ui.lokasi.location_label', ['number' => $loop->iteration]) }}
                                </span>

                                <h3 class="location-card__title">
                                    {{ $location->name }}
                                </h3>

                                <dl class="location-facts">
                                    {{-- ADDRESS --}}
                                    <div>
                                        <dt>{{ __('ui.common.address') }}</dt>
                                        <dd>
                                            {{ $location->address ?? __('ui.lokasi.address_unavailable') }}
                                        </dd>
                                    </div>

                                    {{-- PROGRAM GROUP --}}
                                    <div>
                                        <dt>{{ __('ui.common.practice_groups') }}</dt>
                                        <dd>
                                            @if ($programNames->isNotEmpty())
                                                <ul class="location-groups">
                                                    @foreach ($programNames as $programName)
                                                        <li>{{ __($programName) }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <ul class="location-groups">
                                                    <li>{{ __('ui.lokasi.no_groups') }}</li>
                                                </ul>
                                            @endif
                                        </dd>
                                    </div>

                                    {{-- SCHEDULE --}}
                                    <div>
                                        <dt>{{ __('ui.common.schedule') }}</dt>
                                        <dd>
                                            {{ $days !== '' ? __('ui.lokasi.schedule_group', ['days' => $days]) : __('ui.lokasi.schedule_unavailable') }}
                                        </dd>
                                    </div>

                                    {{-- LOCATION GUIDE --}}
                                    <div>
                                        <dt>{{ __('ui.lokasi.guide_label') }}</dt>
                                        <dd>
                                            {{ $location->description ?? __('ui.lokasi.guide_unavailable') }}
                                        </dd>
                                    </div>
                                </dl>

                                {{-- MAP BUTTONS --}}
                                <div class="location-actions">
                                    @if ($location->address)
                                        <a
                                            class="btn btn--brown"
                                            href="https://www.google.com/maps/search/?api=1&amp;query={{ $mapsQuery }}"
                                            target="_blank"
                                            rel="noopener">
                                            {{ __('ui.common.open_maps') }}
                                        </a>

                                        <a
                                            class="btn btn--outline-brown"
                                            href="https://www.google.com/maps/dir/?api=1&amp;destination={{ $mapsQuery }}"
                                            target="_blank"
                                            rel="noopener">
                                            {{ __('ui.common.directions') }}
                                        </a>
                                    @else
                                        <a
                                            class="btn btn--outline-brown"
                                            href="#kontak">
                                            {{ __('ui.common.ask_location') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach

                @else

                    {{-- DEFAULT LOCATION: BEJI --}}
                    <article class="location-card">
                        <div
                            class="location-map location-map--pending"
                            role="img"
                            aria-label="{{ __('ui.lokasi.beji_map_aria') }}">

                            <span class="location-pin" aria-hidden="true">1</span>

                            <div class="location-map__pending-text">
                                <strong>{{ __('ui.common.map_coming_soon') }}</strong>
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
                                    <dd>{{ __('ui.lokasi.beji_schedule') }}</dd>
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

                    {{-- DEFAULT LOCATION: PLOSOKANDANG --}}
                    <article class="location-card">
                        <div class="location-map">
                            <span class="location-pin" aria-hidden="true">2</span>

                            <iframe
                                src="https://www.google.com/maps?q=Jl.+Tembus+Manggisan,+Manggisan,+Plosokandang,+Kec.+Kedungwaru,+Kabupaten+Tulungagung,+Jawa+Timur&amp;output=embed"
                                title="{{ __('ui.lokasi.plosokandang_map_title') }}"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
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
                                    <dd>{{ __('ui.lokasi.plosokandang_schedule') }}</dd>
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
                                    href="https://www.google.com/maps/search/?api=1&amp;query=Jl.+Tembus+Manggisan%2C+Manggisan%2C+Plosokandang%2C+Kec.+Kedungwaru%2C+Kabupaten+Tulungagung%2C+Jawa+Timur"
                                    target="_blank"
                                    rel="noopener">
                                    {{ __('ui.common.open_maps') }}
                                </a>

                                <a
                                    class="btn btn--outline-brown"
                                    href="https://www.google.com/maps/dir/?api=1&amp;destination=Jl.+Tembus+Manggisan%2C+Manggisan%2C+Plosokandang%2C+Kec.+Kedungwaru%2C+Kabupaten+Tulungagung%2C+Jawa+Timur"
                                    target="_blank"
                                    rel="noopener">
                                    {{ __('ui.common.directions') }}
                                </a>
                            </div>
                        </div>
                    </article>
                @endif
            </div>

            {{-- LOCATION NOTE --}}
            @if ($locations->isEmpty())
                <p class="location-note">
                    {{ __('ui.lokasi.note') }}
                </p>
            @endif
        </div>
    </section>
@endsection