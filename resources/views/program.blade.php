@extends('layouts.main')

@section('title', __('ui.meta.program.title'))
@section('description', __('ui.meta.program.description'))
@section('page', 'program')
@section('activeNav', 'program')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/program-kegiatan.css') }}">
@endpush

@section('content')
    <section class="hero" id="tentang">
        <div class="container">
            <div class="eyebrow">{{ __('ui.program.eyebrow') }}</div>
            <h1>{{ __('ui.program.title') }}</h1>
            <p class="hero__lead">{{ __('ui.program.lead') }}</p>
            <h2 id="program">{{ __('ui.program.section_title') }}</h2>

            <div class="cards">
                @if ($programs->isNotEmpty())
                    @php
                        $styles = ['green', 'amber', 'red'];
                    @endphp

                    @foreach ($programs as $program)
                        @php
                            $style = $styles[$loop->index % count($styles)];
                        @endphp

                        <article class="card card--{{ $style }}">
                            <div class="card__photo">
                                <img
                                    src="{{ $program->image_url }}"
                                    alt="{{ __('ui.common.documentation_of', ['name' => $program->localized_name]) }}"
                                    loading="lazy"
                                >
                            </div>

                            <div class="card__body">
                                <div class="card__body">
                                    @if (!empty($program->year))
                                        <span class="badge badge--{{ $style }}">
                                            {{ $program->year }}
                                        </span>
                                    @endif
                                    <h3>{{ $program->localized_name }}</h3>
                                </div>
                            </div>

                            <div class="card__action">
                                <a
                                    class="btn btn--primary"
                                    href="{{ route('program.detail', ['slug' => $program->slug]) }}"
                                    aria-label="{{ __('ui.common.view_detail', ['name' => $program->localized_name]) }}"
                                >
                                    {{ __('ui.program.view') }}
                                </a>
                            </div>
                        </article>
                    @endforeach
                @else
                    <article class="card card--green">
                        <div class="card__photo">
                            <img
                                src="{{ asset('assets/images/galeri/galeri-01.jpeg') }}"
                                alt="{{ __('ui.program.fallback_1_alt') }}"
                                width="960"
                                height="1280"
                            >
                        </div>
                        <div class="card__body">
                            <h3>{{ __('ui.program.fallback_1_title') }}</h3>
                        </div>
                        <div class="card__action">
                            <a class="btn btn--primary" href="{{ route('galeri') }}">
                                {{ __('ui.program.view') }}
                            </a>
                        </div>
                    </article>

                    <article class="card card--amber">
                        <div class="card__photo">
                            <img
                                src="{{ asset('assets/images/galeri/galeri-02.jpeg') }}"
                                alt="{{ __('ui.program.fallback_2_alt') }}"
                                width="1600"
                                height="1200"
                            >
                        </div>
                        <div class="card__body">
                            <h3>{{ __('ui.program.fallback_2_title') }}</h3>
                        </div>
                        <div class="card__action">
                            <a class="btn btn--primary" href="{{ route('galeri') }}">
                                {{ __('ui.program.view') }}
                            </a>
                        </div>
                    </article>

                    <article class="card card--red">
                        <div class="card__photo">
                            <img
                                src="{{ asset('assets/images/galeri/galeri-03.jpeg') }}"
                                alt="{{ __('ui.program.fallback_3_alt') }}"
                                width="1600"
                                height="900"
                            >
                        </div>
                        <div class="card__body">
                            <h3>{{ __('ui.program.fallback_3_title') }}</h3>
                        </div>
                        <div class="card__action">
                            <a class="btn btn--primary" href="{{ route('galeri') }}">
                                {{ __('ui.program.view') }}
                            </a>
                        </div>
                    </article>
                @endif
            </div>
        </div>
    </section>

    <section class="more">
        <div class="container">
            <div class="eyebrow">{{ __('ui.program.more_eyebrow') }}</div>
            <h2>{{ __('ui.program.more_title') }}</h2>
            <div class="chips">
                <span class="chip">{{ __('ui.program.chip_1') }}</span>
                <span class="chip">{{ __('ui.program.chip_2') }}</span>
                <span class="chip">{{ __('ui.program.chip_3') }}</span>
                <span class="chip">{{ __('ui.program.chip_4') }}</span>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="container">
            <h2>{{ __('ui.program.cta_title') }}</h2>
            <x-form-link form="booking" class="btn">
                {{ __('ui.program.cta_button') }}
            </x-form-link>
        </div>
    </section>
@endsection