{{--
    File: resources/views/admin/peminjaman/index.blade.php

    Deskripsi:
    Tampilan untuk manajemen permintaan peminjaman. Didesain ulang dengan
    gaya modern, menampilkan filter yang rapi, tabel data yang bersih,
    dan lencana status berwarna untuk kemudahan identifikasi.
--}}
<x-app-layout>
    {{-- Slot header di-nonaktifkan untuk integrasi judul yang lebih baik --}}

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Halaman -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Manajemen Peminjaman</h1>
                <p class="mt-1 text-sm text-gray-500">Tinjau, setujui, atau tolak permintaan peminjaman ruangan.</p>
            </div>

            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm"
                    role="alert">
                    <p class="font-bold">Sukses</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Kontainer untuk Filter dan Tabel -->
            <div class="bg-white rounded-2xl shadow-sm">
                <!-- Bagian Filter dan Aksi -->
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" action="{{ route('satpam.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Input Pencarian -->
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama/ruangan..."
                                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-green-500 focus:border-green-500">

                            <!-- Filter Status -->
                            <select name="status"
                                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-green-500 focus:border-green-500">
                                <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua Status
                                </option>
                                <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>
                                    Menunggu</option>
                                <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>
                                    Disetujui</option>
                                <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>

                            <!-- Filter Tanggal -->
                            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-green-500 focus:border-green-500">

                            <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-green-500 focus:border-green-500">
                        </div>
                        <div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="flex items-center gap-2">
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Filter
                                </button>
                                <a href="{{ route('satpam.index') }}"
                                    class="text-sm text-gray-600 hover:underline">Reset</a>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- Tabel Data -->
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-xs text-gray-700 uppercase">
                            <tr>
                                <th scope="col" class="px-6 py-3">Peminjam</th>
                                <th scope="col" class="px-6 py-3">Ruangan</th>
                                <th scope="col" class="px-6 py-3">Jadwal</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permintaanBaru as $p)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-800">{{ $p->user->name }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-800">{{ $p->ruangan->nama }}</div>
                                        <div class="text-xs text-gray-500">{{ $p->ruangan->gedung->nama }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            {{ \Carbon\Carbon::parse($p->tanggal)->isoFormat('dddd, D MMMM Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $p->jam_mulai }} - {{ $p->jam_selesai }}
                                            WIB</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($p->status == 'disetujui')
                                            <span
                                                class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Disetujui</span>
                                        @elseif ($p->status == 'ditolak')
                                            <span
                                                class="px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">Ditolak</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('satpam.show', $p->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                            Tinjau
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-2" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.03 1.125 0 1.131.094 1.976 1.057 1.976 2.192V7.5M12 14.25v-6.375m-6.375 6.375h3.375m-3.375 0V16.5m6.375-6.375v6.375m6.375-6.375H9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <p class="font-semibold">Tidak ada data peminjaman.</p>
                                            <p class="text-xs">Coba ubah filter atau reset pencarian.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($permintaanBaru->hasPages())
                    <div class="p-6 border-t border-gray-200">
                        {{ $permintaanBaru->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
