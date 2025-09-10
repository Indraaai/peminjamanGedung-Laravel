{{--
    File: resources/views/admin/ruangan/edit.blade.php

    Deskripsi:
    Tampilan untuk form edit data ruangan. Didesain ulang dengan
    gaya modern, memuat data yang ada ke dalam input yang bersih dan intuitif.
    Menggunakan skema warna putih dan hijau muda lembut yang konsisten.
--}}
<x-app-layout>
    {{-- Slot header di-nonaktifkan untuk integrasi judul yang lebih baik --}}

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Halaman -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Edit Ruangan</h1>
                <p class="mt-1 text-sm text-gray-500">Perbarui detail untuk ruangan <span
                        class="font-semibold">{{ $ruangan->nama }}</span>.</p>
            </div>

            <!-- Kontainer Form -->
            <div class="bg-white rounded-2xl shadow-sm">
                <form method="POST" action="{{ route('admin.ruangan.update', $ruangan->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="p-6 md:p-8 space-y-6">

                        <!-- Grid untuk Nama dan Gedung -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Input Nama Ruangan -->
                            <div>
                                <label for="nama" class="block mb-2 text-sm font-medium text-gray-700">Nama
                                    Ruangan</label>
                                <input type="text" name="nama" id="nama"
                                    value="{{ old('nama', $ruangan->nama) }}"
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
                                            {{ old('gedung_id', $ruangan->gedung_id) == $gedung->id ? 'selected' : '' }}>
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
                            <input type="number" name="kapasitas" id="kapasitas"
                                value="{{ old('kapasitas', $ruangan->kapasitas) }}"
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
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 @error('fasilitas') border-red-500 @enderror">{{ old('fasilitas', $ruangan->fasilitas) }}</textarea>
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
                            @if ($ruangan->foto)
                                <div class="my-2">
                                    <p class="text-xs text-gray-500 mb-2">Foto saat ini:</p>
                                    <img src="{{ asset('storage/' . $ruangan->foto) }}" alt="Foto saat ini"
                                        class="h-24 w-auto object-cover rounded-lg shadow-md">
                                </div>
                            @endif
                            <input type="file" name="foto" id="foto"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('foto') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah foto. Format: JPG,
                                PNG, WEBP. Maks: 2MB.</p>
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
                                <path
                                    d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                            </svg>
                            Update Ruangan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
