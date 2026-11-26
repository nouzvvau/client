@extends('layouts.admin')

@section('title', 'Pengaturan WhatsApp')
@section('admin_eyebrow', 'Pengaturan')
@section('admin_title', 'Pengaturan WhatsApp')

@section('content')
    <div class="admin-page-head">
        <div>
            <h2 class="admin-page-head__title">Nomor &amp; pesan WhatsApp</h2>
            <p class="admin-page-head__desc">
                Nomor ini dipakai untuk tombol WhatsApp di halaman kontak dan detail
                acara pada website. Jika dikosongkan, tombol WhatsApp tidak ditampilkan.
            </p>
        </div>
    </div>

    <div class="admin-detail-grid">
        <section class="admin-card">
            <div class="admin-card__head">
                <div>
                    <h3 class="admin-card__title">Pengaturan kontak</h3>
                    <p class="admin-card__desc">Perubahan langsung berlaku setelah disimpan.</p>
                </div>
            </div>

            <form action="{{ route('admin.whatsapp.update') }}" method="POST" class="admin-form">
                @csrf
                @method('PUT')

                <div class="admin-field">
                    <label for="whatsapp_number">Nomor WhatsApp</label>
                    <input
                        id="whatsapp_number"
                        type="text"
                        name="whatsapp_number"
                        value="{{ old('whatsapp_number', $number) }}"
                        placeholder="0812-3456-7890"
                        class="admin-input"
                    >
                    <small style="font-size:11px;color:var(--admin-muted);">
                        Gunakan format Indonesia, misalnya 0812-3456-7890 atau 6281234567890.
                        Nomor akan dinormalisasi otomatis.
                    </small>
                </div>

                <div class="admin-field">
                    <label for="whatsapp_cta_label">Label tombol</label>
                    <input
                        id="whatsapp_cta_label"
                        type="text"
                        name="whatsapp_cta_label"
                        value="{{ old('whatsapp_cta_label', $ctaLabel) }}"
                        placeholder="Hubungi via WhatsApp"
                        class="admin-input"
                    >
                </div>

                <div class="admin-field">
                    <label for="whatsapp_message">Pesan awal</label>
                    <textarea
                        id="whatsapp_message"
                        name="whatsapp_message"
                        rows="4"
                        class="admin-textarea"
                        placeholder="Halo Sanggar Cakra Aji, saya ingin bertanya."
                    >{{ old('whatsapp_message', $message) }}</textarea>
                    <small style="font-size:11px;color:var(--admin-muted);">
                        Pesan ini otomatis terisi saat pengunjung membuka WhatsApp.
                    </small>
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <x-admin.icon name="check" />
                        Simpan pengaturan
                    </button>
                </div>
            </form>
        </section>

        <section class="admin-card">
            <div class="admin-card__head">
                <div>
                    <h3 class="admin-card__title">Pratinjau</h3>
                    <p class="admin-card__desc">Tampilan tautan yang akan dibuka pengunjung.</p>
                </div>
            </div>

            @if ($previewLink)
                <dl class="admin-detail-list">
                    <dt>Nomor tersimpan</dt>
                    <dd>{{ $number }}</dd>

                    <dt>Label tombol</dt>
                    <dd>{{ $ctaLabel ?: 'Hubungi via WhatsApp' }}</dd>

                    <dt>Pesan awal</dt>
                    <dd>{{ $message ?: '—' }}</dd>
                </dl>

                <div class="admin-form-actions">
                    <a href="{{ $previewLink }}" target="_blank" rel="noopener noreferrer" class="admin-btn admin-btn--gold">
                        <x-admin.icon name="whatsapp" />
                        Uji tautan WhatsApp
                    </a>
                </div>
            @else
                <div class="admin-empty">
                    <span class="admin-empty__title">Nomor belum diatur</span>
                    Isi nomor WhatsApp di samping untuk mengaktifkan tombol kontak
                    di website.
                </div>
            @endif

            <div class="admin-divider"><span>Catatan</span></div>

            <ul style="margin:0;padding-left:18px;font-size:12px;line-height:1.7;color:var(--admin-muted);">
                <li>Nomor disimpan di tabel <code>settings</code>.</li>
                <li>Nilai dari <code>.env</code> hanya dipakai jika pengaturan belum diisi.</li>
                <li>Tombol WhatsApp di website disembunyikan bila nomor tidak valid.</li>
            </ul>
        </section>
    </div>
@endsection
