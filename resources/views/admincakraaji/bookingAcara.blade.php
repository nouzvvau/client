<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Acara - Panel Admin Sanggar Seni Cakra Aji</title>
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
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Dashboard</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Pendaftar Siswa</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded bg-[#E9C46A] text-zinc-900 font-medium">Booking Acara</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Beranda & Tentang Kami</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Program & Kegiatan</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Galeri & Dokumentasi</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Pengaturan WhatsApp</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Contact Person</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Pengaturan Language Switcher</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Pengaturan Daftar Nama Siswa</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Pengaturan & Akun</a>
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
        
        <!-- Header Halaman & Tombol WhatsApp -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <span class="text-xs font-bold text-[#A34723] uppercase tracking-widest">Booking Acara</span>
                <h2 class="text-3xl font-extrabold text-zinc-900 mt-1">Booking acara</h2>
            </div>
            <a href="#" class="border border-[#3B2219] bg-transparent text-[#3B2219] hover:bg-[#3B2219] hover:text-white px-5 py-2.5 rounded-full text-xs font-bold tracking-wide transition flex items-center space-x-2">
                <span>Atur pesan WhatsApp</span>
            </a>
        </div>

        <div class="w-full h-px bg-zinc-300 mb-8"></div>

        <!-- Deskripsi Singkat -->
        <p class="text-sm text-zinc-700 mb-8 max-w-3xl">
            Daftar permintaan yang masuk lewat formulir "Booking Acara" di website (versi masuk ke admin). Hubungi yang berstatus <strong class="text-[#A34723]">BARU</strong> lebih dulu.
        </p>

        <!-- Kartu Statistik Ringkasan Status -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Kotak 1: Baru -->
            <div class="bg-white border-2 border-[#3B2219] p-5 rounded-sm shadow-[4px_4px_0px_0px_#3B2219]">
                <span class="text-[11px] font-bold tracking-wider text-zinc-600 uppercase">BARU</span>
                <div class="text-3xl font-extrabold text-zinc-900 my-1">[{{ $jumlahBaru ?? '00' }}]</div>
                <span class="text-xs text-zinc-500">belum dihubungi</span>
            </div>
            <!-- Kotak 2: Sudah Dihubungi -->
            <div class="bg-white border-2 border-[#3B2219] p-5 rounded-sm shadow-[4px_4px_0px_0px_#3B2219]">
                <span class="text-[11px] font-bold tracking-wider text-zinc-600 uppercase">SUDAH DIHUBUNGI</span>
                <div class="text-3xl font-extrabold text-zinc-900 my-1">[{{ $jumlahDihubungi ?? '00' }}]</div>
                <span class="text-xs text-zinc-500">menunggu keputusan</span>
            </div>
            <!-- Kotak 3: Dikonfirmasi -->
            <div class="bg-white border-2 border-[#3B2219] p-5 rounded-sm shadow-[4px_4px_0px_0px_#3B2219]">
                <span class="text-[11px] font-bold tracking-wider text-zinc-600 uppercase">DIKONFIRMASI</span>
                <div class="text-3xl font-extrabold text-zinc-900 my-1">[{{ $jumlahDikonfirmasi ?? '00' }}]</div>
                <span class="text-xs text-zinc-500">selesai</span>
            </div>
        </div>

        <!-- Filter Pencarian & Status -->
        <form method="GET" action="" class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2">
                <label class="block text-xs font-bold text-zinc-800 mb-1">Cari nama</label>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Ketik nama" class="w-full bg-white px-4 py-2.5 border border-zinc-400 rounded-sm text-sm focus:outline-none focus:border-[#3B2219]">
            </div>
            <div>
                <label class="block text-xs font-bold text-zinc-800 mb-1">Tampilkan status</label>
                <select name="status" class="w-full bg-white px-4 py-2.5 border border-zinc-400 rounded-sm text-sm focus:outline-none focus:border-[#3B2219]">
                    <option value="">Semua</option>
                    <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="dihubungi" {{ request('status') == 'dihubungi' ? 'selected' : '' }}>Sudah Dihubungi</option>
                    <option value="dikonfirmasi" {{ request('status') == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                </select>
            </div>
        </form>

        <!-- Tabel Booking Acara -->
        <div class="border-2 border-[#3B2219] bg-white rounded-sm shadow-[6px_6px_0px_0px_#3B2219] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#3B2219] text-white text-xs uppercase tracking-wider">
                            <th class="py-3 px-4 font-semibold">Masuk</th>
                            <th class="py-3 px-4 font-semibold">Pemesan</th>
                            <th class="py-3 px-4 font-semibold">Acara</th>
                            <th class="py-3 px-4 font-semibold">Tanggal & lokasi</th>
                            <th class="py-3 px-4 font-semibold">Status</th>
                            <th class="py-3 px-4 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 text-sm">
                        
                        <!-- Baris Data 1 (Status: BARU) -->
                        <tr class="hover:bg-zinc-50 transition">
                            <td class="py-4 px-4 text-xs text-zinc-600">[Tanggal]</td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-zinc-900">[Nama pemesan]</div>
                                <div class="text-xs text-zinc-500">[Instansi] · [Nomor WhatsApp]</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-zinc-900">[Nama acara]</div>
                                <div class="text-xs text-zinc-500">[Jenis kebutuhan]</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-zinc-900">[Tanggal acara]</div>
                                <div class="text-xs text-zinc-500">[Lokasi]</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-block px-2.5 py-1 bg-[#A34723] text-white text-[10px] font-bold rounded uppercase tracking-wider">BARU</span>
                            </td>
                            <td class="py-4 px-4 space-y-2">
                                <a href="https://wa.me/[NomorWhatsApp]" target="_blank" class="block text-center border border-zinc-400 bg-white hover:bg-zinc-100 text-zinc-900 text-xs font-medium py-1.5 px-3 rounded shadow-sm transition">
                                    Hubungi lewat WhatsApp
                                </a>
                                <a href="#" class="block text-center border border-zinc-400 bg-white hover:bg-zinc-100 text-zinc-900 text-xs font-medium py-1.5 px-3 rounded shadow-sm transition">
                                    Ubah status
                                </a>
                            </td>
                        </tr>

                        <!-- Baris Data 2 (Status: SUDAH DIHUBUNGI) -->
                        <tr class="hover:bg-zinc-50 transition">
                            <td class="py-4 px-4 text-xs text-zinc-600">[Tanggal]</td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-zinc-900">[Nama pemesan]</div>
                                <div class="text-xs text-zinc-500">[Instansi] · [Nomor WhatsApp]</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-zinc-900">[Nama acara]</div>
                                <div class="text-xs text-zinc-500">[Jenis kebutuhan]</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-zinc-900">[Tanggal acara]</div>
                                <div class="text-xs text-zinc-500">[Lokasi]</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-block px-2.5 py-1 bg-[#D97706] text-white text-[10px] font-bold rounded uppercase tracking-wider">SUDAH DIHUBUNGI</span>
                            </td>
                            <td class="py-4 px-4 space-y-2">
                                <a href="#" class="block text-center border border-zinc-400 bg-white hover:bg-zinc-100 text-zinc-900 text-xs font-medium py-1.5 px-3 rounded shadow-sm transition">
                                    Hubungi lewat WhatsApp
                                </a>
                                <a href="#" class="block text-center border border-zinc-400 bg-white hover:bg-zinc-100 text-zinc-900 text-xs font-medium py-1.5 px-3 rounded shadow-sm transition">
                                    Ubah status
                                </a>
                            </td>
                        </tr>

                        <!-- Baris Data 3 (Status: DIKONFIRMASI) -->
                        <tr class="hover:bg-zinc-50 transition">
                            <td class="py-4 px-4 text-xs text-zinc-600">[Tanggal]</td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-zinc-900">[Nama pemesan]</div>
                                <div class="text-xs text-zinc-500">[Instansi] · [Nomor WhatsApp]</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-zinc-900">[Nama acara]</div>
                                <div class="text-xs text-zinc-500">[Jenis kebutuhan]</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-zinc-900">[Tanggal acara]</div>
                                <div class="text-xs text-zinc-500">[Lokasi]</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-block px-2.5 py-1 bg-[#4A7C59] text-white text-[10px] font-bold rounded uppercase tracking-wider">DIKONFIRMASI</span>
                            </td>
                            <td class="py-4 px-4 space-y-2">
                                <a href="#" class="block text-center border border-zinc-400 bg-white hover:bg-zinc-100 text-zinc-900 text-xs font-medium py-1.5 px-3 rounded shadow-sm transition">
                                    Hubungi lewat WhatsApp
                                </a>
                                <a href="#" class="block text-center border border-zinc-400 bg-white hover:bg-zinc-100 text-zinc-900 text-xs font-medium py-1.5 px-3 rounded shadow-sm transition">
                                    Ubah status
                                </a>
                            </td>
                        </tr>

                        <!-- Baris Data 4 (Status: BARU) -->
                        <tr class="hover:bg-zinc-50 transition">
                            <td class="py-4 px-4 text-xs text-zinc-600">[Tanggal]</td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-zinc-900">[Nama pemesan]</div>
                                <div class="text-xs text-zinc-500">[Instansi] · [Nomor WhatsApp]</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-zinc-900">[Nama acara]</div>
                                <div class="text-xs text-zinc-500">[Jenis kebutuhan]</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-zinc-900">[Tanggal acara]</div>
                                <div class="text-xs text-zinc-500">[Lokasi]</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-block px-2.5 py-1 bg-[#A34723] text-white text-[10px] font-bold rounded uppercase tracking-wider">BARU</span>
                            </td>
                            <td class="py-4 px-4 space-y-2">
                                <a href="#" class="block text-center border border-zinc-400 bg-white hover:bg-zinc-100 text-zinc-900 text-xs font-medium py-1.5 px-3 rounded shadow-sm transition">
                                    Hubungi lewat WhatsApp
                                </a>
                                <a href="#" class="block text-center border border-zinc-400 bg-white hover:bg-zinc-100 text-zinc-900 text-xs font-medium py-1.5 px-3 rounded shadow-sm transition">
                                    Ubah status
                                </a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Catatan Footer Tabel -->
        <p class="text-xs text-zinc-600 mt-4 italic">
            Tombol <strong>Hubungi lewat WhatsApp</strong> membuka chat dengan nomor yang diisi pengunjung. Setelah itu, ubah statusnya agar daftar tetap rapi.
        </p>

    </main>

</body>
</html>