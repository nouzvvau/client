<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dokumentasi: {{ $activity->title }} - Panel Admin Cakra Aji</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #fefce8;
        }
    </style>
</head>
<body class="flex min-h-screen text-stone-900">

    <!-- SIDEBAR KIRI -->
    <aside class="w-64 bg-[#3a1d1d] text-[#fefce8] flex flex-col justify-between p-6 shrink-0">
        <div>
            <!-- Logo & Judul Panel -->
            <div class="flex flex-col items-center mb-8 text-center">
                <div class="w-16 h-16 rounded-full bg-[#fefce8] flex items-center justify-center mb-2 overflow-hidden border-2 border-yellow-600">
                    <span class="text-xs font-bold text-[#3a1d1d]">CAKRA AJI</span>
                </div>
                <span class="text-xs uppercase tracking-widest text-yellow-500 font-semibold mt-1">Panel Admin</span>
            </div>

            <!-- Menu Navigasi -->
            <nav class="space-y-2 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Dashboard</a>
                <a href="{{ route('admin.pendaftar') }}" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Pendaftar Siswa</a>
                <a href="{{ route('admin.booking') }}" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Booking Acara</a>
                <a href="{{ route('admin.nama-murid') }}" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Pengaturan Daftar Nama Siswa</a>
                <a href="{{ route('admin.galeri') }}" class="block py-2 px-3 rounded bg-amber-400 text-stone-900 font-bold shadow">Galeri & Dokumentasi</a>
            </nav>
        </div>

        <!-- Footer Sidebar -->
        <div class="pt-6 border-t border-[#5c3131] text-sm space-y-2">
            <a href="{{ url('/') }}" target="_blank" class="block hover:text-amber-300 transition">Lihat website ↗</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="block hover:text-red-400 transition">Keluar</button>
            </form>
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 p-10 overflow-y-auto">
        <!-- Navigasi Kembali & Header Aksi Atas -->
        <div class="mb-6">
            <a href="{{ route('admin.galeri') }}" class="text-xs font-bold text-amber-800 hover:underline inline-flex items-center gap-1 mb-3">
                ‹ Kembali ke daftar acara
            </a>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-1">Edit Dokumentasi</p>
                    <h1 class="text-3xl font-bold text-stone-900">{{ $activity->title }}</h1>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-lg mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg mb-6 text-sm">
                <p class="font-semibold mb-2">Ada kesalahan:</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Layout Utama: Grid 2 Kolom (Kiri: Form Utama, Kanan: Sidebar Aksi/Status/Foto Sampul) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- KOLOM KIRI (Lebar 2) -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Box 1: Informasi Acara -->
                <div class="bg-white p-6 rounded-lg shadow border border-stone-200">
                    <h2 class="text-xl font-bold text-stone-900 mb-4 pb-2 border-b border-stone-100">Informasi acara</h2>

                    <form action="{{ route('admin.galeri.update', $activity) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Nama acara / kolaborasi</label>
                            <input type="text" name="title" value="{{ old('title', $activity->title) }}" required class="w-full bg-[#fefce8] border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-stone-700 mb-1">Tanggal pelaksanaan</label>
                                <input type="date" name="date" value="{{ old('date', $activity->date?->toDateString()) }}" class="w-full bg-[#fefce8] border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Deskripsi</label>
                            <textarea rows="4" name="description" class="w-full bg-[#fefce8] border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">{{ old('description', $activity->description) }}</textarea>
                        </div>

                        <div class="pt-2 border-t border-stone-100">
                            <button type="submit" class="bg-[#3a1d1d] hover:bg-[#4a2727] text-amber-100 px-5 py-2 rounded-md font-semibold text-sm shadow transition">
                                Simpan perubahan
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- KOLOM KANAN (Lebar 1) -->
            <div class="space-y-8">

                <!-- Box: Zona Berbahaya -->
                <div class="bg-white p-6 rounded-lg shadow border border-red-200">
                    <h2 class="text-xl font-bold text-red-700 mb-2 pb-2 border-b border-stone-100">Zona berbahaya</h2>
                    <p class="text-xs text-stone-600 mb-4">
                        Menghapus acara juga menghapus semua foto dokumentasinya dari galeri.
                    </p>
                    <form action="{{ route('admin.galeri.destroy', $activity) }}" method="POST" onsubmit="return confirm('Hapus acara {{ $activity->title }} beserta semua fotonya?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-700 hover:bg-red-800 text-white py-2 rounded font-semibold text-sm transition shadow-sm">
                            Hapus acara
                        </button>
                    </form>
                </div>

            </div>

        </div>

        <!-- SECTION BAWAH: Dokumentasi Foto (Full Lebar) -->
        <div class="mt-8 bg-[#85905d] p-6 rounded-lg shadow border border-stone-300">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                <div>
                    <h2 class="text-xl font-bold text-white mb-1">Dokumentasi foto</h2>
                    <p class="text-xs text-stone-100">
                        Foto-foto ini tampil di halaman dokumentasi acara.
                    </p>
                </div>

                <form action="{{ route('admin.galeri.photos.store', $activity) }}" method="POST" enctype="multipart/form-data" class="mt-3 md:mt-0 self-start flex items-end gap-2">
                    @csrf
                    <input type="file" name="photos[]" multiple accept="image/*"
                           class="bg-white border border-stone-300 rounded px-2 py-1.5 text-xs">
                    <button type="submit" class="bg-[#3a1d1d] hover:bg-[#4a2727] text-amber-100 px-4 py-2 rounded-md font-semibold text-sm shadow transition">
                        + Unggah foto
                    </button>
                </form>
            </div>

            <!-- Grid Kartu Foto Dokumentasi -->
            @if ($activity->photos->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($activity->photos as $photo)
                        <div class="bg-white p-3 rounded shadow relative flex flex-col justify-between">
                            <div>
                                <div class="w-full h-28 bg-stone-200 rounded mb-2 relative overflow-hidden flex items-center justify-center text-xs text-stone-400">
                                    <span class="absolute top-1.5 left-1.5 bg-stone-900 text-white text-[10px] font-bold px-1.5 py-0.5 rounded z-10">{{ $loop->iteration }}</span>
                                    @if ($loop->first)
                                        <span class="absolute top-1.5 right-1.5 bg-amber-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded z-10">SAMPUL</span>
                                    @endif
                                    <img src="{{ Storage::url($photo->photo) }}" alt="{{ $photo->caption ?? $activity->title }}" class="w-full h-full object-cover">
                                </div>
                                <label class="block text-[11px] font-bold text-stone-700 mb-1">Keterangan foto</label>
                                <input type="text" value="{{ $photo->caption ?? 'Keterangan singkat' }}" readonly class="w-full bg-[#fefce8] border border-stone-300 rounded px-2 py-1 text-xs mb-2">
                            </div>
                            <form action="{{ route('admin.galeri.photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Hapus foto ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-semibold text-left">Hapus foto</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="border-2 border-dashed border-stone-300/70 rounded-lg p-6 text-center text-white bg-[#7d8755] mb-6">
                    <p class="text-sm font-semibold mb-1">Belum ada foto dokumentasi</p>
                    <p class="text-xs text-stone-200">Unggah foto pertama menggunakan tombol "+ Unggah foto".</p>
                </div>
            @endif
        </div>
    </main>

</body>
</html>
