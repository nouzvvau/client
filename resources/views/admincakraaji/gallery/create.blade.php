@extends('layouts.admin')

@section('title', 'Tambah Dokumentasi')
@section('admin_eyebrow', 'Galeri Acara')
@section('admin_title', 'Tambah Dokumentasi')

@section('content')
    <div class="admin-page-head">
        <div>
            <a href="{{ route('admin.gallery.index') }}" class="admin-btn admin-btn--sm" style="margin-bottom:10px;">
                <x-admin.icon name="arrow-left" />
                Kembali
            </a>
            <h2 class="admin-page-head__title">Tambah dokumentasi acara</h2>
            <p class="admin-page-head__desc">
                Unggah foto dokumentasi acara. Foto disimpan pada penyimpanan publik
                dan akan tampil di halaman galeri website.
            </p>
        </div>
    </div>

    <section class="admin-card">
        @include('admincakraaji.gallery._form')
    </section>
@endsection
