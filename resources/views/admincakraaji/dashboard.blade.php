
@extends('layouts.admin')

@section('title', 'Dashboard')
@section('admin_eyebrow', 'Dashboard')
@section('admin_title', 'Halo, '.auth()->user()->name)

@section('content')
    <div class="admin-page-head">
        <div>
            <h2 class="admin-page-head__title">Ringkasan pengelolaan</h2>
            <p class="admin-page-head__desc">
                Pantau data murid dan program Sanggar Seni Cakra Aji melalui panel admin.
            </p>
        </div>
    </div>

    <div class="admin-stat-grid">
        <div class="admin-stat admin-stat--brown">
            <span class="admin-stat__label">Total Murid</span>
            <strong class="admin-stat__value">{{ $jumlahMurid }}</strong>
            <span class="admin-stat__hint">Terdaftar di daftar murid</span>
        </div>

        <div class="admin-stat admin-stat--red">
            <span class="admin-stat__label">Program Aktif</span>
            <strong class="admin-stat__value">{{ $jumlahProgramAktif }}</strong>
            <span class="admin-stat__hint">{{ $jumlahProgramNonaktif }} program tidak aktif</span>
        </div>
    </div>

    <div class="admin-two-col">
        <section class="admin-card">
            <div class="admin-card__head">
                <div>
                    <h3 class="admin-card__title">Formulir publik</h3>
                    <p class="admin-card__desc">Akses formulir pendaftaran dan booking.</p>
                </div>
            </div>

            <p class="admin-card__desc" style="margin-bottom: 14px;">
                Formulir publik tetap dikelola melalui Google Forms agar alur
                pendaftaran dan booking yang sudah berjalan tidak berubah.
            </p>

            <div class="admin-inline-actions">
                <x-form-link form="registration" class="admin-btn admin-btn--gold">
                    Buka formulir pendaftaran
                </x-form-link>
                <x-form-link form="booking" class="admin-btn">
                    Buka formulir booking
                </x-form-link>
            </div>
        </section>

        <section class="admin-card">
            <div class="admin-card__head">
                <div>
                    <h3 class="admin-card__title">Pengelolaan website</h3>
                    <p class="admin-card__desc">Pilih menu untuk mengelola konten website.</p>
                </div>
            </div>

            <div class="admin-activity">
                <div class="admin-activity__item">
                    <div class="admin-activity__main">
                        <strong>Program & Kegiatan</strong>
                    </div>
                    <a href="{{ route('admin.program.index') }}" class="admin-btn admin-btn--sm">
                        Kelola
                    </a>
                </div>
            </div>

            <div class="admin-activity">
                <div class="admin-activity__item">
                    <div class="admin-activity__main">
                        <strong>Galeri</strong>
                    </div>
                    <a href="{{ route('admin.public-gallery.index') }}" class="admin-btn admin-btn--sm">
                        Kelola
                    </a>
                </div>
            </div>

        </section>
    </div>

    <section class="admin-card" style="margin-top: 22px;">
        <div class="admin-card__head">
            <div>
                <h3 class="admin-card__title">Aksi cepat</h3>
                <p class="admin-card__desc">Akses menu pengelolaan yang tersedia.</p>
            </div>
        </div>

        <div class="admin-quick-grid">
            <a href="{{ route('admin.program.index') }}" class="admin-quick">
                <span class="admin-quick__icon"><x-admin.icon name="book" /></span>
                <span>
                    <strong>Program &amp; Kegiatan</strong>
                    <small>Kelola informasi dan konten program</small>
                </span>
            </a>

            <a href="{{ route('admin.public-gallery.index') }}" class="admin-quick">
                <span class="admin-quick__icon"><x-admin.icon name="image" /></span>
                <span>
                    <strong>Galeri</strong>
                    <small>Unggah dan atur foto galeri</small>
                </span>
            </a>

            <a href="{{ route('admin.nama-murid') }}" class="admin-quick">
                <span class="admin-quick__icon"><x-admin.icon name="graduation" /></span>
                <span>
                    <strong>Daftar Murid</strong>
                    <small>Kelola nama, kelas, dan status murid</small>
                </span>
            </a>

            <a href="{{ route('admin.whatsapp.edit') }}" class="admin-quick">
                <span class="admin-quick__icon"><x-admin.icon name="phone" /></span>
                <span>
                    <strong>Pengaturan Kontak</strong>
                    <small>Atur nomor dan template pesan</small>
                </span>
            </a>
        </div>
    </section>
@endsection
