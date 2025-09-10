{{--
    File: resources/views/profil/create.blade.php

    Deskripsi:
    Tampilan untuk halaman melengkapi profil setelah registrasi.
    Didesain ulang dengan gaya modern, menggunakan kartu yang bersih dan
    formulir yang terstruktur sesuai dengan role pengguna (mahasiswa/dosen).
--}}
<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl">
                <div class="p-8 md:p-10">

                    <!-- Header Kartu -->
                    <div class="text-center">
                        <h1 class="text-2xl font-bold text-gray-800">Lengkapi Profil Anda</h1>
                        <p class="mt-2 text-gray-600">
                            Anda harus melengkapi profil sebagai <strong>{{ ucfirst(Auth::user()->role) }}</strong>
                            untuk dapat melanjutkan.
                        </p>
                    </div>

                    <div class="mt-8">
                        <form method="POST" action="{{ route('profil.store') }}">
                            @csrf

                            {{-- TAMPILKAN FORM UNTUK MAHASISWA --}}
                            @if (Auth::user()->role == 'mahasiswa')
                                <div class="space-y-6">
                                    <div>
                                        <label for="nim" class="block text-sm font-medium text-gray-700">Nomor
                                            Induk Mahasiswa (NIM)</label>
                                        <input id="nim" type="text" name="nim" value="{{ old('nim') }}"
                                            required autofocus
                                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                        <x-input-error :messages="$errors->get('nim')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="fakultas"
                                            class="block text-sm font-medium text-gray-700">Fakultas</label>
                                        <input id="fakultas" type="text" name="fakultas"
                                            value="{{ old('fakultas') }}" required
                                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                        <x-input-error :messages="$errors->get('fakultas')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan /
                                            Program Studi</label>
                                        <input id="jurusan" type="text" name="jurusan" value="{{ old('jurusan') }}"
                                            required
                                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                        <x-input-error :messages="$errors->get('jurusan')" class="mt-2" />
                                    </div>
                                </div>

                                {{-- TAMPILKAN FORM UNTUK DOSEN --}}
                            @elseif(Auth::user()->role == 'dosen')
                                <div class="space-y-6">
                                    <div>
                                        <label for="nidn_nip" class="block text-sm font-medium text-gray-700">Nomor
                                            Induk Dosen Nasional (NIDN)</label>
                                        <input id="nidn_nip" type="text" name="nidn_nip"
                                            value="{{ old('nidn_nip') }}" required autofocus
                                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                        <x-input-error :messages="$errors->get('nidn_nip')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="fakultas"
                                            class="block text-sm font-medium text-gray-700">Fakultas</label>
                                        <input id="fakultas" type="text" name="fakultas"
                                            value="{{ old('fakultas') }}" required
                                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                        <x-input-error :messages="$errors->get('fakultas')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="departemen"
                                            class="block text-sm font-medium text-gray-700">Departemen</label>
                                        <input id="departemen" type="text" name="departemen"
                                            value="{{ old('departemen') }}" required
                                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                        <x-input-error :messages="$errors->get('departemen')" class="mt-2" />
                                    </div>
                                </div>
                            @elseif(Auth::user()->role == 'satpam')
                                <div class="space-y-6">
                                    <div>
                                        <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor
                                            Handphone </label>
                                        <input id="no_telepon" type="text" name="no_telepon"
                                            value="{{ old('no_telepon') }}" required autofocus
                                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                        <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="alamat"
                                            class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <input id="alamat" type="text" name="alamat" value="{{ old('alamat') }}"
                                            required
                                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                                    </div>
                                </div>
                            @endif

                            <div class="mt-8">
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Simpan Profil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
