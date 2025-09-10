{{--
    File: resources/views/dashboard.blade.php (atau nama file yang sesuai untuk peminjam)

    Deskripsi:
    Tampilan untuk dashboard peminjam. Didesain ulang dengan gaya modern,
    menampilkan pesan selamat datang, tombol aksi yang jelas, dan tabel riwayat
    peminjaman yang bersih dan informatif.
--}}
<x-app-layout>
    {{-- Slot header di-nonaktifkan untuk integrasi judul yang lebih baik --}}

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Kartu Selamat Datang dan Aksi Utama -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
                <div class="p-6 md:p-8">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Selamat datang, {{ Auth::user()->name }}!
                    </h1>
                    <p class="mt-2 text-gray-600">
                        Anda login sebagai <strong>{{ ucfirst(Auth::user()->role) }}</strong>. Siap untuk memulai
                        aktivitas Anda?
                    </p>
                    <div class="mt-6 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('katalog.index') }}"
                            class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path
                                    d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                            </svg>
                            Ajukan Peminjaman Baru
                        </a>
                        <a href="{{ route('peminjaman.index') }}"
                            class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-white text-gray-700 font-semibold rounded-lg border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M2 3.5A1.5 1.5 0 0 1 3.5 2h1.148a1.5 1.5 0 0 1 1.465 1.175l.716 3.223a1.5 1.5 0 0 1-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 0 0 6.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 0 1 1.767-1.052l3.223.716A1.5 1.5 0 0 1 18 15.352V16.5A1.5 1.5 0 0 1 16.5 18h-13A1.5 1.5 0 0 1 2 16.5v-13Z"
                                    clip-rule="evenodd" />
                            </svg>
                            Lihat Riwayat Peminjaman
                        </a>
                    </div>
                </div>
            </div>

            <!-- Notifikasi Error -->
            @if (session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm"
                    role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Kontainer untuk Tabel Riwayat -->
            <div class="bg-white rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Peminjaman Aktif & Terbaru Anda</h3>
                </div>

                <!-- Tabel Data -->
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-xs text-gray-700 uppercase">
                            <tr>
                                <th scope="col" class="px-6 py-3">Ruangan</th>
                                <th scope="col" class="px-6 py-3">Jadwal</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjamans as $peminjaman)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-800">{{ $peminjaman->ruangan->nama }}</div>
                                        <div class="text-xs text-gray-500">{{ $peminjaman->ruangan->gedung->nama }}
                                        </div>
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
                                            <p class="text-xs">Klik tombol "Ajukan Peminjaman Baru" untuk memulai.</p>
                                        </div>
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
