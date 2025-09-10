{{--
    File: resources/views/satpam/dashboard.blade.php

    Deskripsi:
    Tampilan untuk dashboard satpam. Didesain ulang dengan gaya modern,
    menampilkan statistik kunci dan informasi tugas dalam layout yang bersih
    dan konsisten dengan tema aplikasi.
--}}
<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Halaman -->
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Dashboard PJ Gedung</h1>
                    <p class="mt-1 text-sm text-gray-500">Selamat bertugas, {{ Auth::user()->name }}!</p>
                </div>
                <a href="{{ route('satpam.peminjaman.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M3.75 3.75a.75.75 0 0 0-1.5 0v1.5c0 .414.336.75.75.75h1.5a.75.75 0 0 0 .75-.75v-1.5a.75.75 0 0 0-.75-.75Zm0 4.5a.75.75 0 0 0-1.5 0v1.5c0 .414.336.75.75.75h1.5a.75.75 0 0 0 .75-.75v-1.5a.75.75 0 0 0-.75-.75Zm0 4.5a.75.75 0 0 0-1.5 0v1.5c0 .414.336.75.75.75h1.5a.75.75 0 0 0 .75-.75v-1.5a.75.75 0 0 0-.75-.75Zm4.5-.75a.75.75 0 0 1 .75-.75h9a.75.75 0 0 1 0 1.5h-9a.75.75 0 0 1-.75-.75Zm0-4.5a.75.75 0 0 1 .75-.75h9a.75.75 0 0 1 0 1.5h-9a.75.75 0 0 1-.75-.75Zm0-4.5a.75.75 0 0 1 .75-.75h9a.75.75 0 0 1 0 1.5h-9a.75.75 0 0 1-.75-.75Z" />
                    </svg>
                    Lihat Semua Peminjaman
                </a>
            </div>

            <!-- Kartu Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Disetujui -->
                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center space-x-4 transition hover:shadow-lg">
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Peminjaman Disetujui</p>
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalDisetujui }}</p>
                    </div>
                </div>

                <!-- Contoh Kartu Tambahan: Peminjaman Hari Ini -->

            </div>

            <!-- Kartu Informasi Tugas -->
            <div class="bg-white rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi & Tugas</h3>
                </div>
                <div class="p-6 text-gray-600 text-sm leading-relaxed">
                    <p>
                        Tugas utama Anda adalah memverifikasi setiap peminjaman yang telah disetujui oleh admin.
                        Pastikan peminjam yang datang sesuai dengan data yang tertera pada sistem.
                    </p>
                    <ul class="list-disc list-inside mt-4 space-y-2">
                        <li>Periksa detail peminjaman melalui tombol <strong>"Lihat Semua Peminjaman"</strong>.</li>
                        <li>Pastikan identitas peminjam sesuai dengan yang tercatat.</li>
                        <li>Laporkan jika ada aktivitas yang tidak sesuai atau mencurigakan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
