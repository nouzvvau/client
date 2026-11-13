<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri & Dokumentasi - Panel Admin Cakra Aji</title>
    <!-- Tailwind CSS CDN untuk styling cepat -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #fefce8; /* Warna latar belakang kuning muda */
        }
    </style>
</head>
<body class="flex min-h-screen text-stone-900">

    <!-- SIDEBAR KIRI -->
    <aside class="w-64 bg-[#3a1d1d] text-[#fefce8] flex flex-col justify-between p-6">
        <div>
            <!-- Logo & Judul Panel -->
            <div class="flex flex-col items-center mb-8 text-center">
                <div class="w-16 h-16 rounded-full bg-[#fefce8] flex items-center justify-center mb-2 overflow-hidden border-2 border-yellow-600">
                    <!-- Ganti path gambar logo sesuai asetmu -->
                    <span class="text-xs font-bold text-[#3a1d1d]">CAKRA AJI</span>
                </div>
                <span class="text-xs uppercase tracking-widest text-yellow-500 font-semibold mt-1">Panel Admin</span>
            </div>

            <!-- Menu Navigasi -->
            <nav class="space-y-2 text-sm">
                <a href="#" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Dashboard</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Pendaftar Siswa</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Booking Acara</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Beranda & Tentang Kami</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Program & Kegiatan</a>
                
                <!-- Menu Aktif -->
                <a href="#" class="block py-2 px-3 rounded bg-amber-400 text-stone-900 font-bold shadow">Galeri & Dokumentasi</a>
                
                <a href="#" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Pengaturan WhatsApp</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Contact Person</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Pengaturan Language Switcher</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Pengaturan Daftar Nama Siswa</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-[#4a2727] transition">Pengaturan & Akun</a>
            </nav>
        </div>

        <!-- Footer Sidebar -->
        <div class="pt-6 border-t border-[#5c3131] text-sm space-y-2">
            <a href="#" class="block hover:text-amber-300 transition">Lihat website ↗</a>
            <a href="#" class="block hover:text-red-400 transition">Keluar</a>
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 p-10 overflow-y-auto">
        <!-- Header Halaman -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <p class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-1">Galeri & Dokumentasi</p>
                <h1 class="text-3xl font-bold text-stone-900">Acara & kolaborasi</h1>
                <p class="text-sm text-stone-700 mt-1">
                    Daftar ini tampil di halaman Galeri & Portofolio. Klik <strong>Edit</strong> untuk mengubah halaman dokumentasi tiap acara.
                </p>
            </div>
            <button class="bg-[#3a1d1d] hover:bg-[#4a2727] text-amber-100 px-5 py-2.5 rounded-md font-semibold text-sm shadow transition">
                + Tambah acara
            </button>
        </div>

        <!-- Filter Pencarian & Kategori -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Cari acara</label>
                <input type="text" placeholder="Nama acara atau lokasi" class="w-full bg-white border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Kategori</label>
                <select class="w-full bg-white border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">
                    <option>Semua</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Status</label>
                <select class="w-full bg-white border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">
                    <option>Semua</option>
                </select>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white rounded shadow border border-stone-200 overflow-hidden mb-4">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#3a1d1d] text-white text-xs uppercase tracking-wider">
                        <th class="py-3 px-4 font-semibold">Tahun</th>
                        <th class="py-3 px-4 font-semibold">Nama acara / kolaborasi</th>
                        <th class="py-3 px-4 font-semibold">Kategori</th>
                        <th class="py-3 px-4 font-semibold">Foto</th>
                        <th class="py-3 px-4 font-semibold">Status</th>
                        <th class="py-3 px-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200 text-sm">
                    <!-- Baris 1 -->
                    <tr class="hover:bg-stone-50">
                        <td class="py-4 px-4 font-bold text-red-700">[Tahun]</td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-stone-900">[Nama acara / kolaborasi]</div>
                            <div class="text-xs text-stone-500">[Lokasi / penyelenggara]</div>
                        </td>
                        <td class="py-4 px-4 text-stone-700">[Kategori]</td>
                        <td class="py-4 px-4 text-stone-700">[n] foto</td>
                        <td class="py-4 px-4">
                            <span class="bg-emerald-700 text-white text-xs font-bold px-2.5 py-1 rounded">TERBIT</span>
                        </td>
                        <td class="py-4 px-4 text-center space-x-1">
                            <button class="bg-white border border-stone-400 hover:bg-stone-100 text-stone-800 px-3 py-1 rounded text-xs font-semibold shadow-sm">Edit</button>
                            <button class="bg-white border border-stone-400 hover:bg-stone-100 text-stone-800 px-3 py-1 rounded text-xs font-semibold shadow-sm">Lihat</button>
                        </td>
                    </tr>

                    <!-- Baris 2 -->
                    <tr class="hover:bg-stone-50">
                        <td class="py-4 px-4 font-bold text-red-700">[Tahun]</td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-stone-900">[Nama acara / kolaborasi]</div>
                            <div class="text-xs text-stone-500">[Lokasi / penyelenggara]</div>
                        </td>
                        <td class="py-4 px-4 text-stone-700">[Kategori]</td>
                        <td class="py-4 px-4 text-stone-700">[n] foto</td>
                        <td class="py-4 px-4">
                            <span class="bg-emerald-700 text-white text-xs font-bold px-2.5 py-1 rounded">TERBIT</span>
                        </td>
                        <td class="py-4 px-4 text-center space-x-1">
                            <button class="bg-white border border-stone-400 hover:bg-stone-100 text-stone-800 px-3 py-1 rounded text-xs font-semibold shadow-sm">Edit</button>
                            <button class="bg-white border border-stone-400 hover:bg-stone-100 text-stone-800 px-3 py-1 rounded text-xs font-semibold shadow-sm">Lihat</button>
                        </td>
                    </tr>

                    <!-- Baris 3 (Draf) -->
                    <tr class="hover:bg-stone-50">
                        <td class="py-4 px-4 font-bold text-red-700">[Tahun]</td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-stone-900">[Nama acara / kolaborasi]</div>
                            <div class="text-xs text-stone-500">[Lokasi / penyelenggara]</div>
                        </td>
                        <td class="py-4 px-4 text-stone-700">[Kategori]</td>
                        <td class="py-4 px-4 text-stone-700">[n] foto</td>
                        <td class="py-4 px-4">
                            <span class="bg-amber-600 text-white text-xs font-bold px-2.5 py-1 rounded">DRAF</span>
                        </td>
                        <td class="py-4 px-4 text-center space-x-1">
                            <button class="bg-white border border-stone-400 hover:bg-stone-100 text-stone-800 px-3 py-1 rounded text-xs font-semibold shadow-sm">Edit</button>
                            <button class="bg-white border border-stone-400 hover:bg-stone-100 text-stone-800 px-3 py-1 rounded text-xs font-semibold shadow-sm">Pratinjau</button>
                        </td>
                    </tr>

                    <!-- Baris 4 -->
                    <tr class="hover:bg-stone-50">
                        <td class="py-4 px-4 font-bold text-red-700">[Tahun]</td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-stone-900">[Nama acara / kolaborasi]</div>
                            <div class="text-xs text-stone-500">[Lokasi / penyelenggara]</div>
                        </td>
                        <td class="py-4 px-4 text-stone-700">[Kategori]</td>
                        <td class="py-4 px-4 text-stone-700">[n] foto</td>
                        <td class="py-4 px-4">
                            <span class="bg-emerald-700 text-white text-xs font-bold px-2.5 py-1 rounded">TERBIT</span>
                        </td>
                        <td class="py-4 px-4 text-center space-x-1">
                            <button class="bg-white border border-stone-400 hover:bg-stone-100 text-stone-800 px-3 py-1 rounded text-xs font-semibold shadow-sm">Edit</button>
                            <button class="bg-white border border-stone-400 hover:bg-stone-100 text-stone-800 px-3 py-1 rounded text-xs font-semibold shadow-sm">Lihat</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Paginasi -->
        <div class="flex justify-between items-center text-sm text-stone-700">
            <span>Menampilkan [1-4] dari [n] acara</span>
            <div class="space-x-2">
                <button class="bg-[#3a1d1d] hover:bg-[#4a2727] text-amber-100 px-3 py-1.5 rounded font-semibold text-xs transition">← Sebelumnya</button>
                <button class="bg-[#3a1d1d] hover:bg-[#4a2727] text-amber-100 px-3 py-1.5 rounded font-semibold text-xs transition">Berikutnya →</button>
            </div>
        </div>
    </main>

</body>
</html>