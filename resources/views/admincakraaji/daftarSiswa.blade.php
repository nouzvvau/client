<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftar Siswa - Panel Admin Sanggar Seni Cakra Aji</title>
    <!-- Menggunakan Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FFF9CC] min-h-screen font-sans text-zinc-900 flex">

    <!-- SIDEBAR KIRI -->
    <aside class="w-64 bg-[#3B2219] text-white flex flex-col justify-between shrink-0 min-h-screen">
        <div>
            <!-- Logo Sanggar -->
            <div class="p-6 flex items-center space-x-3 border-b border-[#4d2f23]">
                <div class="w-10 h-10 border-2 border-[#D4A373] rounded-full flex items-center justify-center shrink-0">
                    <span class="text-[10px] text-[#D4A373]">Logo</span>
                </div>
                <div>
                    <h1 class="text-sm font-bold tracking-wide">Sanggar Seni</h1>
                    <span class="text-xs text-[#D4A373]">Cakra Aji <span class="text-[9px] text-gray-400">Est.2020</span></span>
                </div>
            </div>

            <!-- Menu Navigasi -->
            <div class="px-4 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Panel Admin</div>
            <nav class="space-y-1 px-3 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Dashboard</a>
                <a href="{{ route('admin.pendaftar') }}" class="flex items-center px-3 py-2.5 rounded bg-[#E9C46A] text-zinc-900 font-medium">Pendaftar Siswa</a>
                <a href="{{ route('admin.booking') }}" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Booking Acara</a>
                <a href="{{ route('admin.nama-murid') }}" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Pengaturan Daftar Nama Siswa</a>
                <a href="{{ route('admin.galeri') }}" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Galeri & Dokumentasi</a>
            </nav>
        </div>

        <!-- Tombol Bawah Sidebar -->
        <div class="p-4 border-t border-[#4d2f23] space-y-2 text-sm">
            <a href="{{ url('/') }}" target="_blank" class="flex items-center space-x-2 text-gray-300 hover:text-white">
                <span>Lihat website ↗</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left text-red-400 hover:text-red-300">Keluar</button>
            </form>
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 p-8 lg:p-12 overflow-y-auto">

        <!-- Header Halaman -->
        <div class="mb-8">
            <span class="text-xs font-bold text-[#A34723] uppercase tracking-widest">Pendaftaran Murid Baru</span>
            <h2 class="text-3xl font-extrabold text-zinc-900 mt-1">Pendaftar siswa</h2>
        </div>

        <div class="w-full h-px bg-zinc-300 mb-8"></div>

        <!-- Deskripsi Singkat -->
        <p class="text-sm text-zinc-700 mb-8 max-w-3xl">
            Daftar orang yang mengisi formulir "Daftar Murid" di website. Hubungi yang berstatus <strong class="text-[#A34723]">MENUNGGU</strong> lebih dulu.
        </p>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-sm mb-8 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Kartu Statistik Ringkasan Status -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Kotak 1: Menunggu -->
            <div class="bg-white border-2 border-[#3B2219] p-5 rounded-sm shadow-[4px_4px_0px_0px_#3B2219]">
                <span class="text-[11px] font-bold tracking-wider text-zinc-600 uppercase">MENUNGGU</span>
                <div class="text-3xl font-extrabold text-zinc-900 my-1">[{{ $jumlahBaru }}]</div>
                <span class="text-xs text-zinc-500">belum dihubungi</span>
            </div>
            <!-- Kotak 2: Sudah Dihubungi -->
            <div class="bg-white border-2 border-[#3B2219] p-5 rounded-sm shadow-[4px_4px_0px_0px_#3B2219]">
                <span class="text-[11px] font-bold tracking-wider text-zinc-600 uppercase">SUDAH DIHUBUNGI</span>
                <div class="text-3xl font-extrabold text-zinc-900 my-1">[{{ $jumlahDihubungi }}]</div>
                <span class="text-xs text-zinc-500">menunggu keputusan</span>
            </div>
            <!-- Kotak 3: Diterima -->
            <div class="bg-white border-2 border-[#3B2219] p-5 rounded-sm shadow-[4px_4px_0px_0px_#3B2219]">
                <span class="text-[11px] font-bold tracking-wider text-zinc-600 uppercase">DITERIMA</span>
                <div class="text-3xl font-extrabold text-zinc-900 my-1">[{{ $jumlahDiterima }}]</div>
                <span class="text-xs text-zinc-500">selesai</span>
            </div>
        </div>

        <!-- Filter Pencarian & Status -->
        <form method="GET" action="{{ route('admin.pendaftar') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2">
                <label class="block text-xs font-bold text-zinc-800 mb-1">Cari nama</label>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Ketik nama murid atau wali" class="w-full bg-white px-4 py-2.5 border border-zinc-400 rounded-sm text-sm focus:outline-none focus:border-[#3B2219]">
            </div>
            <div>
                <label class="block text-xs font-bold text-zinc-800 mb-1">Tampilkan status</label>
                <select name="status" class="w-full bg-white px-4 py-2.5 border border-zinc-400 rounded-sm text-sm focus:outline-none focus:border-[#3B2219]">
                    <option value="">Semua status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Dihubungi" {{ request('status') == 'Dihubungi' ? 'selected' : '' }}>Dihubungi</option>
                    <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                </select>
            </div>
            <div class="lg:col-span-3">
                <button type="submit" class="bg-[#3B2219] hover:bg-[#2b1812] text-white text-xs font-bold py-2.5 px-6 rounded-sm transition">
                    Terapkan filter
                </button>
            </div>
        </form>

        <!-- Tabel Pendaftar -->
        <div class="border-2 border-[#3B2219] bg-white rounded-sm shadow-[6px_6px_0px_0px_#3B2219] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#3B2219] text-white text-xs uppercase tracking-wider">
                            <th class="py-3 px-4 font-semibold">Masuk</th>
                            <th class="py-3 px-4 font-semibold">Calon murid</th>
                            <th class="py-3 px-4 font-semibold">Wali & kontak</th>
                            <th class="py-3 px-4 font-semibold">Program</th>
                            <th class="py-3 px-4 font-semibold">Status</th>
                            <th class="py-3 px-4 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 text-sm">
                        @forelse ($pendaftars as $pendaftar)
                            <tr class="hover:bg-zinc-50 transition">
                                <td class="py-4 px-4 text-xs text-zinc-600">
                                    {{ $pendaftar->created_at?->translatedFormat('d M Y H:i') }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-bold text-zinc-900">{{ $pendaftar->nama_murid }}</div>
                                    <div class="text-xs text-zinc-500">Lahir: {{ $pendaftar->tanggal_lahir?->translatedFormat('d M Y') }}</div>
                                    @if ($pendaftar->catatan)
                                        <div class="text-xs text-zinc-500 mt-1 italic">"{{ $pendaftar->catatan }}"</div>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="text-zinc-900">{{ $pendaftar->nama_wali }}</div>
                                    <div class="text-xs text-zinc-500">{{ $pendaftar->whatsapp }}</div>
                                    @if ($pendaftar->alamat)
                                        <div class="text-xs text-zinc-500">{{ $pendaftar->alamat }}</div>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="text-zinc-900">{{ $pendaftar->program }}</div>
                                    <div class="text-xs text-zinc-500">Pengalaman: {{ $pendaftar->pengalaman }}</div>
                                </td>
                                <td class="py-4 px-4">
                                    @php
                                        $badge = match ($pendaftar->status) {
                                            'Menunggu' => ['bg-[#A34723]', 'MENUNGGU'],
                                            'Dihubungi' => ['bg-[#D97706]', 'SUDAH DIHUBUNGI'],
                                            'Diterima' => ['bg-[#4A7C59]', 'DITERIMA'],
                                            default => ['bg-zinc-500', strtoupper($pendaftar->status)],
                                        };
                                    @endphp
                                    <span class="inline-block px-2.5 py-1 {{ $badge[0] }} text-white text-[10px] font-bold rounded uppercase tracking-wider">{{ $badge[1] }}</span>
                                </td>
                                <td class="py-4 px-4 space-y-2 min-w-[180px]">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pendaftar->whatsapp) }}" target="_blank" rel="noopener" class="block text-center border border-zinc-400 bg-white hover:bg-zinc-100 text-zinc-900 text-xs font-medium py-1.5 px-3 rounded shadow-sm transition">
                                        Hubungi lewat WhatsApp
                                    </a>

                                    <form action="{{ route('admin.pendaftar.status', $pendaftar) }}" method="POST" class="space-y-2">
                                        @csrf

                                        <select name="status" required class="w-full bg-white border border-zinc-300 rounded px-2 py-1.5 text-xs">
                                            <option value="Menunggu" {{ $pendaftar->status === 'Menunggu' ? 'selected' : '' }}>
                                                Menunggu
                                            </option>
                                            <option value="Dihubungi" {{ $pendaftar->status === 'Dihubungi' ? 'selected' : '' }}>
                                                Dihubungi
                                            </option>
                                            <option value="Diterima" {{ $pendaftar->status === 'Diterima' ? 'selected' : '' }}>
                                                Diterima
                                            </option>
                                        </select>

                                        <button type="submit" class="w-full bg-[#3B2219] hover:bg-[#2b1812] text-white text-xs font-medium py-1.5 px-3 rounded transition">
                                            Simpan Status
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-4 text-center">
                                    <div class="text-zinc-500 font-semibold">
                                        @if (request('cari') || request('status'))
                                            Tidak ada pendaftar yang cocok dengan filter.
                                        @else
                                            Belum ada pendaftar murid.
                                        @endif
                                    </div>
                                    <p class="text-xs text-zinc-400 mt-2">
                                        Data akan muncul di sini setelah ada orang yang mengisi formulir pendaftaran di website.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginasi -->
        @if ($pendaftars->hasPages())
            <div class="mt-6">
                {{ $pendaftars->links() }}
            </div>
        @endif

    </main>

</body>
</html>
