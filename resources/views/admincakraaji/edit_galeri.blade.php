<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah / Edit Dokumentasi - Panel Admin Cakra Aji</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #fefce8; /* Warna latar belakang kuning hangat */
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
        <!-- Navigasi Kembali & Header Aksi Atas -->
        <div class="mb-6">
            <a href="#" class="text-xs font-bold text-amber-800 hover:underline inline-flex items-center gap-1 mb-3">
                ‹ Kembali ke daftar acara
            </a>
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-1">Tambah / Edit Dokumentasi</p>
                    <h1 class="text-3xl font-bold text-stone-900">[Nama acara / kolaborasi]</h1>
                </div>
                <!-- Tombol Aksi Kanan Atas -->
                <div class="flex items-center gap-2">
                    <button class="bg-white border border-stone-400 hover:bg-stone-100 text-stone-900 px-4 py-2 rounded-md font-semibold text-sm shadow-sm transition">
                        Pratinjau
                    </button>
                    <button class="bg-amber-400 hover:bg-amber-500 text-stone-900 px-4 py-2 rounded-md font-semibold text-sm shadow-sm transition">
                        Simpan draf
                    </button>
                    <button class="bg-[#3a1d1d] hover:bg-[#4a2727] text-amber-100 px-5 py-2 rounded-md font-semibold text-sm shadow transition">
                        Terbitkan
                    </button>
                </div>
            </div>
        </div>

        <!-- Layout Utama: Grid 2 Kolom (Kiri: Form Utama, Kanan: Sidebar Aksi/Status/Foto Sampul) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- KOLOM KIRI (Lebar 2) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Box 1: Informasi Acara -->
                <div class="bg-white p-6 rounded-lg shadow border border-stone-200">
                    <h2 class="text-xl font-bold text-stone-900 mb-4 pb-2 border-b border-stone-100">Informasi acara</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Nama acara / kolaborasi</label>
                            <input type="text" placeholder="Nama acara" class="w-full bg-[#fefce8] border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-stone-700 mb-1">Tahun</label>
                                <input type="text" placeholder="[Tahun]" class="w-full bg-[#fefce8] border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-stone-700 mb-1">Tanggal pelaksanaan</label>
                                <input type="text" placeholder="dd/mm/yyyy" class="w-full bg-[#fefce8] border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Kategori</label>
                            <select class="w-full bg-[#fefce8] border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">
                                <option>Pentas</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-stone-700 mb-1">Lokasi</label>
                                <input type="text" placeholder="Tempat & kota" class="w-full bg-[#fefce8] border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-stone-700 mb-1">Penyelenggara / mitra</label>
                                <input type="text" placeholder="Nama penyelenggara" class="w-full bg-[#fefce8] border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Peran Cakra Aji</label>
                            <input type="text" placeholder="Mis. pengisi acara / kolaborator" class="w-full bg-[#fefce8] border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">
                        </div>
                    </div>
                </div>

                <!-- Box 2: Cerita Acara -->
                <div class="bg-white p-6 rounded-lg shadow border border-stone-200">
                    <h2 class="text-xl font-bold text-stone-900 mb-4 pb-2 border-b border-stone-100">Cerita acara</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Deskripsi</label>
                            <textarea rows="4" placeholder="Ceritakan acaranya: latar, apa yang ditampilkan, dan hasilnya." class="w-full bg-[#fefce8] border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Kutipan / kesan (opsional)</label>
                            <input type="text" placeholder="Kutipan dari penonton atau mitra" class="w-full bg-[#fefce8] border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">
                        </div>
                    </div>
                </div>

            </div>

            <!-- KOLOM KANAN (Lebar 1) -->
            <div class="space-y-8">
                
                <!-- Box 3: Status & Tampilan -->
                <div class="bg-white p-6 rounded-lg shadow border border-stone-200">
                    <h2 class="text-xl font-bold text-stone-900 mb-4 pb-2 border-b border-stone-100">Status &amp; tampilan</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Status</label>
                            <select class="w-full bg-[#fefce8] border border-stone-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-600">
                                <option>Draf</option>
                                <option>Terbit</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" id="tampil_galeri" class="rounded border-stone-300 text-amber-600 focus:ring-amber-500">
                            <label for="tampil_galeri" class="text-xs text-stone-800">Tampilkan di daftar Galeri &amp; Portofolio</label>
                        </div>

                        <p class="text-xs text-stone-500 pt-2 border-t border-stone-100">
                            Terakhir disimpan: [waktu] oleh [Nama admin]
                        </p>
                    </div>
                </div>

                <!-- Box 4: Foto Sampul -->
                <div class="bg-white p-6 rounded-lg shadow border border-stone-200">
                    <h2 class="text-xl font-bold text-stone-900 mb-4 pb-2 border-b border-stone-100">Foto sampul</h2>
                    
                    <div class="space-y-4">
                        <div class="w-full h-40 bg-stone-100 border border-dashed border-stone-300 rounded flex items-center justify-center text-xs text-stone-500 text-center p-4">
                            [Pratinjau foto sampul]
                        </div>
                        <button class="w-full bg-amber-400 hover:bg-amber-500 text-stone-900 py-2 rounded font-semibold text-sm shadow-sm transition">
                            Ganti foto sampul
                        </button>
                        <p class="text-[11px] text-stone-500 text-center">
                            Disarankan rasio 16:9, format JPG atau PNG.
                        </p>
                    </div>
                </div>

                <!-- Box 5: Zona Berbahaya -->
                <div class="bg-white p-6 rounded-lg shadow border border-red-200">
                    <h2 class="text-xl font-bold text-red-700 mb-2 pb-2 border-b border-stone-100">Zona berbahaya</h2>
                    <p class="text-xs text-stone-600 mb-4">
                        Menghapus acara juga menghapus semua foto dokumentasinya dari galeri.
                    </p>
                    <button class="w-full bg-red-700 hover:bg-red-800 text-white py-2 rounded font-semibold text-sm transition shadow-sm">
                        Hapus acara
                    </button>
                </div>

            </div>

        </div>

        <!-- SECTION BAWAH: Dokumentasi Foto (Full Lebar) -->
        <div class="mt-8 bg-[#85905d] p-6 rounded-lg shadow border border-stone-300">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                <div>
                    <h2 class="text-xl font-bold text-white mb-1">Dokumentasi foto</h2>
                    <p class="text-xs text-stone-100">
                        Foto-foto ini tampil di halaman dokumentasi acara. Seret untuk mengatur urutan.
                    </p>
                </div>
                <button class="mt-3 md:mt-0 bg-[#3a1d1d] hover:bg-[#4a2727] text-amber-100 px-4 py-2 rounded-md font-semibold text-sm shadow transition self-start">
                    + Unggah foto
                </button>
            </div>

            <!-- Area Dropzone / Drag & Drop -->
            <div class="border-2 border-dashed border-stone-300/70 rounded-lg p-6 text-center text-white bg-[#7d8755] mb-6">
                <p class="text-sm font-semibold mb-1">Seret &amp; lepas foto di sini</p>
                <p class="text-xs text-stone-200">atau klik “Unggah foto” · JPG / PNG · [batas ukuran] per foto</p>
            </div>

            <!-- Grid Kartu Foto Dokumentasi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                
                <!-- Foto Card 1 (Sampul) -->
                <div class="bg-white p-3 rounded shadow relative flex flex-col justify-between">
                    <div>
                        <div class="w-full h-28 bg-stone-200 rounded mb-2 relative flex items-center justify-center text-xs text-stone-400">
                            <span class="absolute top-1.5 left-1.5 bg-stone-900 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">1</span>
                            <span class="absolute top-1.5 right-1.5 bg-amber-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">SAMPUL</span>
                        </div>
                        <label class="block text-[11px] font-bold text-stone-700 mb-1">Keterangan foto</label>
                        <input type="text" value="Keterangan singkat" class="w-full bg-[#fefce8] border border-stone-300 rounded px-2 py-1 text-xs mb-2">
                    </div>
                    <button class="text-xs text-red-600 hover:text-red-800 font-semibold text-left">Hapus foto</button>
                </div>

                <!-- Foto Card 2 -->
                <div class="bg-white p-3 rounded shadow relative flex flex-col justify-between">
                    <div>
                        <div class="w-full h-28 bg-stone-200 rounded mb-2 relative flex items-center justify-center text-xs text-stone-400">
                            <span class="absolute top-1.5 left-1.5 bg-stone-900 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">2</span>
                        </div>
                        <label class="block text-[11px] font-bold text-stone-700 mb-1">Keterangan foto</label>
                        <input type="text" value="Keterangan singkat" class="w-full bg-[#fefce8] border border-stone-300 rounded px-2 py-1 text-xs mb-2">
                    </div>
                    <button class="text-xs text-red-600 hover:text-red-800 font-semibold text-left">Hapus foto</button>
                </div>

                <!-- Foto Card 3 -->
                <div class="bg-white p-3 rounded shadow relative flex flex-col justify-between">
                    <div>
                        <div class="w-full h-28 bg-stone-200 rounded mb-2 relative flex items-center justify-center text-xs text-stone-400">
                            <span class="absolute top-1.5 left-1.5 bg-stone-900 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">3</span>
                        </div>
                        <label class="block text-[11px] font-bold text-stone-700 mb-1">Keterangan foto</label>
                        <input type="text" value="Keterangan singkat" class="w-full bg-[#fefce8] border border-stone-300 rounded px-2 py-1 text-xs mb-2">
                    </div>
                    <button class="text-xs text-red-600 hover:text-red-800 font-semibold text-left">Hapus foto</button>
                </div>

                <!-- Foto Card 4 -->
                <div class="bg-white p-3 rounded shadow relative flex flex-col justify-between">
                    <div>
                        <div class="w-full h-28 bg-stone-200 rounded mb-2 relative flex items-center justify-center text-xs text-stone-400">
                            <span class="absolute top-1.5 left-1.5 bg-stone-900 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">4</span>
                        </div>
                        <label class="block text-[11px] font-bold text-stone-700 mb-1">Keterangan foto</label>
                        <input type="text" value="Keterangan singkat" class="w-full bg-[#fefce8] border border-stone-300 rounded px-2 py-1 text-xs mb-2">
                    </div>
                    <button class="text-xs text-red-600 hover:text-red-800 font-semibold text-left">Hapus foto</button>
                </div>

            </div>
        </div>
    </main>

</body>
</html>