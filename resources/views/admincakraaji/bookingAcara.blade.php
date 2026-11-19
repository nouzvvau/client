<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Acara - Panel Admin Sanggar Seni Cakra Aji</title>
    <!-- Menggunakan Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FEFFC4] min-h-screen font-sans text-zinc-900 flex">

    <!-- SIDEBAR KIRI -->
    <aside class="w-64 bg-[#3C1808] text-white flex flex-col justify-between shrink-0 min-h-screen">
        <div>
            <!-- Logo Sanggar -->
            <div class="p-6 flex items-center space-x-3 border-b border-[#552713]">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <img src="{{ asset('assets/images/logo-navbar.png') }}"
                         alt="Logo Sanggar Seni Cakra Aji"
                         class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-sm font-bold tracking-wide">Sanggar Seni</h1>
                    <span class="text-xs text-[#FFBC4C]">Cakra Aji <span class="text-[9px] text-gray-400">Est.2020</span></span>
                </div>
            </div>

            <!-- Menu Navigasi -->
            <div class="px-4 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Panel Admin</div>
            <nav class="space-y-1 px-3 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#552713] hover:text-white transition">Dashboard</a>
                <a href="{{ route('admin.pendaftar') }}" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#552713] hover:text-white transition">Pendaftar Siswa</a>
                <a href="{{ route('admin.booking') }}" class="flex items-center px-3 py-2.5 rounded bg-[#FFBC4C] text-zinc-900 font-medium">Booking Acara</a>
                <a href="{{ route('admin.nama-murid') }}" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#552713] hover:text-white transition">Pengaturan Daftar Nama Siswa</a>
                <a href="{{ route('admin.galeri') }}" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#552713] hover:text-white transition">Galeri & Dokumentasi</a>
            </nav>
        </div>

        <!-- Tombol Bawah Sidebar -->
        <div class="p-4 border-t border-[#552713] space-y-2 text-sm">
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
            <span class="text-xs font-bold text-[#C1272D] uppercase tracking-widest">Booking Acara</span>
            <h2 class="text-3xl font-extrabold text-zinc-900 mt-1">Booking acara</h2>
        </div>

        <div class="w-full h-px bg-zinc-300 mb-8"></div>

        <!-- Deskripsi Singkat -->
        <p class="text-sm text-zinc-700 mb-8 max-w-3xl">
            Daftar permintaan yang masuk lewat formulir "Booking Acara" di website. Hubungi yang berstatus <strong class="text-[#C1272D]">BARU</strong> lebih dulu.
        </p>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-sm mb-8 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Kartu Statistik Ringkasan Status -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <!-- Kotak 1: Baru -->
            <div class="bg-white border-2 border-[#3C1808] p-5 rounded-sm shadow-[4px_4px_0px_0px_#3C1808]">
                <span class="text-[11px] font-bold tracking-wider text-zinc-600 uppercase">
                    BARU
                </span>
                <div class="text-3xl font-extrabold text-zinc-900 my-1">
                    [{{ $jumlahBaru }}]
                </div>
                <span class="text-xs text-zinc-500">
                    belum diproses
                </span>
            </div>

            <!-- Kotak 2: Dikonfirmasi -->
            <div class="bg-white border-2 border-[#3C1808] p-5 rounded-sm shadow-[4px_4px_0px_0px_#3C1808]">
                <span class="text-[11px] font-bold tracking-wider text-zinc-600 uppercase">
                    DIKONFIRMASI
                </span>
                <div class="text-3xl font-extrabold text-zinc-900 my-1">
                    [{{ $jumlahDikonfirmasi }}]
                </div>
                <span class="text-xs text-zinc-500">
                    booking diterima
                </span>
            </div>

            <!-- Kotak 3: Ditolak -->
            <div class="bg-white border-2 border-[#3C1808] p-5 rounded-sm shadow-[4px_4px_0px_0px_#3C1808]">
                <span class="text-[11px] font-bold tracking-wider text-zinc-600 uppercase">
                    DITOLAK
                </span>
                <div class="text-3xl font-extrabold text-zinc-900 my-1">
                    [{{ $jumlahDitolak }}]
                </div>
                <span class="text-xs text-zinc-500">
                    booking tidak diterima
                </span>
            </div>
        </div>

        <!-- Filter Pencarian & Status -->
        <form method="GET" action="{{ route('admin.booking') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2">
                <label class="block text-xs font-bold text-zinc-800 mb-1">Cari nama</label>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Ketik nama pemesan, instansi, atau nama acara" class="w-full bg-white px-4 py-2.5 border border-zinc-400 rounded-sm text-sm focus:outline-none focus:border-[#3C1808]">
            </div>
            <div>
                <label class="block text-xs font-bold text-zinc-800 mb-1">Tampilkan status</label>
                <select name="status" class="w-full bg-white px-4 py-2.5 border border-zinc-400 rounded-sm text-sm focus:outline-none focus:border-[#3C1808]">
                    <option value="">Semua</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Baru</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="lg:col-span-3">
                <button type="submit" class="bg-[#3C1808] hover:bg-[#552713] text-white text-xs font-bold py-2.5 px-6 rounded-sm transition">
                    Terapkan filter
                </button>
            </div>
        </form>

        <!-- Tabel Booking Acara -->
        <div class="border-2 border-[#3C1808] bg-white rounded-sm shadow-[6px_6px_0px_0px_#3C1808] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#3C1808] text-white text-xs uppercase tracking-wider">
                            <th class="py-3 px-4 font-semibold">Masuk</th>
                            <th class="py-3 px-4 font-semibold">Pemesan</th>
                            <th class="py-3 px-4 font-semibold">Acara</th>
                            <th class="py-3 px-4 font-semibold">Tanggal & lokasi</th>
                            <th class="py-3 px-4 font-semibold">Status</th>
                            <th class="py-3 px-4 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 text-sm">
                        @forelse ($bookings as $booking)
                            <tr class="hover:bg-zinc-50 transition">
                                <td class="py-4 px-4 text-xs text-zinc-600">
                                    {{ $booking->created_at?->translatedFormat('d M Y H:i') }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-bold text-zinc-900">{{ $booking->name }}</div>
                                    <div class="text-xs text-zinc-500">{{ $booking->institution_name }} · {{ $booking->phone }}</div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-bold text-zinc-900">{{ $booking->event_name }}</div>
                                    <div class="text-xs text-zinc-500">{{ $booking->service_type }}</div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="text-zinc-900">{{ $booking->event_date?->translatedFormat('d M Y') }}{{ $booking->start_time ? ', ' . substr($booking->start_time, 0, 5) : '' }}</div>
                                    <div class="text-xs text-zinc-500">{{ $booking->event_location }}</div>
                                </td>
                                <td class="py-4 px-4">
                                    @php
                                        $badge = match ($booking->status) {
                                            'pending' => ['bg-[#C1272D]', 'BARU'],
                                            'accepted' => ['bg-[#91A052]', 'DIKONFIRMASI'],
                                            'rejected' => ['bg-zinc-500', 'DITOLAK'],
                                            default => ['bg-zinc-500', strtoupper($booking->status)],
                                        };
                                    @endphp
                                    <span class="inline-block px-2.5 py-1 {{ $badge[0] }} text-white text-[10px] font-bold rounded uppercase tracking-wider">{{ $badge[1] }}</span>
                                </td>
                                <td class="py-4 px-4 space-y-2">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->phone) }}" target="_blank" rel="noopener" class="block text-center border border-zinc-400 bg-white hover:bg-zinc-100 text-zinc-900 text-xs font-medium py-1.5 px-3 rounded shadow-sm transition">
                                        Hubungi lewat WhatsApp
                                    </a>
                                    <form action="{{ route('admin.booking.status', $booking) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <select name="status" class="flex-1 bg-white border border-zinc-400 rounded text-xs px-2 py-1.5 focus:outline-none focus:border-[#3C1808]">
                                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Baru</option>
                                            <option value="accepted" {{ $booking->status == 'accepted' ? 'selected' : '' }}>Dikonfirmasi</option>
                                            <option value="rejected" {{ $booking->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                        <button type="submit" class="border border-zinc-400 bg-white hover:bg-zinc-100 text-zinc-900 text-xs font-medium py-1.5 px-3 rounded shadow-sm transition whitespace-nowrap">
                                            Ubah status
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.booking.destroy', $booking) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus booking dari {{ addslashes($booking->name) }}? Data yang dihapus tidak dapat dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full border border-red-400 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-medium py-1.5 px-3 rounded shadow-sm transition">
                                            Hapus booking
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-4 text-center">
                                    <div class="text-zinc-500 font-semibold">
                                        @if (request('cari') || request('status'))
                                            Tidak ada booking yang cocok dengan filter.
                                        @else
                                            Belum ada booking acara.
                                        @endif
                                    </div>
                                    <p class="text-xs text-zinc-400 mt-2">
                                        Data akan muncul di sini setelah ada yang mengisi formulir booking di website.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginasi -->
        @if ($bookings->hasPages())
            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @endif

        <!-- Catatan Footer Tabel -->
        <p class="text-xs text-zinc-600 mt-4 italic">
            Tombol <strong>Hubungi lewat WhatsApp</strong> membuka chat dengan nomor yang diisi pengunjung. Setelah itu, ubah statusnya agar daftar tetap rapi.
        </p>

    </main>

</body>
</html>
