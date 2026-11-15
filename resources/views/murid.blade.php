@extends('layouts.main')

@section('title', 'Murid Sanggar — Sanggar Seni Cakra Aji')
@section('description', 'Daftar murid Sanggar Seni Cakra Aji yang aktif berlatih.')
@section('page', 'murid')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/murid.css') }}">
@endpush

@push('scripts')
  <script src="{{ asset('assets/js/script2.js') }}" defer></script>
  <script src="{{ asset('assets/js/murid.js') }}" defer></script>
@endpush

@section('content')
  <section class="hero hero--murid">
    <div class="container hero-inner">
      <div class="hero-content">
        <p class="eyebrow">Murid Sanggar</p>
        <h1 class="hero__title hero__title--murid">Mereka yang belajar dan tumbuh bersama kami.</h1>
        <p class="hero__lead">
          Daftar murid Cakra Aji yang aktif berlatih.
          Demi kenyamanan, hanya nama panggilan, program,
          dan tahun bergabung yang ditampilkan.
        </p>

        <div class="search-box">
          <span aria-hidden="true">⌕</span>
          <input
            type="text"
            id="searchInput"
            placeholder="Ketik nama panggilan"
            aria-label="Cari nama murid atau kelas"
          >
        </div>
      </div>

      <div class="hero-illustration" aria-hidden="true">
        <p class="illustration-text">
          Cakra Aji<br>
          <span class="illustration-text__accent">Seni &amp; Budaya</span>
        </p>
      </div>
    </div>
  </section>

  <section class="students">
    <div class="container">

      <div class="class-heading">
        <span class="class-badge">Kelas Dasar Tingkat I (A)</span>
      </div>

      <div class="student-grid" id="studentGrid">

        @foreach ($murids as $index => $data)
          <article class="student-card" data-name="{{ strtolower($data->full_name) }}" @if ($index >= 8) hidden @endif>
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

      <div class="empty-state" id="emptyState">
        Murid tidak ditemukan.
      </div>

      <div class="load-more-wrapper">
        <button class="load-more" id="loadMore" type="button">
          Tampilkan lebih banyak
        </button>
      </div>

    </div>
  </section>

  <section class="cta">
    <div class="container">
      <div>
        <h2>Ingin jadi bagian dari mereka?</h2>
        <p>Mulai perjalananmu bersama Sanggar Seni Cakra Aji.</p>
      </div>

      <a class="btn" href="{{ route('pendaftaran.index') }}">
        Daftar jadi murid →
      </a>
    </div>
  </section>
@endsection
