@extends('layouts.main')

@section('title', __('ui.meta.galeri.title'))
@section('description', __('ui.meta.galeri.description'))
@section('page', 'galeri')
@section('activeNav', 'galeri')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/schedule.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/galeri.css') }}">
@endpush


@section('content')
  <section class="hero" aria-labelledby="hero-title">
    <div class="container">
      <p class="eyebrow eyebrow--red">{{ __('ui.galeri.hero_eyebrow') }}</p>
      <h1 class="hero__title" id="hero-title">
        {{ __('ui.galeri.hero_title_1') }}<br>
        {{ __('ui.galeri.hero_title_2') }}
      </h1>
    </div>
  </section>

  <section class="gallery" aria-labelledby="gallery-title">
    <div class="container">
      <div class="gallery__head">
        <div class="gallery__intro">
          <p class="eyebrow eyebrow--red">{{ __('ui.galeri.documentation_eyebrow') }}</p>
          <h2 class="gallery__title" id="gallery-title">{{ __('ui.galeri.gallery_title') }}</h2>
          <p class="gallery__lead">
            {{ __('ui.galeri.gallery_lead') }}
          </p>
        </div>
      </div>

      <div class="gallery-grid">
      @if ($activities->contains(fn ($activity) => $activity->photos->isNotEmpty()))
        @php
          $galleryActivities = $activities->filter(fn ($activity) => $activity->photos->isNotEmpty())->values();
        @endphp
        @foreach ($galleryActivities->chunk(2) as $row)
          <div class="gallery-row gallery-row--split">
            @foreach ($row as $activity)
              @php $photo = $activity->photos->first(); @endphp
              <figure class="gallery-card">
                <a href="{{ route('program.detail', ['slug' => \Illuminate\Support\Str::slug($activity->title)]) }}" style="display: block;">
                  <div class="gallery-card__media">
                    <img src="{{ Storage::url($photo->photo) }}" alt="{{ $photo->caption ?? $activity->title }}" loading="lazy" decoding="async">
                  </div>
                  <figcaption class="gallery-card__body">
                    <span class="gallery-card__index" aria-hidden="true">{{ str_pad((string) $loop->parent->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="gallery-card__title">{{ $photo->caption ?? $activity->title }}</span>
                  </figcaption>
                </a>
              </figure>
            @endforeach
          </div>
        @endforeach
      @else
        <div class="gallery-row gallery-row--lead">
          <figure class="gallery-card">
            <div class="gallery-card__media">
              <img src="{{ asset('assets/images/galeri/galeri-02.jpeg') }}" width="1600" height="1200" alt="{{ __('ui.galeri.photo_1_alt') }}" loading="eager">
            </div>
            <figcaption class="gallery-card__body">
              <span class="gallery-card__index" aria-hidden="true">01</span>
              <span class="gallery-card__title">{{ __('ui.galeri.photo_1_caption') }}</span>
            </figcaption>
          </figure>
          <figure class="gallery-card">
            <div class="gallery-card__media">
              <img src="{{ asset('assets/images/galeri/galeri-01.jpeg') }}" width="960" height="1280" alt="{{ __('ui.galeri.photo_2_alt') }}" loading="lazy" decoding="async">
            </div>
            <figcaption class="gallery-card__body">
              <span class="gallery-card__index" aria-hidden="true">02</span>
              <span class="gallery-card__title">{{ __('ui.galeri.photo_2_caption') }}</span>
            </figcaption>
          </figure>
        </div>
        <div class="gallery-row gallery-row--split">
          <figure class="gallery-card">
            <div class="gallery-card__media">
              <img src="{{ asset('assets/images/galeri/galeri-03.jpeg') }}" width="1600" height="900" alt="{{ __('ui.galeri.photo_3_alt') }}" loading="lazy" decoding="async">
            </div>
            <figcaption class="gallery-card__body">
              <span class="gallery-card__index" aria-hidden="true">03</span>
              <span class="gallery-card__title">{{ __('ui.galeri.photo_3_caption') }}</span>
            </figcaption>
          </figure>
          <figure class="gallery-card">
            <div class="gallery-card__media">
              <img src="{{ asset('assets/images/galeri/galeri-04.jpeg') }}" width="1600" height="1200" alt="{{ __('ui.galeri.photo_4_alt') }}" loading="lazy" decoding="async">
            </div>
            <figcaption class="gallery-card__body">
              <span class="gallery-card__index" aria-hidden="true">04</span>
              <span class="gallery-card__title">{{ __('ui.galeri.photo_4_caption') }}</span>
            </figcaption>
          </figure>
          <figure class="gallery-card">
            <div class="gallery-card__media">
              <img src="{{ asset('assets/images/galeri/galeri-05.jpeg') }}" width="1280" height="720" alt="{{ __('ui.galeri.photo_5_alt') }}" loading="lazy" decoding="async">
            </div>
            <figcaption class="gallery-card__body">
              <span class="gallery-card__index" aria-hidden="true">05</span>
              <span class="gallery-card__title">{{ __('ui.galeri.photo_5_caption') }}</span>
            </figcaption>
          </figure>
        </div>
        <div class="gallery-row gallery-row--strip">
          <figure class="gallery-card">
            <div class="gallery-card__media">
              <img src="{{ asset('assets/images/galeri/galeri-06.jpeg') }}" width="1536" height="864" alt="{{ __('ui.galeri.photo_6_alt') }}" loading="lazy" decoding="async">
            </div>
            <figcaption class="gallery-card__body">
              <span class="gallery-card__index" aria-hidden="true">06</span>
              <span class="gallery-card__title">{{ __('ui.galeri.photo_6_caption') }}</span>
            </figcaption>
          </figure>
          <figure class="gallery-card">
            <div class="gallery-card__media">
              <img src="{{ asset('assets/images/galeri/galeri-07.jpeg') }}" width="1600" height="900" alt="{{ __('ui.galeri.photo_7_alt') }}" loading="lazy" decoding="async">
            </div>
            <figcaption class="gallery-card__body">
              <span class="gallery-card__index" aria-hidden="true">07</span>
              <span class="gallery-card__title">{{ __('ui.galeri.photo_7_caption') }}</span>
            </figcaption>
          </figure>
          <figure class="gallery-card">
            <div class="gallery-card__media">
              <img src="{{ asset('assets/images/galeri/galeri-08.jpeg') }}" width="1152" height="864" alt="{{ __('ui.galeri.photo_8_alt') }}" loading="lazy" decoding="async">
            </div>
            <figcaption class="gallery-card__body">
              <span class="gallery-card__index" aria-hidden="true">08</span>
              <span class="gallery-card__title">{{ __('ui.galeri.photo_8_caption') }}</span>
            </figcaption>
          </figure>
          <figure class="gallery-card">
            <div class="gallery-card__media">
              <img src="{{ asset('assets/images/galeri/galeri-09.jpeg') }}" width="1280" height="720" alt="{{ __('ui.galeri.photo_9_alt') }}" loading="lazy" decoding="async">
            </div>
            <figcaption class="gallery-card__body">
              <span class="gallery-card__index" aria-hidden="true">09</span>
              <span class="gallery-card__title">{{ __('ui.galeri.photo_9_caption') }}</span>
            </figcaption>
          </figure>
        </div>
      @endif
      </div>
    </div>
  </section>

  <section class="schedule" id="jadwal" aria-labelledby="schedule-title">
    <div class="container">
      <p class="eyebrow eyebrow--amber">{{ __('ui.galeri.schedule_eyebrow') }}</p>
      <h2 class="schedule__title" id="schedule-title">{{ __('ui.galeri.schedule_title') }}</h2>

      <div class="table-wrap">
        <table class="schedule-table">
          <colgroup>
            <col class="col-kelompok">
            <col class="col-hari">
            <col class="col-jam">
            <col class="col-tempat">
          </colgroup>
          <thead>
            <tr>
              <th scope="col">{{ __('ui.galeri.table_group') }}</th>
              <th scope="col">{{ __('ui.galeri.table_day') }}</th>
              <th scope="col">{{ __('ui.galeri.table_time') }}</th>
              <th scope="col">{{ __('ui.galeri.table_place') }}</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($schedules as $schedule)
              <tr>
                <td data-label="{{ __('ui.galeri.table_group') }}">{{ $schedule->program?->name ?? '-' }}</td>
                <td data-label="{{ __('ui.galeri.table_day') }}">{{ $schedule->day_of_week }}</td>
                <td data-label="{{ __('ui.galeri.table_time') }}">{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}</td>
                <td data-label="{{ __('ui.galeri.table_place') }}">{{ $schedule->location?->name ?? '-' }}</td>
              </tr>
            @empty
              @foreach (__('ui.galeri.schedule_rows') as $row)
                <tr>
                  <td data-label="{{ __('ui.galeri.table_group') }}">{{ $row['group'] }}</td>
                  <td data-label="{{ __('ui.galeri.table_day') }}">{{ $row['day'] }}</td>
                  <td data-label="{{ __('ui.galeri.table_time') }}">{{ $row['time'] }}</td>
                  <td data-label="{{ __('ui.galeri.table_place') }}">{{ $row['place'] }}</td>
                </tr>
              @endforeach
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </section>
@endsection
