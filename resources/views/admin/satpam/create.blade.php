{{--
    File: resources/views/admin/satpam/create.blade.php

    Deskripsi:
    Tampilan untuk form tambah akun satpam baru oleh admin.
    Didesain ulang dengan gaya modern, menampilkan form yang bersih
    dan mudah digunakan, konsisten dengan halaman lainnya.
--}}
<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Halaman -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Tambah Akun Satpam Baru</h1>
                <p class="mt-1 text-sm text-gray-500">Isi detail di bawah ini untuk membuat akun baru.</p>
            </div>

            <!-- Kontainer Form -->
            <div class="bg-white rounded-2xl shadow-sm">
                <form method="POST" action="{{ route('admin.satpam.store') }}">
                    @csrf
                    <div class="p-6 md:p-8 space-y-6">
                        <!-- Nama -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                autofocus
                                class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input id="password" type="password" name="password" required
                                class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Footer Form: Tombol Aksi -->
                    <div
                        class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-2xl flex items-center justify-end gap-4">
                        <a href="{{ route('admin.satpam.index') }}"
                            class="font-medium text-sm text-gray-600 hover:text-gray-900">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-sm">
                            Simpan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
