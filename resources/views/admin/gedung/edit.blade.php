<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Gedung') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow-sm">
                <form action="{{ route('admin.gedung.update', $gedung->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="nama" class="block text-gray-700 font-bold mb-2">Nama Gedung</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $gedung->nama) }}"
                            required class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="lokasi" class="block text-gray-700 font-bold mb-2">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $gedung->lokasi) }}"
                            required class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('lokasi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-gray-700 font-bold mb-2">Deskripsi Gedung</label>
                        <input type="text" name="deskripsi" id="deskripsi"
                            value="{{ old('deskripsi', $gedung->deskripsi) }}" required
                            class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('deskripsi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update</button>
                        <a href="{{ route('admin.gedung.index') }}"
                            class="ml-2 text-gray-600 hover:underline">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
