{{--
    File: resources/views/admin/ruangan/create.blade.php

    Deskripsi:
    Tampilan untuk form tambah ruangan baru. Didesain ulang dengan
    gaya modern, menggunakan input, label, dan tombol yang bersih dan intuitif.
    Menggunakan skema warna putih dan hijau muda lembut yang konsisten.
--}}
<x-app-layout>
    {{-- Slot header di-nonaktifkan untuk integrasi judul yang lebih baik --}}

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Halaman -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Tambah Ruangan Baru</h1>
                <p class="mt-1 text-sm text-gray-500">Isi detail di bawah ini untuk menambahkan ruangan baru ke dalam
                    sistem.</p>
            </div>

            <!-- Kontainer Form -->
            <div class="bg-white rounded-2xl shadow-sm">
                <form method="POST" action="{{ route('admin.ruangan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="p-6 md:p-8 space-y-6">

                        <!-- Grid untuk Nama dan Gedung -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Input Nama Ruangan -->
                            <div>
                                <label for="nama" class="block mb-2 text-sm font-medium text-gray-700">Nama
                                    Ruangan</label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 @error('nama') border-red-500 @enderror"
                                    required>
                                @error('nama')
                                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Select Gedung -->
                            <div>
                                <label for="gedung_id"
                                    class="block mb-2 text-sm font-medium text-gray-700">Gedung</label>
                                <select name="gedung_id" id="gedung_id"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 @error('gedung_id') border-red-500 @enderror"
                                    required>
                                    @foreach ($gedungs as $gedung)
                                        <option value="{{ $gedung->id }}"
                                            {{ old('gedung_id') == $gedung->id ? 'selected' : '' }}>
                                            {{ $gedung->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gedung_id')
                                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Input Kapasitas -->
                        <div>
                            <label for="kapasitas" class="block mb-2 text-sm font-medium text-gray-700">Kapasitas
                                (Orang)</label>
                            <input type="number" name="kapasitas" id="kapasitas" value="{{ old('kapasitas') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 @error('kapasitas') border-red-500 @enderror"
                                required>
                            @error('kapasitas')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Input Fasilitas -->
                        <div>
                            <label for="fasilitas"
                                class="block mb-2 text-sm font-medium text-gray-700">Fasilitas</label>
                            <textarea name="fasilitas" id="fasilitas" rows="4"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 @error('fasilitas') border-red-500 @enderror">{{ old('fasilitas') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Pisahkan setiap fasilitas dengan koma, contoh: AC,
                                Proyektor, Papan Tulis.</p>
                            @error('fasilitas')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Input Foto -->
                        <div>
                            <label for="foto" class="block mb-2 text-sm font-medium text-gray-700">Foto
                                Ruangan</label>
                            <input type="file" name="foto" id="foto"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('foto') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, atau WEBP. Ukuran maks: 2MB.</p>
                            @error('foto')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Footer Form: Tombol Aksi -->
                    <div
                        class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-2xl flex items-center justify-end gap-4">
                        <a href="{{ route('admin.ruangan.index') }}"
                            class="font-medium text-sm text-gray-600 hover:text-gray-900">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-300 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                            Simpan Ruangan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
