
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri & Dokumentasi - Panel Admin Cakra Aji</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-color: #fefce8;
        }
    </style>
</head>

<body class="flex min-h-screen text-stone-900">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#3a1d1d] text-[#fefce8] flex flex-col justify-between p-6">
        <div>
            <div class="flex flex-col items-center mb-8 text-center">
                <div class="w-16 h-16 rounded-full bg-[#fefce8] flex items-center justify-center mb-2 overflow-hidden border-2 border-yellow-600">
                    <span class="text-xs font-bold text-[#3a1d1d]">CAKRA AJI</span>
                </div>

                <span class="text-xs uppercase tracking-widest text-yellow-500 font-semibold mt-1">
                    Panel Admin
                </span>
            </div>

            <nav class="space-y-2 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Dashboard</a>
                <a href="{{ route('admin.pendaftar') }}" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Pendaftar Siswa</a>
                <a href="{{ route('admin.booking') }}" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Booking Acara</a>
                <a href="{{ route('admin.nama-murid') }}" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Pengaturan Daftar Nama Siswa</a>

                <a href="{{ route('admin.galeri') }}"
                   class="block py-2 px-3 rounded bg-amber-400 text-stone-900 font-bold shadow">
                    Galeri & Dokumentasi
                </a>
            </nav>
        </div>

        <div class="pt-6 border-t border-[#5c3131] text-sm space-y-2">
            <a href="{{ url('/') }}" target="_blank"
               class="block hover:text-amber-300 transition">
                Lihat website ↗
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="block hover:text-red-400 transition">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 p-10 overflow-y-auto">

        <!-- HEADER -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <p class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-1">
                    Galeri & Dokumentasi
                </p>

                <h1 class="text-3xl font-bold text-stone-900">
                    Acara & kolaborasi
                </h1>

                <p class="text-sm text-stone-700 mt-1">
                    Daftar kegiatan dan dokumentasi yang tersimpan di database.
                </p>
            </div>

            <a href="{{ route('admin.galeri.create') }}"
               class="bg-[#3a1d1d] text-amber-100 px-5 py-2.5 rounded-md font-semibold text-sm shadow hover:bg-[#4a2727] transition">
                + Tambah acara
            </a>
        </div>

        <!-- PENCARIAN -->
        <form action="{{ route('admin.galeri') }}" method="GET"
              class="mb-6">

            <div class="max-w-md">
                <label class="block text-xs font-bold text-stone-700 mb-1">
                    Cari acara
                </label>

                <div class="flex gap-2">
                    <input
                        type="text"
                        name="cari"
                        value="{{ request('cari') }}"
                        placeholder="Masukkan nama kegiatan..."
                        class="w-full bg-white border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">

                    <button type="submit"
                            class="bg-[#3a1d1d] hover:bg-[#4a2727] text-amber-100 px-4 py-2 rounded text-sm font-semibold">
                        Cari
                    </button>

                    @if(request('cari'))
                        <a href="{{ route('admin.galeri') }}"
                           class="border border-stone-300 bg-white px-3 py-2 rounded text-sm flex items-center">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <!-- TABEL DATA -->
        <div class="bg-white rounded shadow border border-stone-200 overflow-x-auto mb-4">

            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-[#3a1d1d] text-white text-xs uppercase tracking-wider">
                        <th class="py-3 px-4 font-semibold">Tahun</th>
                        <th class="py-3 px-4 font-semibold">Nama acara / kolaborasi</th>
                        <th class="py-3 px-4 font-semibold">Foto</th>
                        <th class="py-3 px-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-stone-200 text-sm">

                    @forelse($activities as $activity)

                        <tr class="hover:bg-stone-50">

                            <!-- TAHUN -->
                            <td class="py-4 px-4 font-bold text-red-700">
                                {{ $activity->date
                                    ? \Carbon\Carbon::parse($activity->date)->format('Y')
                                    : '-' }}
                            </td>

                            <!-- NAMA KEGIATAN -->
                            <td class="py-4 px-4">
                                <div class="font-bold text-stone-900">
                                    {{ $activity->title }}
                                </div>

                                <div class="text-xs text-stone-500 mt-1">
                                    {{ $activity->description
                                        ? \Illuminate\Support\Str::limit($activity->description, 100)
                                        : 'Tidak ada deskripsi' }}
                                </div>
                            </td>

                            <!-- JUMLAH FOTO -->
                            <td class="py-4 px-4 text-stone-700">
                                <span class="inline-flex items-center gap-1">
                                    <span>{{ $activity->photos_count }}</span>
                                    <span>foto</span>
                                </span>
                            </td>

                            <!-- AKSI -->
                            <td class="py-4 px-4 text-center">

                                <a
                                    href="{{ route('admin.galeri.edit', $activity) }}"
                                    class="inline-block bg-white border border-stone-400 hover:bg-stone-100 text-stone-800 px-3 py-1 rounded text-xs font-semibold shadow-sm">
                                    Ubah
                                </a>

                                <a
                                    href="{{ route('program.detail', [
                                        'slug' => \Illuminate\Support\Str::slug($activity->title)
                                    ]) }}"
                                    target="_blank"
                                    class="ml-1 inline-block bg-white border border-stone-400 hover:bg-stone-100 text-stone-800 px-3 py-1 rounded text-xs font-semibold shadow-sm">
                                    Lihat
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="py-12 px-4 text-center">

                                <div class="text-stone-500 font-semibold">
                                    @if(request('cari'))
                                        Kegiatan "{{ request('cari') }}" tidak ditemukan.
                                    @else
                                        Belum ada kegiatan di database.
                                    @endif
                                </div>

                                <p class="text-xs text-stone-400 mt-2">
                                    Data kegiatan akan muncul di sini setelah tersimpan.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- PAGINASI -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-stone-700">

            <span>
                Menampilkan
                <strong>{{ $activities->firstItem() ?? 0 }}</strong>
                –
                <strong>{{ $activities->lastItem() ?? 0 }}</strong>
                dari
                <strong>{{ $activities->total() }}</strong>
                kegiatan
            </span>

            <div>
                {{ $activities->links() }}
            </div>

        </div>

    </main>

</body>
</html>