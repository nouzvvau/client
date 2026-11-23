@extends('layouts.admin')

@section('title', 'Daftar Murid')
@section('admin_eyebrow', 'Daftar Murid')
@section('admin_title', 'Daftar Murid')

@section('content')
    <div class="admin-page-head">
        <div>
            <h2 class="admin-page-head__title">Data murid sanggar</h2>
            <p class="admin-page-head__desc">
                Kelola nama murid, kelas, status, dan tanggal bergabung. Data murid
                dapat ditambahkan langsung atau melalui konversi dari pendaftar.
            </p>
        </div>
    </div>

    <div class="admin-stat-grid">
        <div class="admin-stat">
            <span class="admin-stat__label">Total Murid</span>
            <strong class="admin-stat__value">{{ $stats['total'] }}</strong>
            <span class="admin-stat__hint">Seluruh data murid</span>
        </div>
        <div class="admin-stat admin-stat--olive">
            <span class="admin-stat__label">Murid Aktif</span>
            <strong class="admin-stat__value">{{ $stats['active'] }}</strong>
            <span class="admin-stat__hint">Status aktif</span>
        </div>
        <div class="admin-stat admin-stat--red">
            <span class="admin-stat__label">Nonaktif</span>
            <strong class="admin-stat__value">{{ $stats['inactive'] }}</strong>
            <span class="admin-stat__hint">Tidak aktif saat ini</span>
        </div>
        <div class="admin-stat admin-stat--brown">
            <span class="admin-stat__label">Punya Kelas</span>
            <strong class="admin-stat__value">{{ $stats['with_class'] }}</strong>
            <span class="admin-stat__hint">Murid dengan kelas terisi</span>
        </div>
    </div>

    <section class="admin-card">
        <div class="admin-card__head">
            <div>
                <h3 class="admin-card__title">Tambah murid</h3>
                <p class="admin-card__desc">Tambahkan murid baru ke daftar sanggar.</p>
            </div>
        </div>

        <form action="{{ route('admin.nama-murid.store') }}" method="POST" class="admin-form">
            @csrf

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="nama_murid">Nama murid</label>
                    <input id="nama_murid" type="text" name="nama_murid" value="{{ old('nama_murid') }}" required class="admin-input">
                </div>

                <div class="admin-field">
                    <label for="program_id">Kelas / program</label>
                    <select id="program_id" name="program_id" class="admin-select">
                        <option value="">Belum ditentukan</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class }}" @selected(old('program_id') === $class)>{{ $class }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-field">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="admin-select">
                        @foreach ($statuses as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', \App\Models\Student::STATUS_ACTIVE) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-field">
                    <label for="joined_at">Tanggal bergabung</label>
                    <input id="joined_at" type="date" name="joined_at" value="{{ old('joined_at') }}" class="admin-input">
                </div>
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="admin-btn admin-btn--primary">
                    <x-admin.icon name="plus" />
                    Tambah murid
                </button>
            </div>
        </form>
    </section>

    <section class="admin-card" style="margin-top: 20px;">
        <form method="GET" action="{{ route('admin.nama-murid') }}" class="admin-filter">
            <div class="admin-field">
                <label for="cari">Cari murid</label>
                <input id="cari" type="search" name="cari" value="{{ request('cari') }}" placeholder="Nama murid" class="admin-input">
            </div>

            <div class="admin-field">
                <label for="kelas">Kelas</label>
                <select id="kelas" name="kelas" class="admin-select">
                    <option value="">Semua kelas</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class }}" @selected(request('kelas') === $class)>{{ $class }}</option>
                    @endforeach
                </select>
            </div>

            <div class="admin-field">
                <label for="status-filter">Status</label>
                <select id="status-filter" name="status" class="admin-select">
                    <option value="">Semua status</option>
                    @foreach ($statuses as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="admin-filter__actions">
                <button type="submit" class="admin-btn admin-btn--primary">
                    <x-admin.icon name="search" />
                    Cari
                </button>
                @if (request()->filled('cari') || request()->filled('kelas') || request()->filled('status'))
                    <a href="{{ route('admin.nama-murid') }}" class="admin-btn">Reset</a>
                @endif
            </div>
        </form>

        @if ($murids->isNotEmpty())
            <div class="admin-table-wrap" style="margin-top: 18px;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Tanggal Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($murids as $murid)
                            <tr>
                                <td class="admin-table__primary">{{ $murid->name }}</td>
                                <td>{{ $murid->class ?: '—' }}</td>
                                <td>
                                    <span class="admin-badge admin-badge--{{ $murid->statusBadgeClass() }}">
                                        {{ $murid->statusLabel() }}
                                    </span>
                                </td>
                                <td class="admin-table__nowrap">{{ $murid->joined_at?->format('d/m/Y') ?? '—' }}</td>
                                <td>
                                    <div class="admin-table__actions">
                                        <a href="{{ route('admin.nama-murid.edit', $murid) }}" class="admin-btn admin-btn--sm">
                                            <x-admin.icon name="pencil" />
                                            Ubah
                                        </a>
                                        <form action="{{ route('admin.nama-murid.destroy', $murid) }}" method="POST" data-confirm="Hapus murid {{ $murid->name }}?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-btn admin-btn--danger admin-btn--sm">
                                                <x-admin.icon name="trash" />
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <x-admin.pagination :paginator="$murids" />
        @else
            <div class="admin-empty">
                <span class="admin-empty__title">
                    @if (request()->filled('cari') || request()->filled('kelas') || request()->filled('status'))
                        Murid tidak ditemukan
                    @else
                        Belum ada data murid
                    @endif
                </span>
                @if (request()->filled('cari') || request()->filled('kelas') || request()->filled('status'))
                    Coba ubah kata kunci atau filter pencarian.
                @else
                    Tambahkan murid pertama melalui formulir di atas.
                @endif
            </div>
        @endif
    </section>
@endsection
