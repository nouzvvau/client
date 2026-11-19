@extends('layouts.main')

@section('title', 'Murid Sanggar — Sanggar Seni Cakra Aji')
@section('description', 'Daftar murid Sanggar Seni Cakra Aji yang aktif berlatih.')
@section('page', 'murid')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/murid.css') }}">
@endpush


@section('content')
  <section class="hero hero--murid">
    <div class="container hero-inner">
      <div class="hero-content">
        <p class="eyebrow">Murid Sanggar</p>
        <h1 class="hero__title hero__title--murid">Mereka yang belajar dan tumbuh bersama kami.</h1>
        <p class="hero__lead">
          Daftar murid Cakra Aji yang aktif berlatih.
          Demi kenyamanan, hanya nama dan program yang ditampilkan.
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
            placeholder="Ketik nama panggilan"
            aria-label="Cari nama panggilan murid"
          >
        </form>
      </div>

      <div class="hero-illustration">
        <img class="hero-logo" src="{{ asset('assets/images/logo-navbar.png') }}"
             alt="Logo Sanggar Seni Cakra Aji" width="440" height="362">
      </div>
    </div>
  </section>

  <section class="students">
    <div class="container">

      <div class="class-heading">
        <span class="class-badge">
          Daftar murid aktif &middot; {{ $murids->total() }} orang
        </span>
      </div>

      <div class="student-grid" id="studentGrid">

        @forelse ($murids as $data)
          <article class="student-card" data-name="{{ strtolower($data->full_name) }}">
            <div class="student-avatar">
              {{ strtoupper(substr($data->full_name, 0, 1)) }}
            </div>

            <h3 class="student-name">
              {{ $data->full_name }}
            </h3>

            <p class="student-class">
                @forelse ($data->programs as $program)
                    {{ $program->name }}{{ !$loop->last ? ' · ' : '' }}
                @empty
                    Belum mengikuti program
                @endforelse
            </p>
        </article>
        @endforeach

      </div>

      <div class="empty-state" id="emptyState" @if ($murids->isNotEmpty()) hidden @endif>
        @if (request('search'))
          Murid "{{ request('search') }}" tidak ditemukan.
        @else
          Belum ada murid yang aktif berlatih.
        @endif
      </div>

      <div class="load-more-wrapper">
        @if ($murids->hasPages())
          <nav aria-label="Navigasi halaman murid" class="murid-pagination">
            <span class="murid-pagination__info">
              Halaman {{ $murids->currentPage() }} dari {{ $murids->lastPage() }}
            </span>
            <div class="murid-pagination__links">
              @if ($murids->onFirstPage())
                <span class="load-more load-more--disabled" aria-disabled="true">‹ Sebelumnya</span>
              @else
                <a class="load-more" href="{{ $murids->previousPageUrl() }}" rel="prev">‹ Sebelumnya</a>
              @endif

              @foreach ($murids->getUrlRange(1, $murids->lastPage()) as $page => $url)
                @if ($page == $murids->currentPage())
                  <span class="load-more load-more--current" aria-current="page">{{ $page }}</span>
                @else
                  <a class="load-more" href="{{ $url }}">{{ $page }}</a>
                @endif
              @endforeach

              @if ($murids->hasMorePages())
                <a class="load-more" href="{{ $murids->nextPageUrl() }}" rel="next">Selanjutnya ›</a>
              @else
                <span class="load-more load-more--disabled" aria-disabled="true">Selanjutnya ›</span>
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
        <h2>Ingin jadi bagian dari mereka?</h2>
        <p>Mulai perjalananmu bersama Sanggar Seni Cakra Aji.</p>
      </div>

      <x-form-link form="registration" class="btn">
        Daftar jadi murid 
      </x-form-link>
    </div>
  </section>
@endsection
