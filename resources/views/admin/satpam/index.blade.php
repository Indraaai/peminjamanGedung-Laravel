{{--
    File: resources/views/admin/satpam/index.blade.php

    Deskripsi:
    Tampilan untuk manajemen (CRUD) data akun satpam oleh admin.
    Didesain ulang dengan gaya modern, menampilkan data dalam tabel yang
    bersih dan mudah dibaca, lengkap dengan tombol aksi yang intuitif.
--}}
<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Halaman -->
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Manajemen Akun PJ Gedung</h1>
                    <p class="mt-1 text-sm text-gray-500">Tambah, edit, atau hapus data akun PJ Gedung.</p>
                </div>
                <a href="{{ route('admin.satpam.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-300 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                    Tambah Akun PJ Gedung
                </a>
            </div>

            <!-- Kontainer Tabel Data -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-xs text-gray-700 uppercase">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Role</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($satpam as $user)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-800">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.satpam.edit', $user->id) }}"
                                                class="inline-flex items-center p-2 text-sm font-medium text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300"
                                                title="Edit">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                                    <path
                                                        d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                                </svg>
                                            </a>
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.satpam.destroy', $user->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center p-2 text-sm font-medium text-red-600 bg-red-100 rounded-lg hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-300"
                                                    title="Hapus">
                                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.58.22-2.365.468a.75.75 0 1 0 .53 1.437c.84.263 1.68.404 2.535.404h2.5c.855 0 1.695-.14 2.535-.404a.75.75 0 0 0 .53-1.437c-.786-.248-1.57-.391-2.365-.468v-.443A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 10a.75.75 0 0 0-1.5 0v4.5a.75.75 0 0 0 1.5 0v-4.5ZM13.25 10a.75.75 0 0 0-1.5 0v4.5a.75.75 0 0 0 1.5 0v-4.5Z"
                                                            clip-rule="evenodd" />
                                                        <path
                                                            d="M5.959 7.051a.75.75 0 0 1 .53 1.437c-.222.069-.44.145-.65.224l-.224.08c-.33.118-.658.243-.978.372a.75.75 0 0 1-.53-1.437c.338-.126.678-.25.998-.37l.224-.08c.21-.079.428-.155.65-.224Z" />
                                                        <path
                                                            d="M14.041 7.051a.75.75 0 0 0-.53 1.437c.222.069.44.145.65.224l.224.08c.33.118.658.243.978.372a.75.75 0 1 0 .53-1.437c-.338-.126-.678-.25-.998-.37l-.224-.08a4.341 4.341 0 0 0-.65-.224Z" />
                                                        <path
                                                            d="M3 9.75A2.75 2.75 0 0 1 5.75 7h8.5A2.75 2.75 0 0 1 17 9.75v5A2.75 2.75 0 0 1 14.25 17h-8.5A2.75 2.75 0 0 1 3 14.75v-5ZM5.75 8.5c-.69 0-1.25.56-1.25 1.25v5c0 .69.56 1.25 1.25 1.25h8.5c.69 0 1.25-.56 1.25-1.25v-5c0-.69-.56-1.25-1.25-1.25h-8.5Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <p>Belum ada data akun satpam yang ditambahkan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
