@extends('layouts.admin')

@section('title', 'Ubah Dokumentasi')
@section('admin_eyebrow', 'Galeri Acara')
@section('admin_title', 'Ubah Dokumentasi')

@section('content')
    <div class="admin-page-head">
        <div>
            <a href="{{ route('admin.gallery.show', $documentation) }}" class="admin-btn admin-btn--sm" style="margin-bottom:10px;">
                <x-admin.icon name="arrow-left" />
                Kembali ke detail
            </a>
            <h2 class="admin-page-head__title">Ubah dokumentasi</h2>
            <p class="admin-page-head__desc">{{ $documentation->title }}</p>
        </div>
    </div>

    <section class="admin-card">
        @include('admincakraaji.gallery._form')
    </section>
@endsection
