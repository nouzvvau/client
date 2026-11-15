<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Acara - Admin Cakra Aji</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#F5F1EB] text-[#3D2B1F]">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-[#5A3825] text-white p-6">
            <h1 class="text-xl font-bold mb-8">CAKRA AJI ADMIN</h1>

            <nav class="space-y-3">
                <a href="{{ route('admin.galeri') }}"
                   class="block px-4 py-3 rounded-lg bg-[#79543C]">
                    Galeri
                </a>

                <a href="{{ url('/') }}"
                   class="block px-4 py-3 rounded-lg hover:bg-[#79543C]">
                    Website
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">

            <div class="mb-8">
                <a href="{{ route('admin.galeri') }}"
                   class="text-sm text-[#8B684C] hover:underline">
                    ← Kembali ke Galeri
                </a>

                <h2 class="text-3xl font-bold mt-3">Tambah Acara</h2>
                <p class="text-gray-500 mt-2">
                    Tambahkan dokumentasi kegiatan Cakra Aji.
                </p>
            </div>

            <!-- Error Validation -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg mb-6">
                    <p class="font-semibold mb-2">Ada kesalahan:</p>

                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form -->
            <form
                action="{{ route('admin.galeri.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="bg-white rounded-xl shadow-sm p-8 max-w-3xl"
            >

                @csrf

                <!-- Judul -->
                <div class="mb-6">
                    <label for="title" class="block font-semibold mb-2">
                        Nama Acara
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Contoh: Grebek Kampung"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#79543C]"
                    >
                </div>

                <!-- Tanggal -->
                <div class="mb-6">
                    <label for="date" class="block font-semibold mb-2">
                        Tanggal Acara
                    </label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="{{ old('date') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#79543C]"
                    >
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label for="description" class="block font-semibold mb-2">
                        Deskripsi Acara
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Ceritakan kegiatan yang dilaksanakan..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#79543C]"
                    >{{ old('description') }}</textarea>
                </div>

                <!-- Foto -->
                <div class="mb-8">
                    <label for="photos" class="block font-semibold mb-2">
                        Dokumentasi Foto
                    </label>

                    <input
                        type="file"
                        id="photos"
                        name="photos[]"
                        accept="image/*"
                        multiple
                        class="w-full border border-gray-300 rounded-lg px-4 py-3"
                    >

                    <p class="text-sm text-gray-500 mt-2">
                        Bisa memilih beberapa foto sekaligus. Maksimal 5 MB per foto.
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="bg-[#79543C] text-white px-6 py-3 rounded-lg hover:bg-[#5A3825] transition"
                    >
                        Simpan Acara
                    </button>

                    <a
                        href="{{ route('admin.galeri') }}"
                        class="border border-gray-300 px-6 py-3 rounded-lg hover:bg-gray-100 transition"
                    >
                        Batal
                    </a>
                </div>

            </form>

        </main>

    </div>

</body>
</html>