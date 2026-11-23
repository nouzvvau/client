@extends('layouts.admin')

@section('title', 'Dashboard')
@section('admin_eyebrow', 'Dashboard')
@section('admin_title', 'Halo, '.auth()->user()->name)

@section('content')
    <div class="admin-page-head">
        <div>
            <h2 class="admin-page-head__title">Ringkasan pengelolaan</h2>
            <p class="admin-page-head__desc">
                Pantau data pendaftar, booking acara, murid, dan dokumentasi kegiatan
                Sanggar Seni Cakra Aji. Semua angka di bawah diambil langsung dari database.
            </p>
        </div>

        <div class="admin-page-head__actions">
            <a href="{{ route('admin.gallery.create') }}" class="admin-btn admin-btn--gold">
                <x-admin.icon name="image" />
                Tambah dokumentasi
            </a>
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
                    <h3 class="admin-card__title">Perlu ditindaklanjuti</h3>
                    <p class="admin-card__desc">Data yang masih berstatus menunggu.</p>
                </div>
            </div>

            <div class="admin-activity">
                <div class="admin-activity__item">
                    <div class="admin-activity__main">
                        <strong>Dokumentasi acara</strong>
                        <small>{{ $jumlahDokumentasi }} dokumentasi dengan {{ $jumlahFoto }} foto tersimpan.</small>
                    </div>
                    <div class="admin-inline-actions">
                        <a href="{{ route('admin.gallery.index') }}" class="admin-btn admin-btn--sm">Kelola</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="admin-card">
            <div class="admin-card__head">
                <div>
                    <h3 class="admin-card__title">Formulir publik</h3>
                    <p class="admin-card__desc">Pendaftaran dan booking publik tetap melalui Google Forms.</p>
                </div>
            </div>

            <p class="admin-card__desc" style="margin-bottom: 14px;">
                Halaman ini menyimpan data yang dikelola admin. Formulir publik tidak diubah
                agar alur pendaftaran dan booking yang sudah berjalan tetap stabil.
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
    </div>

    <section class="admin-card" style="margin-top: 22px;">
        <div class="admin-card__head">
            <div>
                <h3 class="admin-card__title">Dokumentasi terbaru</h3>
                <p class="admin-card__desc">Dokumentasi acara yang baru ditambahkan.</p>
            </div>
            <a href="{{ route('admin.gallery.index') }}" class="admin-btn admin-btn--sm">Kelola galeri</a>
        </div>

        @if ($dokumentasiTerbaru->isNotEmpty())
            <div class="admin-gallery-grid">
                @foreach ($dokumentasiTerbaru as $documentation)
                    <a href="{{ route('admin.gallery.show', $documentation) }}" class="admin-gallery-card" style="text-decoration:none;">
                        <div class="admin-gallery-card__media">
                            @if ($documentation->cover_url)
                                <img src="{{ $documentation->cover_url }}" alt="{{ $documentation->title }}" loading="lazy">
                            @else
                                <div class="admin-gallery-card__media--empty" style="width:100%;height:100%;">
                                    Belum ada foto
                                </div>
                            @endif
                        </div>
                        <div class="admin-gallery-card__body">
                            <h4 class="admin-gallery-card__title">{{ $documentation->title }}</h4>
                            <div class="admin-gallery-card__meta">
                                <span>{{ $documentation->event_date?->format('d/m/Y') ?? 'Tanggal belum diisi' }}</span>
                                <span>{{ $documentation->photos->count() }} foto</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="admin-empty">
                <span class="admin-empty__title">Belum ada dokumentasi</span>
                Tambahkan dokumentasi acara agar muncul di halaman ini.
                <div class="admin-empty__actions">
                    <a href="{{ route('admin.gallery.create') }}" class="admin-btn admin-btn--primary">
                        <x-admin.icon name="plus" />
                        Tambah dokumentasi
                    </a>
                </div>
            </div>
        @endif
    </section>

    <section class="admin-card" style="margin-top: 22px;">
        <div class="admin-card__head">
            <div>
                <h3 class="admin-card__title">Aksi cepat</h3>
                <p class="admin-card__desc">Menuju halaman pengelolaan yang paling sering dipakai.</p>
            </div>
        </div>

        <div class="admin-quick-grid">
            <a href="{{ route('admin.gallery.index') }}" class="admin-quick">
                <span class="admin-quick__icon"><x-admin.icon name="image" /></span>
                <span>
                    <strong>Galeri acara</strong>
                    <small>Unggah dan atur dokumentasi</small>
                </span>
            </a>

            <a href="{{ route('admin.program.index') }}" class="admin-quick">
                <span class="admin-quick__icon"><x-admin.icon name="book" /></span>
                <span>
                    <strong>Program &amp; kegiatan</strong>
                    <small>Atur program yang tampil di website</small>
                </span>
            </a>

            <a href="{{ route('admin.nama-murid') }}" class="admin-quick">
                <span class="admin-quick__icon"><x-admin.icon name="graduation" /></span>
                <span>
                    <strong>Daftar murid</strong>
                    <small>Kelola nama, kelas, dan status murid</small>
                </span>
            </a>

            <a href="{{ route('admin.whatsapp.edit') }}" class="admin-quick">
                <span class="admin-quick__icon"><x-admin.icon name="settings" /></span>
                <span>
                    <strong>Pengaturan WhatsApp</strong>
                    <small>Atur nomor dan template pesan</small>
                </span>
            </a>
        </div>
    </section>
@endsection
