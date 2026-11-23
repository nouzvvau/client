@extends('layouts.main')

@section('title', __('Murid Sanggar — Sanggar Seni Cakra Aji'))
@section('description', __('Daftar murid Sanggar Seni Cakra Aji yang aktif berlatih.'))
@section('page', 'murid')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/murid.css') }}">
@endpush


@section('content')
  <section class="hero hero--murid">
    <div class="container hero-inner">
      <div class="hero-content">
        <p class="eyebrow">{{ __('Murid Sanggar') }}</p>
        <h1 class="hero__title hero__title--murid">{{ __('Mereka yang belajar dan tumbuh bersama kami.') }}</h1>
        <p class="hero__lead">
          {{ __('Daftar murid Cakra Aji yang aktif berlatih. Demi kenyamanan, hanya nama dan program yang ditampilkan.') }}
        </p>

        <form class="search-box" method="GET" action="{{ route('murid.index') }}" role="search">
          <svg class="search-box__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
               stroke-width="2" stroke-linecap="round" aria-hidden="true">
            <circle cx="11" cy="11" r="7"></circle>
            <path d="m20 20-3.5-3.5"></path>
          </svg>
          <input
            type="search"
            name="search"
            value="{{ request('search') }}"
            placeholder="{{ __('Ketik nama panggilan') }}"
            aria-label="{{ __('Cari nama panggilan murid') }}"
          >
        </form>
      </div>

      <div class="hero-illustration">
        <img class="hero-logo" src="{{ asset('assets/images/logo-navbar.png') }}"
             alt="{{ __('Logo Sanggar Seni Cakra Aji') }}" width="440" height="362">
      </div>
    </div>
  </section>

  <section class="students">
    <div class="container">

      <div class="class-heading">
        <span class="class-badge">
          {{ __('Daftar murid aktif · :count orang', ['count' => $murids->total()]) }}
        </span>
      </div>

      <div class="student-grid" id="studentGrid">

        @foreach ($murids as $data)
          <article class="student-card" data-name="{{ strtolower($data->full_name) }}">
            <div class="student-avatar">
              {{ strtoupper(substr($data->full_name, 0, 1)) }}
            </div>

            <h3 class="student-name">
              {{ $data->full_name }}
            </h3>

            <p class="student-class">
                @forelse ($data->programs as $program)
                    {{ __($program->name) }}{{ !$loop->last ? ' · ' : '' }}
                @empty
                    {{ __('Belum mengikuti program') }}
                @endforelse
            </p>
          </article>
        @endforeach

      </div>

      <div class="empty-state" id="emptyState" @if ($murids->isNotEmpty()) hidden @endif>
        @if (request('search'))
          {{ __('Murid ":search" tidak ditemukan.', ['search' => request('search')]) }}
        @else
          {{ __('Belum ada murid yang aktif berlatih.') }}
        @endif
      </div>

      <div class="load-more-wrapper">
        @if ($murids->hasPages())
          <nav aria-label="{{ __('Navigasi halaman murid') }}" class="murid-pagination">
            <span class="murid-pagination__info">
              {{ __('Halaman :current dari :last', ['current' => $murids->currentPage(), 'last' => $murids->lastPage()]) }}
            </span>
            <div class="murid-pagination__links">
              @if ($murids->onFirstPage())
                <span class="load-more load-more--disabled" aria-disabled="true">{{ __('‹ Sebelumnya') }}</span>
              @else
                <a class="load-more" href="{{ $murids->previousPageUrl() }}" rel="prev">{{ __('‹ Sebelumnya') }}</a>
              @endif

              @foreach ($murids->getUrlRange(1, $murids->lastPage()) as $page => $url)
                @if ($page == $murids->currentPage())
                  <span class="load-more load-more--current" aria-current="page">{{ $page }}</span>
                @else
                  <a class="load-more" href="{{ $url }}">{{ $page }}</a>
                @endif
              @endforeach

              @if ($murids->hasMorePages())
                <a class="load-more" href="{{ $murids->nextPageUrl() }}" rel="next">{{ __('Selanjutnya ›') }}</a>
              @else
                <span class="load-more load-more--disabled" aria-disabled="true">{{ __('Selanjutnya ›') }}</span>
              @endif
            </div>
          </nav>
        @endif
      </div>

    </div>
  </section>

  <section class="cta">
    <div class="container">
      <div>
        <h2>{{ __('Ingin jadi bagian dari mereka?') }}</h2>
        <p>{{ __('Mulai perjalananmu bersama Sanggar Seni Cakra Aji.') }}</p>
      </div>

      <x-form-link form="registration" class="btn">
        {{ __('Daftar jadi murid') }}
      </x-form-link>
    </div>
  </section>
@endsection