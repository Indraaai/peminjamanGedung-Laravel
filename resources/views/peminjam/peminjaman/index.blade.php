{{--
    File: resources/views/peminjaman/index.blade.php

    Deskripsi:
    Tampilan untuk halaman riwayat peminjaman pengguna. Didesain ulang
    dengan gaya modern, menggunakan tabel yang bersih dan informatif
    untuk menampilkan semua peminjaman yang pernah diajukan.
--}}
<x-app-layout>
    {{-- Slot header di-nonaktifkan untuk integrasi judul yang lebih baik --}}

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Halaman -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Riwayat Peminjaman Saya</h1>
                <p class="mt-1 text-sm text-gray-500">Lihat semua peminjaman yang pernah Anda ajukan.</p>
            </div>

            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm"
                    role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Kontainer untuk Tabel Riwayat -->
            <div class="bg-white rounded-2xl shadow-sm">

                <!-- Tabel Data -->
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-xs text-gray-700 uppercase">
                            <tr>
                                <th scope="col" class="px-6 py-3">Ruangan</th>
                                <th scope="col" class="px-6 py-3">Jadwal Penggunaan</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjamans as $peminjaman)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-800">
                                        {{ $peminjaman->ruangan->nama }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            {{ \Carbon\Carbon::parse($peminjaman->tanggal)->isoFormat('dddd, D MMMM Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $peminjaman->jam_mulai }} -
                                            {{ $peminjaman->jam_selesai }} WIB</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                            @if ($peminjaman->status == 'menunggu') bg-yellow-100 text-yellow-800
                                            @elseif($peminjaman->status == 'disetujui') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($peminjaman->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 flex items-center gap-4">
                                        <a href="{{ route('peminjaman.show', $peminjaman->id) }}"
                                            class="font-medium text-blue-600 hover:underline">Detail</a>
                                        @if ($peminjaman->status == 'menunggu')
                                            <form action="{{ route('peminjaman.cancel', $peminjaman->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="font-medium text-red-600 hover:underline">Batalkan</button>
                                            </form>
                                        @elseif ($peminjaman->status == 'disetujui')
                                            <a href="{{ route('peminjaman.pdf', $peminjaman->id) }}"
                                                class="font-medium text-green-600 hover:underline"
                                                title="Unduh Bukti Peminjaman">
                                                Unduh PDF
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-2" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.5a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 4.5 3.75h15A2.25 2.25 0 0 1 21.75 6v3.776" />
                                            </svg>
                                            <p class="font-semibold">Anda belum memiliki riwayat peminjaman.</p>
                                            <p class="text-xs">Silakan ajukan peminjaman baru melalui katalog ruangan.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginasi -->
                @if ($peminjamans->hasPages())
                    <div class="p-6 border-t border-gray-100">
                        {{ $peminjamans->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
