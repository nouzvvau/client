@extends('layouts.admin')

@section('title', 'Ubah Murid')
@section('admin_eyebrow', 'Daftar Murid')
@section('admin_title', 'Ubah Murid')

@section('content')
    <div class="admin-page-head">
        <div>
            <a href="{{ route('admin.nama-murid') }}" class="admin-btn admin-btn--sm" style="margin-bottom:10px;">
                <x-admin.icon name="arrow-left" />
                Kembali
            </a>
            <h2 class="admin-page-head__title">Ubah data murid</h2>
            <p class="admin-page-head__desc">{{ $student->name }}</p>
        </div>
    </div>

    <div class="admin-detail-grid">
        <section class="admin-card">
            <form action="{{ route('admin.nama-murid.update', $student) }}" method="POST" class="admin-form">
                @csrf
                @method('PUT')

                <div class="admin-form-grid">
                    <div class="admin-field admin-field--full">
                        <label for="nama_murid">Nama murid</label>
                        <input id="nama_murid" type="text" name="nama_murid" value="{{ old('nama_murid', $student->name) }}" required class="admin-input">
                    </div>

                    <div class="admin-field">
                        <label for="program_id">Kelas / program</label>
                        <select id="program_id" name="program_id" class="admin-select">
                            <option value="">Belum ditentukan</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}" @selected(old('program_id', $student->class) === $program->id)>{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-field">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="admin-select">
                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $student->status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-field">
                        <label for="joined_at">Tanggal bergabung</label>
                        <input id="joined_at" type="date" name="joined_at" value="{{ old('joined_at', $student->joined_at?->format('Y-m-d')) }}" class="admin-input">
                    </div>
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <x-admin.icon name="check" />
                        Simpan perubahan
                    </button>
                    <a href="{{ route('admin.nama-murid') }}" class="admin-btn">Batal</a>
                </div>
            </form>
        </section>

        <section class="admin-card" style="border-color:#e3b1b3;">
            <div class="admin-card__head">
                <div>
                    <h3 class="admin-card__title" style="color:var(--admin-red);">Hapus murid</h3>
                    <p class="admin-card__desc">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>

            <form action="{{ route('admin.nama-murid.destroy', $student) }}" method="POST" data-confirm="Hapus murid {{ $student->name }}?">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-btn admin-btn--danger admin-btn--block">
                    <x-admin.icon name="trash" />
                    Hapus murid
                </button>
            </form>
        </section>
    </div>
@endsection
