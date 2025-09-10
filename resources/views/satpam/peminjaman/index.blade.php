{{--
    File: resources/views/satpam/peminjaman/index.blade.php

    Deskripsi:
    Tampilan untuk daftar peminjaman yang disetujui, khusus untuk satpam.
    Didesain ulang dengan gaya modern, menampilkan data dalam tabel yang
    bersih dan mudah dibaca, lengkap dengan fungsionalitas filter dan pencarian.
--}}
<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Halaman -->
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Daftar Peminjaman (Disetujui)</h1>
                    <p class="mt-1 text-sm text-gray-500">Berikut adalah daftar semua peminjaman yang perlu diverifikasi.
                    </p>
                </div>
                <a href="{{ route('satpam.dashboard') }}"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white text-gray-700 font-semibold rounded-lg border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-300 text-sm">
                    Kembali ke Dashboard
                </a>
            </div>

            <!-- Kontainer Tabel Data -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <!-- Filter dan Pencarian -->
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" action="{{ route('satpam.peminjaman.index') }}">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
                            <div class="md:col-span-2">
                                <label for="search" class="block text-xs font-medium text-gray-600 mb-1">Cari Peminjam
                                    / Ruangan</label>
                                <input type="text" id="search" name="search" value="{{ request('search') }}"
                                    placeholder="Masukkan nama atau ruangan..."
                                    class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div>
                                <label for="tanggal"
                                    class="block text-xs font-medium text-gray-600 mb-1">Tanggal</label>
                                <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal') }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="submit"
                                    class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700">
                                    Filter
                                </button>
                                <a href="{{ route('satpam.peminjaman.index') }}"
                                    class="py-2 px-3 text-gray-600 hover:bg-gray-100 rounded-lg" title="Reset Filter">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M15.312 11.312a.75.75 0 0 1 0-1.062l1.688-1.688a.75.75 0 1 1 1.06 1.062l-1.688 1.688a.75.75 0 0 1-1.06 0ZM17.25 9a.75.75 0 0 0 0 1.5h.008a.75.75 0 0 0 0-1.5h-.008ZM5.687 11.312a.75.75 0 0 1-1.06 0l-1.688-1.688a.75.75 0 0 1 1.06-1.062l1.688 1.688a.75.75 0 0 1 0 1.062ZM3.75 9a.75.75 0 0 0 0 1.5h.008a.75.75 0 0 0 0-1.5H3.75Zm5.943 3.943a.75.75 0 0 1-1.06-1.06l1.688-1.688a.75.75 0 1 1 1.06 1.06l-1.688 1.688Zm-3.188-5.688a.75.75 0 0 1 0 1.06l-1.688 1.688a.75.75 0 1 1-1.06-1.06l1.688-1.688a.75.75 0 0 1 1.06 0Zm11.314 0a.75.75 0 0 1 0 1.06l-1.688 1.688a.75.75 0 1 1-1.06-1.06l1.688-1.688a.75.75 0 0 1 1.06 0ZM12 3.75a.75.75 0 0 0-1.5 0v.008a.75.75 0 0 0 1.5 0V3.75Zm-4.313 2.813a.75.75 0 0 1 1.06 0l1.688 1.688a.75.75 0 0 1-1.06 1.06L5.687 7.625a.75.75 0 0 1 0-1.062Zm8.626 0a.75.75 0 0 1 1.06 0l1.688 1.688a.75.75 0 1 1-1.06 1.06l-1.688-1.688a.75.75 0 0 1 0-1.062ZM12 17.25a.75.75 0 0 0-1.5 0v.008a.75.75 0 0 0 1.5 0v-.008Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-xs text-gray-700 uppercase">
                            <tr>
                                <th scope="col" class="px-6 py-3">Peminjam</th>
                                <th scope="col" class="px-6 py-3">Ruangan</th>
                                <th scope="col" class="px-6 py-3">Jadwal Penggunaan</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjaman as $p)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-800">
                                        {{ $p->user->name ?? 'Pengguna tidak ditemukan' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-800">
                                            {{ $p->ruangan->nama ?? 'Ruangan dihapus' }}</div>
                                        <div class="text-xs text-gray-500">{{ $p->ruangan->gedung->nama ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>{{ \Carbon\Carbon::parse($p->tanggal)->isoFormat('dddd, D MMMM Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $p->jam_mulai }} - {{ $p->jam_selesai }}
                                            WIB</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('satpam.peminjaman.show', $p->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200">
                                                Detail
                                            </a>
                                            <a href="{{ route('satpam.peminjaman.pdf', $p->id) }}" target="_blank"
                                                class="inline-flex items-center p-2 text-sm font-medium text-red-600 bg-red-100 rounded-lg hover:bg-red-200"
                                                title="Download PDF">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10.5 3.75a.75.75 0 0 0-1.5 0v5.69L7.72 8.22a.75.75 0 0 0-1.06 1.06l3.5 3.5a.75.75 0 0 0 1.06 0l3.5-3.5a.75.75 0 1 0-1.06-1.06L10.5 9.44V3.75Z"
                                                        clip-rule="evenodd" />
                                                    <path d="M3 14.25a.75.75 0 0 0 0 1.5h14a.75.75 0 0 0 0-1.5H3Z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <p class="font-semibold">Tidak ada data ditemukan.</p>
                                        <p class="text-xs">Coba ubah atau reset filter pencarian Anda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($peminjaman->hasPages())
                    <div class="p-6 border-t border-gray-200">
                        {{ $peminjaman->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
