<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sanggar Seni Cakra Aji</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Shadow bergaya neubrutalism sesuai desain */
        .box-shadow-custom {
            box-shadow: 4px 4px 0px #000000;
        }
        .box-shadow-red {
            box-shadow: 4px 4px 0px #8B0000;
        }
    </style>
</head>
<body class="bg-[#FAF8D4] text-[#2C1810] font-sans antialiased">

    <div class="flex min-h-screen">
        
        <!-- SIDEBAR -->
        <aside class="w-64 bg-[#2D1500] text-[#F3E5AB] flex flex-col justify-between p-6 shrink-0">
            <div>
                <!-- Logo Sanggar -->
                <div class="flex flex-col items-center mb-8 text-center">
                    <div class="w-20 h-20 border-2 border-[#F3E5AB] rounded-full flex items-center justify-center p-2 mb-2">
                        <!-- Ganti dengan <img src="..." /> logo asli -->
                        <span class="text-xs text-center leading-tight">Sanggar Seni<br><strong class="text-sm">Cakra Aji</strong><br><small>Est 2020</small></span>
                    </div>
                    <span class="text-xs uppercase tracking-widest text-amber-200 mt-2 font-bold">Panel Admin</span>
                </div>

                <!-- Navigasi Menu -->
                <nav class="space-y-1">
                    <a href="#" class="block px-4 py-2.5 rounded bg-[#F5C767] text-[#2D1500] font-bold shadow">Dashboard</a>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-[#3D1E00] transition">Pendaftar Siswa</a>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-[#3D1E00] transition">Booking Acara</a>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-[#3D1E00] transition">Beranda & Tentang Kami</a>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-[#3D1E00] transition">Program & Kegiatan</a>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-[#3D1E00] transition">Galeri & Dokumentasi</a>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-[#3D1E00] transition">Pengaturan WhatsApp</a>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-[#3D1E00] transition">Contact Person</a>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-[#3D1E00] transition">Pengaturan Language Switcher</a>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-[#3D1E00] transition">Pengaturan Daftar Nama Siswa</a>
                    <a href="#" class="block px-4 py-2.5 rounded hover:bg-[#3D1E00] transition">Pengaturan & Akun</a>
                </nav>
            </div>

            <!-- Footer Sidebar -->
            <div class="pt-6 border-t border-amber-900/50 space-y-2 text-sm">
                <a href="#" class="block hover:underline">Lihat website ↗</a>
                <a href="#" class="block hover:underline text-red-300">Keluar</a>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <main class="flex-1 p-8 lg:p-12 overflow-y-auto">
            
            <!-- Header Top Bar -->
            <div class="flex justify-between items-start pb-4 border-b-2 border-[#2C1810]">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-red-700">Dashboard</span>
                    <h1 class="text-4xl font-serif font-bold text-[#2C1810] mt-1">Halo, [Nama admin]</h1>
                </div>
                <!-- Profile Badge -->
                <div class="flex items-center space-x-2 border-2 border-[#2C1810] rounded-full px-4 py-1.5 bg-white box-shadow-custom">
                    <div class="w-7 h-7 bg-[#2C1810] text-white rounded-full flex items-center justify-center font-bold text-xs">A</div>
                    <span class="font-bold text-sm">[Nama admin]</span>
                </div>
            </div>

            <!-- Teks Sambutan -->
            <p class="mt-4 text-sm text-[#3D2B1F]">
                Selamat datang di panel admin. Dari sini kamu bisa melihat pendaftar dan booking yang masuk, serta mengubah isi website. Mulai dari kotak <strong class="font-bold">Aksi cepat</strong> di bawah.
            </p>

            <!-- STATISTIK KOTAK (CARDS) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <!-- Card 1 -->
                <div class="bg-white border-2 border-[#2C1810] p-5 box-shadow-red relative">
                    <div class="h-1 bg-red-700 absolute bottom-0 left-0 right-0"></div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#2C1810]">Program Aktif</span>
                    <h2 class="text-4xl font-serif font-bold my-1">[00]</h2>
                    <p class="text-xs text-gray-600">tampil di halaman Program</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white border-2 border-[#2C1810] p-5 box-shadow-custom">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#2C1810]">Foto Dokumentasi</span>
                    <h2 class="text-4xl font-serif font-bold my-1">[000]</h2>
                    <p class="text-xs text-gray-600">terunggah</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white border-2 border-[#2C1810] p-5 box-shadow-custom">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#2C1810]">Draf</span>
                    <h2 class="text-4xl font-serif font-bold my-1">[00]</h2>
                    <p class="text-xs text-gray-600">belum diterbitkan</p>
                </div>
            </div>

            <!-- SEKSI AKSI CEPAT -->
            <h2 class="text-2xl font-serif font-bold mt-10 mb-4">Aksi cepat</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="#" class="block bg-[#FAF3B0] border-2 border-[#2C1810] p-4 hover:bg-[#F5EB96] transition box-shadow-custom">
                    <h3 class="font-bold text-sm">Lihat pendaftar siswa baru</h3>
                    <p class="text-xs text-gray-700 mt-1">Cek siapa yang baru mendaftar jadi murid</p>
                </a>
                <a href="#" class="block bg-[#FAF3B0] border-2 border-[#2C1810] p-4 hover:bg-[#F5EB96] transition box-shadow-custom">
                    <h3 class="font-bold text-sm">Lihat booking acara baru</h3>
                    <p class="text-xs text-gray-700 mt-1">Cek permintaan pentas atau pengisian acara</p>
                </a>
                <a href="#" class="block bg-[#FAF3B0] border-2 border-[#2C1810] p-4 hover:bg-[#F5EB96] transition box-shadow-custom">
                    <h3 class="font-bold text-sm">+ Tambah dokumentasi acara</h3>
                    <p class="text-xs text-gray-700 mt-1">Tulis cerita dan unggah foto acara baru</p>
                </a>
                <a href="#" class="block bg-[#FAF3B0] border-2 border-[#2C1810] p-4 hover:bg-[#F5EB96] transition box-shadow-custom">
                    <h3 class="font-bold text-sm">Unggah foto galeri</h3>
                    <p class="text-xs text-gray-700 mt-1">Tambah foto ke halaman Galeri</p>
                </a>
                <a href="#" class="block bg-[#FAF3B0] border-2 border-[#2C1810] p-4 hover:bg-[#F5EB96] transition box-shadow-custom">
                    <h3 class="font-bold text-sm">Ubah teks Beranda</h3>
                    <p class="text-xs text-gray-700 mt-1">Edit tulisan di halaman depan website</p>
                </a>
                <a href="#" class="block bg-[#FAF3B0] border-2 border-[#2C1810] p-4 hover:bg-[#F5EB96] transition box-shadow-custom">
                    <h3 class="font-bold text-sm">Perbarui jadwal latihan</h3>
                    <p class="text-xs text-gray-700 mt-1">Ubah hari dan jam latihan</p>
                </a>
            </div>

            <!-- SEKSI BOTTOM (PENDAFTARAN & AKTIVITAS TERAKHIR) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-10">
                
                <!-- Pendaftaran & Booking Masuk (2 Kolom) -->
                <div class="lg:col-span-2">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-serif font-bold">Pendaftaran & booking masuk</h2>
                        <a href="#" class="text-sm font-bold underline hover:text-red-700">Atur pesan WhatsApp →</a>
                    </div>
                    
                    <div class="bg-white border-2 border-[#2C1810] p-6 box-shadow-custom">
                        <ol class="list-decimal list-inside space-y-2 text-sm text-gray-800 mb-6">
                            <li>Pengunjung mengisi formulir <strong class="font-bold">Daftar Murid Baru</strong> atau <strong class="font-bold">Booking Acara</strong> di website.</li>
                            <li>Datanya muncul di menu <strong class="font-bold">Pendaftar Siswa</strong> atau <strong class="font-bold">Booking Acara</strong> di panel ini. Pada versi “langsung ke WhatsApp”, pesannya masuk ke WhatsApp admin.</li>
                            <li>Admin menghubungi pengunjung lewat WhatsApp, lalu mengubah status datanya.</li>
                        </ol>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <a href="#" class="block bg-[#FAF3B0] border-2 border-[#2C1810] p-4 hover:bg-[#F5EB96] transition box-shadow-custom">
                                <span class="text-[10px] font-bold tracking-wider text-red-700 uppercase">Pendaftar Siswa Baru</span>
                                <h4 class="font-bold text-base mt-1">[00] belum dihubungi →</h4>
                            </a>
                            <a href="#" class="block bg-[#FAF3B0] border-2 border-[#2C1810] p-4 hover:bg-[#F5EB96] transition box-shadow-custom">
                                <span class="text-[10px] font-bold tracking-wider text-red-700 uppercase">Booking Acara Baru</span>
                                <h4 class="font-bold text-base mt-1">[00] belum dihubungi →</h4>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Aktivitas Terakhir (1 Kolom) -->
                <div>
                    <h2 class="text-2xl font-serif font-bold mb-4">Aktivitas terakhir</h2>
                    <div class="bg-white border-2 border-[#2C1810] divide-y-2 divide-[#2C1810] box-shadow-custom">
                        <div class="p-4">
                            <p class="text-sm"><strong class="font-bold">[Admin]</strong> menerbitkan dokumentasi <strong class="font-bold">[Nama acara]</strong></p>
                            <span class="text-xs text-gray-500">[Waktu]</span>
                        </div>
                        <div class="p-4">
                            <p class="text-sm"><strong class="font-bold">[Admin]</strong> mengubah jadwal latihan</p>
                            <span class="text-xs text-gray-500">[Waktu]</span>
                        </div>
                        <div class="p-4">
                            <p class="text-sm"><strong class="font-bold">[Admin]</strong> mengubah pesan WhatsApp booking</p>
                            <span class="text-xs text-gray-500">[Waktu]</span>
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>

</body>
</html>