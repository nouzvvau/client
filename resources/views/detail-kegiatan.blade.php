@extends('layouts.main')

@section('title', __('ui.meta.program_detail.title', ['name' => $program->localized_name]))
@section('description', \Illuminate\Support\Str::limit(strip_tags($program->localized_description ?? ''), 150))
@section('page', 'program')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/detail-kegiatan.css') }}">
@endpush


@section('content')
  {{-- Hero --}}
  <section class="hero hero--detail">
    <div class="container">
      <p class="eyebrow">{{ __('ui.detail.eyebrow') }}</p>
      <h1>{{ $program->localized_name }}</h1>

      @if (filled($program->localized_schedule))
        <p class="hero__meta">{{ __('ui.detail.schedule_label') }}: {{ $program->localized_schedule }}</p>
      @endif

      @if (filled($program->localized_description))
        <p class="hero__lead">{{ $program->localized_description }}</p>
      @endif
    </div>
  </section>

  {{-- Foto utama --}}
  @if (filled($program->image))
    <section class="activity-feature">
      <div class="container">
        <figure class="activity-feature__figure">
          <div class="activity-feature__media">
            <img
              src="{{ $program->image_url }}"
              alt="{{ __('ui.common.documentation_of', ['name' => $program->localized_name]) }}"
            >
          </div>

          <figcaption class="activity-feature__caption">
            <span class="eyebrow">{{ __('ui.detail.main_moment') }}</span>
            <p>{{ $program->localized_name }}</p>
          </figcaption>
        </figure>
      </div>
    </section>
  @endif

  {{-- Cerita kegiatan --}}
  @if (filled($program->localized_description))
    <section class="activity-story">
      <div class="container">
        <div class="activity-story__layout">
          <div class="activity-story__heading">
            <p class="eyebrow">{{ __('ui.detail.story_eyebrow') }}</p>
            <h2>{{ __('ui.detail.story_title') }}</h2>
          </div>

          <div class="activity-story__text">
            {{ $program->localized_description }}
          </div>
        </div>
      </div>
    </section>
  @endif

  {{-- Dokumentasi tambahan --}}
  <section class="gallery gallery--activity">
    <div class="container">
      <div class="gallery__head">
        <div class="gallery__intro">
          <p class="eyebrow">{{ __('ui.detail.documentation_eyebrow') }}</p>
          <h2 class="gallery__title">{{ __('ui.detail.documentation_title') }}</h2>
        </div>

        <a class="btn btn--outline-primary" href="{{ route('galeri') }}">
          {{ __('ui.detail.gallery_button') }}
        </a>
      </div>
    </div>
  </section>

  {{-- Kegiatan lainnya --}}
  @if ($others->isNotEmpty())
    <section class="more">
      <div class="container">
        <p class="eyebrow">{{ __('ui.detail.others_eyebrow') }}</p>
        <h2>{{ __('ui.detail.others_title') }}</h2>

        <div class="chips">
          @foreach ($others as $other)
            <a
              class="chip"
              href="{{ route('program.detail', ['slug' => $other->slug]) }}"
            >
              {{ $other->localized_name }}
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- CTA --}}
  <section class="cta">
    <div class="container">
      <h2>{{ __('ui.detail.cta_title') }}</h2>
      <x-form-link form="booking" class="btn">
        {{ __('ui.detail.cta_button') }}
      </x-form-link>
    </div>
  </section>
@endsection
