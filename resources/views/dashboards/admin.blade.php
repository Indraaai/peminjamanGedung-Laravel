<x-app-layout>
    {{-- Slot header di-nonaktifkan karena judul sudah terintegrasi di dalam konten utama --}}
    {{--
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>
    --}}

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header dan Pesan Selamat Datang -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
                <div class="mt-2 p-4 text-sm text-green-800 rounded-lg bg-green-100 border border-green-300"
                    role="alert">
                    <span class="font-medium">Selamat Datang, {{ Auth::user()->name }}!</span> Anda login sebagai Admin.
                    Di sini Anda dapat mengelola seluruh sistem.
                </div>
            </div>

            <!-- Kartu Statistik Utama -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Contoh Kartu Statistik 1: Total Peminjaman -->
                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center space-x-4 transition hover:shadow-lg">
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Peminjaman</p>
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalPeminjaman }}</p> {{-- Ganti dengan data dinamis --}}
                    </div>
                </div>

                <!-- Contoh Kartu Statistik 2: Peminjaman Tertunda -->
                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center space-x-4 transition hover:shadow-lg">
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Menunggu Persetujuan</p>
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalMenunggu }}</p> {{-- Ganti dengan data dinamis --}}
                    </div>
                </div>

                <!-- Contoh Kartu Statistik 3: Ruangan Tersedia -->
                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center space-x-4 transition hover:shadow-lg">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m-3-1-3-1.091m0 0-3 1.091m0 0-3-1.091m9 6.205-3-1.091m6 .545-3-1.091m0 0l-3 1.091M3.75 9.75l3 1.091m0 0l3-1.091m0 0l-3-1.091m-3 1.091 3 1.091" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Ruangan Tersedia</p>
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalRuangan }}</p> {{-- Ganti dengan data dinamis --}}
                    </div>
                </div>

                <!-- Contoh Kartu Statistik 4: Pengguna Aktif -->
                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center space-x-4 transition hover:shadow-lg">
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pengguna Aktif</p>
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalUserAktif }}</p>
                        {{-- Ganti dengan data dinamis --}}
                    </div>
                </div>
            </div>

            <!-- Kartu Fitur Utama -->
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl">
                <div class="p-6 md:p-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Aksi Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Kartu Manajemen Peminjaman -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 hover:border-green-400 transition">
                            <h4 class="font-bold text-lg text-gray-800">Manajemen Peminjaman</h4>
                            <p class="text-sm text-gray-600 mt-2">Lihat, setujui, atau tolak pengajuan peminjaman yang
                                masuk.</p>
                            <a href="{{ route('admin.peminjaman.index') }}"
                                class="inline-block mt-4 px-5 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-300 text-sm">
                                Lihat Daftar Peminjaman
                            </a>
                        </div>

                        <!-- Kartu Manajemen Ruangan -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 hover:border-green-400 transition">
                            <h4 class="font-bold text-lg text-gray-800">Manajemen Ruangan</h4>
                            <p class="text-sm text-gray-600 mt-2">Tambah, edit, atau hapus data gedung dan ruangan.</p>
                            <div class="mt-4 space-x-0 space-y-2 sm:space-x-2 sm:space-y-0">
                                <a href="{{ route('admin.gedung.index') }}"
                                    class="inline-block px-5 py-2 bg-white border border-green-500 text-green-600 font-semibold rounded-lg hover:bg-green-50 transition-colors duration-300 text-sm">
                                    Kelola Gedung
                                </a>
                                <a href="{{ route('admin.ruangan.index') }}"
                                    class="inline-block px-5 py-2 bg-white border border-green-500 text-green-600 font-semibold rounded-lg hover:bg-green-50 transition-colors duration-300 text-sm">
                                    Kelola Ruangan
                                </a>
                            </div>
                        </div>

                        <!-- Kartu Lihat Statistik -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 hover:border-green-400 transition">
                            <h4 class="font-bold text-lg text-gray-800">Laporan & Statistik</h4>
                            <p class="text-sm text-gray-600 mt-2">Lihat statistik dan laporan data peminjaman secara
                                mendalam.</p>
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-block mt-4 px-5 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-300 text-sm">
                                Lihat Statistik
                            </a>
                        </div>

                        <!-- Kartu Kelola Data Satpam -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 hover:border-green-400 transition">
                            <h4 class="font-bold text-lg text-gray-800">Kelola Data PJ Gedung</h4>
                            <p class="text-sm text-gray-600 mt-2">Data PJ GEDUNG.</p>
                            <a href="{{ route('admin.satpam.index') }}"
                                class="inline-block mt-4 px-5 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-300 text-sm">
                                Lihat Data
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
