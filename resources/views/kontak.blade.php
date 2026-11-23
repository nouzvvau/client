@extends('layouts.main')

@section('title', __('ui.meta.kontak.title'))
@section('description', __('ui.meta.kontak.description'))
@section('page', 'kontak')
@section('activeNav', 'kontak')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/kontak.css') }}">
@endpush


@section('content')
<div class="contact-page">
    <div class="contact-container">

        {{-- HERO --}}
        <section class="contact-hero">
            <p class="contact-eyebrow">{{ __('ui.kontak.hero_eyebrow') }}</p>

            <h1 class="contact-hero-title">
                {{ __('ui.kontak.hero_title_1') }}<br>
                {{ __('ui.kontak.hero_title_2') }}
            </h1>

            <p class="contact-hero-lead">
                {{ __('ui.kontak.hero_lead') }}
            </p>
        </section>

        {{-- CONTACT PERSON --}}
        <section class="contact-persons" aria-labelledby="contact-persons-title">
            <h2 class="contact-section-title" id="contact-persons-title">
                {{ __('ui.kontak.contact_person_title') }}
            </h2>

            <div class="contact-person-grid">
                @forelse ($contactPersons as $person)
                    @php
                        $inisial = strtoupper(
                            collect(explode(' ', trim($person->name ?? '')))
                                ->filter()
                                ->take(2)
                                ->map(fn ($kata) => mb_substr($kata, 0, 1))
                                ->implode('')
                        );
                    @endphp

                    <article class="contact-person-card">
                        <div class="contact-person-avatar contact-avatar--{{ ['olive', 'gold', 'cream', 'red'][$loop->iteration % 4] }}">
                            @if ($person->photo)
                                <img src="{{ Storage::url($person->photo) }}" alt="{{ $person->name }}">
                            @else
                                <span aria-hidden="true">{{ $inisial }}</span>
                            @endif
                        </div>

                        <div class="contact-person-info">
                            <h3 class="contact-person-name">{{ $person->name }}</h3>
                            <span class="contact-person-role">{{ $person->position }}</span>

                            @if ($person->description)
                                <p class="contact-person-desc">{{ $person->description }}</p>
                            @endif
                        </div>
                    </article>
                @empty
                    <article class="contact-person-card">
                        <div class="contact-person-avatar contact-avatar--olive">
                            <span aria-hidden="true">CA</span>
                        </div>

                        <div class="contact-person-info">
                            <h3 class="contact-person-name">{{ __('ui.kontak.fallback_name') }}</h3>
                            <span class="contact-person-role">{{ __('ui.kontak.fallback_role') }}</span>
                            <p class="contact-person-desc">
                                {{ __('ui.kontak.fallback_desc') }}
                            </p>
                        </div>
                    </article>
                @endforelse
            </div>
        </section>
    </div>

    {{-- SECTION GOLD --}}
    <section class="contact-actions" aria-labelledby="contact-actions-title">
        <div class="contact-container">
            <h2 class="sr-only" id="contact-actions-title">{{ __('ui.kontak.actions_sr_title') }}</h2>

            <div class="contact-actions-grid">

                <div class="contact-actions-intro">
                    <h3 class="contact-actions-heading">{{ __('ui.kontak.actions_heading') }}</h3>
                    <p class="contact-actions-text">
                        {{ __('ui.kontak.actions_text') }}
                    </p>

                    <x-form-link form="registration" class="contact-action-card">
                        <span class="contact-action-label">{{ __('ui.kontak.registration_label') }}</span>
                        <span class="contact-action-title">{{ __('ui.kontak.registration_title') }}</span>
                        <span class="contact-action-desc">
                            {{ __('ui.kontak.registration_desc') }}
                        </span>
                        <span class="contact-action-link">{{ __('ui.kontak.registration_link') }}</span>
                    </x-form-link>

                    <x-form-link form="booking" class="contact-action-card">
                        <span class="contact-action-label">{{ __('ui.kontak.booking_label') }}</span>
                        <span class="contact-action-title">{{ __('ui.kontak.booking_title') }}</span>
                        <span class="contact-action-desc">
                            {{ __('ui.kontak.booking_desc') }}
                        </span>
                        <span class="contact-action-link">{{ __('ui.kontak.booking_link') }}</span>
                    </x-form-link>
                </div>

                <div class="contact-meet">
                    <h3 class="contact-actions-heading">{{ __('ui.kontak.meet_heading') }}</h3>

                    <article class="contact-info-card">
                        <dl class="contact-info-list">
                            @forelse ($locations as $location)
                                <div class="contact-info-item">
                                    <dt>{{ $loop->first ? __('ui.kontak.address_first') : __('ui.kontak.address_other') }}</dt>
                                    <dd>
                                        {{ $location->name }} —
                                        {{ $location->address ?? __('ui.kontak.address_unavailable') }}
                                    </dd>
                                </div>

                                @php
                                    $jamLatihan = $location->schedules
                                        ->map(fn ($schedule) => trim(($schedule->day_of_week ?? '')
                                            . (isset($schedule->start_time)
                                                ? ', '.substr($schedule->start_time, 0, 5).'–'.substr($schedule->end_time, 0, 5)
                                                : '')))
                                        ->filter()
                                        ->unique()
                                        ->values();
                                @endphp

                                <div class="contact-info-item">
                                    <dt>{{ __('ui.kontak.practice_hours') }}</dt>
                                    <dd>
                                        @if ($jamLatihan->isNotEmpty())
                                            {{ $jamLatihan->implode('; ') }} {{ __('ui.kontak.practice_hours_suffix') }}
                                        @else
                                            {{ __('ui.kontak.practice_hours_fallback') }}
                                        @endif
                                    </dd>
                                </div>
                            @empty
                                <div class="contact-info-item">
                                    <dt>{{ __('ui.kontak.address_first') }}</dt>
                                    <dd>{{ __('ui.kontak.address_sanggar_unavailable') }}</dd>
                                </div>
                            @endforelse

                            <div class="contact-info-item">
                                <dt>{{ __('ui.common.email_social') }}</dt>
                                <dd>
                                    {{ __('ui.kontak.email_social_unavailable') }}
                                </dd>
                            </div>
                        </dl>

                        @forelse ($locations as $location)
                            <div class="contact-map">
                                @if ($location->address || $location->google_maps_url)
                                    @php
                                        $mapsQuery = rawurlencode($location->address ?? $location->name);
                                        $mapsLink = $location->google_maps_url
                                            ?: 'https://www.google.com/maps/search/?api=1&query='.$mapsQuery;
                                    @endphp
                                    <iframe
                                        src="https://www.google.com/maps?q={{ $mapsQuery }}&amp;output=embed"
                                        title="{{ __('ui.lokasi.map_title', ['name' => $location->name]) }}"
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        allowfullscreen></iframe>
                                @else
                                    <div class="contact-map contact-map--pending" role="img"
                                         aria-label="{{ __('ui.kontak.map_pending_aria', ['name' => $location->name]) }}">
                                        <strong>{{ __('ui.common.map_coming_soon') }}</strong>
                                        <span>{{ __('ui.kontak.map_pending_desc') }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="contact-map-actions">
                                @if ($location->address || $location->google_maps_url)
                                    <a class="contact-btn contact-btn--brown"
                                       href="{{ $mapsLink }}"
                                       target="_blank"
                                       rel="noopener">{{ __('ui.common.open_maps') }}</a>
                                @endif
                            </div>
                        @empty
                            <div class="contact-map contact-map--pending" role="img"
                                 aria-label="{{ __('ui.kontak.map_sanggar_aria') }}">
                                <strong>{{ __('ui.common.map_coming_soon') }}</strong>
                                <span>{{ __('ui.kontak.map_pending_desc') }}</span>
                            </div>
                        @endforelse
                    </article>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection
