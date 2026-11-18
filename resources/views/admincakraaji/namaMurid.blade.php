<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Daftar Nama Siswa - Panel Admin Sanggar Seni Cakra Aji</title>
    <!-- Menggunakan Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FFF9CC] min-h-screen font-sans text-zinc-900">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#3B2219] text-white flex flex-col justify-between fixed inset-y-0 left-0">
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
                <a href="{{ route('admin.pendaftar') }}" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Pendaftar Siswa</a>
                <a href="{{ route('admin.booking') }}" class="flex items-center px-3 py-2.5 rounded text-gray-300 hover:bg-[#4d2f23] hover:text-white transition">Booking Acara</a>
                <a href="{{ route('admin.nama-murid') }}" class="flex items-center px-3 py-2.5 rounded bg-[#E9C46A] text-zinc-900 font-medium">Pengaturan Daftar Nama Siswa</a>
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

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-sm mb-8 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-sm mb-8 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Kotak Form Tambah Murid Baru -->
        <div class="bg-white border-2 border-[#3B2219] p-6 rounded-sm shadow-[6px_6px_0px_0px_#3B2219] mb-8">
            <h3 class="text-base font-bold text-zinc-900 mb-4">Tambah Murid Baru</h3>

            <form action="{{ route('admin.nama-murid.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">
                @csrf
                <!-- Input Nama Murid -->
                <div class="lg:col-span-6">
                    <label class="block text-xs font-bold text-zinc-800 mb-1">Nama murid</label>
                    <input type="text" name="nama_murid" value="{{ old('nama_murid') }}" placeholder="Contoh: Aulia Eky Ridha Aprilia" required class="w-full bg-[#FFF9CC]/50 px-4 py-2.5 border border-zinc-400 rounded-sm text-sm focus:outline-none focus:border-[#3B2219]">
                </div>

                <!-- Pilih Kelas / Program -->
                <div class="lg:col-span-4">
                    <label class="block text-xs font-bold text-zinc-800 mb-1">Kelas</label>
                    <select name="program_id" class="w-full bg-[#FFF9CC]/50 px-4 py-2.5 border border-zinc-400 rounded-sm text-sm focus:outline-none focus:border-[#3B2219]">
                        <option value="">Belum mengikuti program</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                        @endforeach
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

        <!-- Filter Pencarian -->
        <form method="GET" action="{{ route('admin.nama-murid') }}" class="grid grid-cols-1 gap-6 mb-8">
            <div>
                <label class="block text-xs font-bold text-zinc-800 mb-1">Cari nama murid</label>
                <div class="flex gap-2">
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Ketik nama murid" class="w-full max-w-md bg-white px-4 py-2.5 border border-zinc-400 rounded-sm text-sm focus:outline-none focus:border-[#3B2219]">
                    <button type="submit" class="bg-[#3B2219] hover:bg-[#2b1812] text-white text-xs font-bold py-2.5 px-6 rounded-sm transition">Cari</button>
                </div>
            </div>
        </form>

        <!-- Daftar List Murid (Card Style) -->
        <div class="space-y-4">
            @forelse ($murids as $murid)
                <div class="bg-white border-2 border-[#3B2219] p-4 rounded-sm shadow-[4px_4px_0px_0px_#3B2219] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-[#E9C46A] border border-[#3B2219] rounded-full flex items-center justify-center font-bold text-zinc-900 shrink-0">
                            {{ strtoupper(mb_substr($murid->full_name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-bold text-zinc-900">{{ $murid->full_name }}</div>
                            <div class="text-xs text-zinc-500">
                                @forelse ($murid->programs as $program)
                                    {{ $program->name }}{{ ! $loop->last ? ' · ' : '' }}
                                @empty
                                    Belum mengikuti program
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                        <!-- Ubah Nama -->
                        <form action="{{ route('admin.nama-murid.update', $murid) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PUT')
                            <input type="text" name="nama_murid" value="{{ $murid->full_name }}" class="bg-white border border-zinc-400 rounded-sm text-xs px-2 py-1.5 w-40 sm:w-48 focus:outline-none focus:border-[#3B2219]">
                            <button type="submit" class="border border-[#3B2219] bg-[#E9C46A] hover:bg-[#d8b359] text-zinc-900 text-xs font-bold py-1.5 px-4 rounded-sm transition whitespace-nowrap">
                                Ubah
                            </button>
                        </form>
                        <!-- Hapus -->
                        <form action="{{ route('admin.nama-murid.destroy', $murid) }}" method="POST" onsubmit="return confirm('Hapus murid {{ $murid->full_name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="border border-[#A34723] bg-white hover:bg-red-50 text-[#A34723] text-xs font-bold py-1.5 px-4 rounded-sm transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white border-2 border-[#3B2219] p-12 rounded-sm shadow-[4px_4px_0px_0px_#3B2219] text-center">
                    <div class="text-zinc-500 font-semibold">
                        @if (request('cari'))
                            Murid "{{ request('cari') }}" tidak ditemukan.
                        @else
                            Belum ada murid terdaftar.
                        @endif
                    </div>
                    <p class="text-xs text-zinc-400 mt-2">
                        Tambahkan murid lewat formulir "Tambah Murid Baru" di atas.
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Paginasi -->
        @if ($murids->hasPages())
            <div class="mt-8">
                {{ $murids->links() }}
            </div>
        @endif

    </main>

</body>
</html>
