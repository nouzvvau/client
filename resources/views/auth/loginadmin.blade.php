<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin - Sanggar Seni Cakra Aji</title>
    <!-- Menggunakan Tailwind CSS CDN untuk kemudahan styling -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#3B2219] min-h-screen flex items-center justify-center relative overflow-hidden font-sans text-white">

    <!-- Efek Lingkaran/Aksen Abstrak di Background -->
    <div class="absolute -top-16 -right-16 w-64 h-64 bg-[#C49A45] rounded-full opacity-35 blur-2xl"></div>
    <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-[#C49A45] rounded-full opacity-30 blur-2xl"></div>
    <div class="absolute bottom-10 left-12 w-28 h-28 bg-[#D4A373] rounded-full"></div>

    <div class="container mx-auto px-6 lg:px-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center z-10">
        
        <!-- Kolom Kiri: Informasi Sanggar -->
        <div class="space-y-6">
            <!-- Logo / Ilustrasi Sanggar -->
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 border-2 border-[#D4A373] rounded-full flex items-center justify-center">
                    <!-- Ganti dengan tag <img> logo aslimu jika ada -->
                    <span class="text-xs text-center text-[#D4A373]">Logo</span>
                </div>
                <div>
                    <h2 class="text-xs uppercase tracking-widest text-[#D4A373]">Sanggar seni</h2>
                    <h1 class="text-2xl font-bold tracking-wide">Cakra Aji</h1>
                    <span class="text-xs text-gray-300">Est 2020</span>
                </div>
            </div>

            <!-- Teks Deskripsi -->
            <div class="space-y-3">
                <h2 class="text-3xl lg:text-4xl font-bold leading-snug">
                    Ruang kelola<br>website sanggar.
                </h2>
                <p class="text-sm text-gray-300 max-w-md leading-relaxed">
                    Ubah isi halaman, tambah dokumentasi acara, dan baca booking yang masuk, semua dari satu tempat.
                </p>
            </div>
        </div>

        <!-- Kolom Kanan: Kotak Form Login -->
        <div class="flex justify-center lg:justify-end">
            <!-- Efek bayangan kotak kuning di belakang form -->
            <div class="relative w-full max-w-md">
                <div class="absolute inset-0 bg-[#E9C46A] translate-x-3 translate-y-3 rounded-sm"></div>
                
                <!-- Kotak Form Utama -->
                <div class="relative bg-[#FFF9CC] text-zinc-900 p-8 rounded-sm shadow-xl space-y-6">
                    
                    <div>
                        <span class="text-[10px] font-bold tracking-widest text-[#7A5C2A] uppercase">Masuk Admin</span>
                        <h2 class="text-2xl font-bold text-zinc-900 mt-1">Selamat datang kembali</h2>
                    </div>

                    <!-- Menampilkan Error Jika Login Gagal -->
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded text-xs">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.proses') }}" method="POST" class="space-y-4">
                        @csrf
                        <!-- Input Email -->
                        <div>
                            <label class="block text-xs font-semibold text-zinc-700 mb-1">Email admin</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@email.com" required class="w-full px-3 py-2 border border-zinc-300 rounded-sm text-sm focus:outline-none focus:border-[#7A5C2A] bg-white">
                        </div>

                        <!-- Input Password -->
                        <div>
                            <label class="block text-xs font-semibold text-zinc-700 mb-1">Kata sandi</label>
                            <input type="password" name="password" placeholder="Kata sandi" required class="w-full px-3 py-2 border border-zinc-300 rounded-sm text-sm focus:outline-none focus:border-[#7A5C2A] bg-white">
                        </div>

                        <!-- Checkbox & Link Lupa Sandi -->
                        <div class="flex items-center justify-between text-xs">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="remember" class="rounded border-zinc-300 text-[#3B2219] focus:ring-0">
                                <span class="text-zinc-700">Ingat saya</span>
                            </label>
                            <a href="#" class="text-zinc-70Tentu! Berikut adalah kode lengkap untuk halaman `loginadmin.blade.php` yang sudah digabungkan dengan kode backend (tag `@csrf` dan atribut `name` pada input email & password) sehingga bisa langsung kamu *copy* dan *paste* ke dalam file tersebut.

### Kode Lengkap `loginadmin.blade.php`

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin - Sanggar Seni Akra Aji</title>
    <!-- Menggunakan Tailwind CSS CDN untuk kemudahan styling -->
    <script src="[https://cdn.tailwindcss.com](https://cdn.tailwindcss.com)"></script>
</head>
<body class="bg-[#3B2219] min-h-screen flex items-center justify-center relative overflow-hidden font-sans text-white">

    <!-- Efek Lingkaran/Aksen Abstrak di Background -->
    <div class="absolute -top-16 -right-16 w-64 h-64 bg-[#C49A45] rounded-full opacity-35 blur-2xl"></div>
    <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-[#C49A45] rounded-full opacity-30 blur-2xl"></div>
    <div class="absolute bottom-10 left-12 w-28 h-28 bg-[#D4A373] rounded-full"></div>

    <div class="container mx-auto px-6 lg:px-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center z-10">
        
        <!-- Kolom Kiri: Informasi Sanggar -->
        <div class="space-y-6">
            <!-- Logo / Ilustrasi Sanggar -->
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 border-2 border-[#D4A373] rounded-full flex items-center justify-center">
                    <!-- Ganti dengan tag <img> logo aslimu jika ada -->
                    <span class="text-xs text-center text-[#D4A373]">Logo</span>
                </div>
                <div>
                    <h2 class="text-xs uppercase tracking-widest text-[#D4A373]">Sanggar seni</h2>
                    <h1 class="text-2xl font-bold tracking-wide">Akra Aji</h1>
                    <span class="text-xs text-gray-300">Est 2020</span>
                </div>
            </div>

            <!-- Teks Deskripsi -->
            <div class="space-y-3">
                <h2 class="text-3xl lg:text-4xl font-bold leading-snug">
                    Ruang kelola<br>website sanggar.
                </h2>
                <p class="text-sm text-gray-300 max-w-md leading-relaxed">
                    Ubah isi halaman, tambah dokumentasi acara, dan baca booking yang masuk, semua dari satu tempat.
                </p>
            </div>
        </div>

        <!-- Kolom Kanan: Kotak Form Login -->
        <div class="flex justify-center lg:justify-end">
            <!-- Efek bayangan kotak kuning di belakang form -->
            <div class="relative w-full max-w-md">
                <div class="absolute inset-0 bg-[#E9C46A] translate-x-3 translate-y-3 rounded-sm"></div>
                
                <!-- Kotak Form Utama -->
                <div class="relative bg-[#FFF9CC] text-zinc-900 p-8 rounded-sm shadow-xl space-y-6">
                    
                    <div>
                        <span class="text-[10px] font-bold tracking-widest text-[#7A5C2A] uppercase">Masuk Admin</span>
                        <h2 class="text-2xl font-bold text-zinc-900 mt-1">Selamat datang kembali</h2>
                    </div>

                    <!-- Menampilkan pesan error jika login gagal -->
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded text-xs">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.proses') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <!-- Input Email -->
                        <div>
                            <label class="block text-xs font-semibold text-zinc-700 mb-1">Email admin</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@email.com" required class="w-full px-3 py-2 border border-zinc-300 rounded-sm text-sm focus:outline-none focus:border-[#7A5C2A] bg-white">
                        </div>

                        <!-- Input Password -->
                        <div>
                            <label class="block text-xs font-semibold text-zinc-700 mb-1">Kata sandi</label>
                            <input type="password" name="password" placeholder="Kata sandi" required class="w-full px-3 py-2 border border-zinc-300 rounded-sm text-sm focus:outline-none focus:border-[#7A5C2A] bg-white">
                        </div>

                        <!-- Checkbox & Link Lupa Sandi -->
                        <div class="flex items-center justify-between text-xs">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="remember" class="rounded border-zinc-300 text-[#3B2219] focus:ring-0">
                                <span class="text-zinc-700">Ingat saya</span>
                            </label>
                            <a href="#" class="text-zinc-700 hover:underline">Lupa kata sandi?</a>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit" class="w-full py-2.5 bg-[#3B2219] text-white rounded-sm text-sm font-medium hover:bg-[#2b1812] transition">
                            Masuk ke panel
                        </button>

                        <!-- Kembali ke Website -->
                        <div class="text-center pt-2">
                            <a href="{{ url('/') }}" class="text-xs text-zinc-700 hover:underline inline-flex items-center space-x-1">
                                <span>←</span>
                                <span>Kembali ke website</span>
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

</body>
</html>