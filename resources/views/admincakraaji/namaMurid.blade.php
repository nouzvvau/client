<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nama Siswa - Panel Admin Sanggar Seni Cakra Aji</title>
    <!-- Menggunakan Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk interaksi buka/tutup sidebar mobile -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#FFF9CC] min-h-screen font-sans text-zinc-900 flex flex-col lg:flex-row" x-data="{ sidebarOpen: false }">

    <!-- TOP BAR KHUSUS MOBILE (Tombol Hamburger di Kanan) -->
    <div class="lg:hidden bg-[#3B2219] text-white px-6 py-4 flex items-center justify-between z-30 shadow-md">
        <!-- Logo Kiri -->
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 border-2 border-[#D4A373] rounded-full flex items-center justify-center shrink-0">
                <span class="text-[9px] text-[#D4A373]">Logo</span>
            </div>
            <div>
                <h1 class="text-xs font-bold tracking-wide">Sanggar Seni</h1>
                <span class="text-[10px] text-[#D4A373]">Cakra Aji</span>
            </div>
        </div>

        <!-- Tombol Hamburger di Kanan -->
        <button @click="sidebarOpen = !sidebarOpen" class="text-white focus:outline-none p-1 rounded hover:bg-[#4d2f23] transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- OVERLAY GELAP SAAT SIDEBAR MOBILE TERBUKA -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden transition-opacity"></div>

    <!-- SIDEBAR KANAN (Geser dari Kanan di Mobile, Statis di Desktop) -->
    <aside :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'" class="fixed lg:translate-x-0 top-0 right-0 h-full w-64 bg-[#3B2219] text-white flex flex-col justify-between shrink-0 z-50 transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none">
        
        <!-- Bagian Atas Sidebar -->
        <div>
            <!-- Header Logo (Desktop) -->
            <div class="p-6 hidden lg:flex items-center space-x-3 border-b border-[#4d2f23]">
                <div class="w-10 h-10 border-2 border-[#D4A373] rounded-full flex items-center justify-center shrink-0">
                    <span class="text-[10px] text-[#D4A373]">Logo</span>
                </div>
                <div>
                    <h1 class="text-sm font-bold tracking-wide">Sanggar Seni</h1>
                    <span class="text-xs text-[#D4A373]">Cakra Aji <span class="text-[9px] text-gray-400">Est.2020</span></span>
                </div>
            </div>

            <!-- Tombol Tutup Sidebar (Mobile) -->
            <div class="lg:hidden p-4 flex justify-between items-center border-b border-[#4d2f23]">
                <span class="text-xs uppercase tracking-widest text-[#D4A373] font-bold">Menu Navigasi</span>
                <button @click="sidebarOpen = false" class="text-gray-300 hover:text-white text-lg font-bold px-2">✕</button>
            </div>

            <!-- Menu Navigasi -->
            <div class="px-4 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider hidden lg:block">Panel Admin</div>
            <nav class="space-y-1 px-3 text-sm py-4 lg:py-0 overflow-y-auto max-h-[calc(100vh-180px)]">
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Dashboard</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Pendaftar Siswa</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Booking Acara</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Beranda & Tentang Kami</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Program & Kegiatan</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Galeri & Dokumentasi</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Pengaturan WhatsApp</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Contact Person</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Pengaturan Language Switcher</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded bg-[#E9C46A] text-zinc-900 font-medium">Pengaturan Daftar Nama Siswa</a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Pengaturan & Akun</a>
            </nav>
        </div>

        <!-- Tombol Bawah Sidebar -->
        <div class="p-4 border-t border-[#4d2f23] space-y-2 text-sm bg-[#3B2219]">
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
    <main class="flex-1 p-6 lg:p-12 overflow-y-auto lg:ml-64">
        
        <!-- Header Halaman -->
        <div class="mb-8">
            <span class="text-xs font-bold text-[#A34723] uppercase tracking-widest">Pengaturan Daftar Nama Siswa</span>
            <h2 class="text-2xl lg:text-3xl font-extrabold text-zinc-900 mt-1">DAFTAR NAMA SISWA</h2>
        </div>

        <div class="w-full h-px bg-zinc-300 mb-8"></div>

        <!-- Deskripsi Singkat -->
        <p class="text-sm text-zinc-700 mb-8 max-w-3xl leading-relaxed">
            Kelola nama murid yang tampil di halaman <strong>Murid Sanggar</strong> pada website. Tambah murid baru, ubah nama atau kelas, atau hapus murid yang sudah tidak aktif.
        </p>

        <!-- Kotak Form Tambah Murid Baru -->
        <div class="bg-white border-2 border-[#3B2219] p-6 rounded-sm shadow-[6px_6px_0px_0px_#3B2219] mb-8">
            <h3 class="text-base font-bold text-zinc-900 mb-4">Tambah Murid Baru</h3>
            
            <form action="#" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">
                @csrf
                <!-- Input Nama Murid -->
                <div class="lg:col-span-6">
                    <label class="block text-xs font-bold text-zinc-800 mb-1">Nama murid</label>
                    <input type="text" name="nama_murid" placeholder="Contoh: Aulia Eky Ridha Aprilia" class="w-full bg-[#FFF9CC]/50 px-4 py-2.5 border border-zinc-400 rounded-sm text-sm focus:outline-none focus:border-[#3B2219]">
                </div>
                
                <!-- Pilih Kelas -->
                <div class="lg:col-span-4">
                    <label class="block text-xs font-bold text-zinc-800 mb-1">Kelas</label>
                    <select name="kelas" class="w-full bg-[#FFF9CC]/50 px-4 py-2.5 border border-zinc-400 rounded-sm text-sm focus:outline-none focus:border-[#3B2219]">
                        <option value="Kelas Dasar Tingkat I (A)">Kelas Dasar Tingkat I (A)</option>
                        <option value="Kelas Dasar Tingkat I (B)">Kelas Dasar Tingkat I (B)</option>
                        <option value="Kelas Dasar Tingkat II (A)">Kelas Dasar Tingkat II (A)</option>
                        <option value="Kelas Dasar Tingkat II (B)">Kelas Dasar Tingkat II (B)</option>
                        <option value="Kelas Dasar Tingkat II (C)">Kelas Dasar Tingkat II (C)</option>
                        <option value="Karawitan Madya Tingkat I (Madya 1)">Karawitan Madya Tingkat I (Madya 1)</option>
                        <option value="Karawitan Madya Tingkat II (Madya 2)">Karawitan Madya Tingkat II (Madya 2)</option>
                        <option value="Karawitan Mahir">Karawitan Mahir</option>
                    </select>
                </div>

                <!-- Tombol Submit -->
                <div class="lg:col-span-2">
                    <button type="submit" class="w-full bg-[#3B2219] hover:bg-[#2b1812] text-white text-xs font-bold py-3 px-4 rounded-sm transition shadow-sm">
                        Tambah Murid
                    </button>
                </div>
            </form>
        </div>

        <!-- Filter Pencarian & Kelas -->
        <form method="GET" action="" class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-xs font-bold text-zinc-800 mb-1">Cari nama murid</label>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Ketik nama murid" class="w-full bg-white px-4 py-2.5 border border-zinc-400 rounded-sm text-sm focus:outline-none focus:border-[#3B2219]">
            </div>
            <div>
                <label class="block text-xs font-bold text-zinc-800 mb-1">Tampilkan kelas</label>
                <select name="kelas" class="w-full bg-white px-4 py-2.5 border border-zinc-400 rounded-sm text-sm focus:outline-none focus:border-[#3B2219]">
                    <option value="">Semua kelas</option>
                    <option value="kelas-dasar-1a">Kelas Dasar Tingkat I (A)</option>
                    <option value="kelas-dasar-1b">Kelas Dasar Tingkat I (B)</option>
                    <option value="kelas-dasar-2a">Kelas Dasar Tingkat II (A)</option>
                </select>
            </div>
        </form>

        <!-- Daftar List Murid (Card Style) -->
        <div class="space-y-4">
            
            <!-- Item Murid 1 -->
            <div class="bg-white border-2 border-[#3B2219] p-4 rounded-sm shadow-[4px_4px_0px_0px_#3B2219] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-[#E9C46A] border border-[#3B2219] rounded-full flex items-center justify-center font-bold text-zinc-900 shrink-0">
                        A
                    </div>
                    <div>
                        <div class="font-bold text-zinc-900">Alfian Fadzli Nur Arifin</div>
                        <div class="text-xs text-zinc-500">Kelas Dasar Tingkat I (A)</div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 w-full sm:w-auto justify-end">
                    <a href="#" class="border border-[#3B2219] bg-[#E9C46A] hover:bg-[#d8b359] text-zinc-900 text-xs font-bold py-1.5 px-4 rounded-sm transition">
                        Ubah
                    </a>
                    <a href="#" class="border border-[#A34723] bg-white hover:bg-red-50 text-[#A34723] text-xs font-bold py-1.5 px-4 rounded-sm transition">
                        Hapus
                    </a>
                </div>
            </div>

            <!-- Item Murid 2 -->
            <div class="bg-white border-2 border-[#3B2219] p-4 rounded-sm shadow-[4px_4px_0px_0px_#3B2219] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-[#E9C46A] border border-[#3B2219] rounded-full flex items-center justify-center font-bold text-zinc-900 shrink-0">
                        A
                    </div>
                    <div>
                        <div class="font-bold text-zinc-900">Aulia Eky Ridha Aprilia</div>
                        <div class="text-xs text-zinc-500">Kelas Dasar Tingkat I (A)</div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 w-full sm:w-auto justify-end">
                    <a href="#" class="border border-[#3B2219] bg-[#E9C46A] hover:bg-[#d8b359] text-zinc-900 text-xs font-bold py-1.5 px-4 rounded-sm transition">
                        Ubah
                    </a>
                    <a href="#" class="border border-[#A34723] bg-white hover:bg-red-50 text-[#A34723] text-xs font-bold py-1.5 px-4 rounded-sm transition">
                        Hapus
                    </a>
                </div>
            </div>

            <!-- Item Murid 3 -->
            <div class="bg-white border-2 border-[#3B2219] p-4 rounded-sm shadow-[4px_4px_0px_0px_#3B2219] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-[#E9C46A] border border-[#3B2219] rounded-full flex items-center justify-center font-bold text-zinc-900 shrink-0">
                        A
                    </div>
                    <div>
                        <div class="font-bold text-zinc-900">Aurora Dinda Azzahra</div>
                        <div class="text-xs text-zinc-500">Kelas Dasar Tingkat I (A)</div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 w-full sm:w-auto justify-end">
                    <a href="#" class="border border-[#3B2219] bg-[#E9C46A] hover:bg-[#d8b359] text-zinc-900 text-xs font-bold py-1.5 px-4 rounded-sm transition">
                        Ubah
                    </a>
                    <a href="#" class="border border-[#A34723] bg-white hover:bg-red-50 text-[#A34723] text-xs font-bold py-1.5 px-4 rounded-sm transition">
                        Hapus
                    </a>
                </div>
            </div>

            <!-- Item Murid 4 -->
            <div class="bg-white border-2 border-[#3B2219] p-4 rounded-sm shadow-[4px_4px_0px_0px_#3B2219] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-[#E9C46A] border border-[#3B2219] rounded-full flex items-center justify-center font-bold text-zinc-900 shrink-0">
                        V
                    </div>
                    <div>
                        <div class="font-bold text-zinc-900">Vania Thalitha Kirana</div>
                        <div class="text-xs text-zinc-500">Kelas Dasar Tingkat I (B)</div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 w-full sm:w-auto justify-end">
                    <a href="#" class="border border-[#3B2219] bg-[#E9C46A] hover:bg-[#d8b359] text-zinc-900 text-xs font-bold py-1.5 px-4 rounded-sm transition">
                        Ubah
                    </a>
                    <a href="#" class="border border-[#A34723] bg-white hover:bg-red-50 text-[#A34723] text-xs font-bold py-1.5 px-4 rounded-sm transition">
                        Hapus
                    </a>
                </div>
            </div>

        </div>

    </main>

</body>
</html>