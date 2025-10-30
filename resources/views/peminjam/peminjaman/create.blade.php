<x-app-layout>
    {{-- Slot header di-nonaktifkan untuk integrasi judul yang lebih baik --}}

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Halaman -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Ajukan Peminjaman Ruangan</h1>
                <p class="mt-1 text-sm text-gray-500">Lengkapi formulir di bawah ini untuk mengajukan peminjaman ruangan.
                </p>
            </div>

            <!-- Display All Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold mb-2">
                                Terdapat kesalahan pada form:
                            </h3>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Info Ruangan Card -->
            <div class="bg-white rounded-2xl shadow-sm mb-8">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                        <div class="flex-shrink-0">
                            @if ($ruangan->foto)
                                <img src="{{ asset('storage/' . $ruangan->foto) }}" alt="{{ $ruangan->nama }}"
                                    class="w-full md:w-48 h-48 object-cover rounded-xl shadow-sm">
                            @else
                                <div
                                    class="w-full md:w-48 h-48 bg-gray-200 rounded-xl flex items-center justify-center">
                                    <svg class="w-20 h-20 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 space-y-3">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $ruangan->nama }}</h3>
                                <p class="text-sm text-gray-500 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ $ruangan->gedung->nama ?? 'Gedung' }}
                                </p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.095a1.23 1.23 0 0 0 .41-1.412A9.99 9.99 0 0 0 10 12c-2.31 0-4.438.784-6.131 2.095Z" />
                                    </svg>
                                    Kapasitas: <strong>{{ $ruangan->kapasitas }} orang</strong>
                                </div>
                                <div class="flex items-start gap-2 text-sm text-gray-600">
                                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M15.99 5.99a5 5 0 1 0-11.98 0A5 5 0 0 0 15.99 6Zm-5-3a.75.75 0 0 0-1.5 0v1.51a3.52 3.52 0 0 0-1.116.652l-1.06-1.06a.75.75 0 0 0-1.06 1.06l1.06 1.06a3.522 3.522 0 0 0-.653 1.116H4.49a.75.75 0 0 0 0 1.5h1.51c.14 1.25.783 2.348 1.653 3.099l-1.01 1.75a.75.75 0 1 0 1.3.75l1.01-1.75A4.989 4.989 0 0 0 10 14.5a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 0 1.5 0v-1.5a.75.75 0 0 1 .75-.75c1.29 0 2.47-.48 3.35-1.28l1.01 1.75a.75.75 0 1 0 1.3-.75l-1.01-1.75a4.954 4.954 0 0 0 1.652-3.1h1.51a.75.75 0 0 0 0-1.5h-1.51a3.52 3.52 0 0 0-.653-1.116l1.06-1.06a.75.75 0 0 0-1.06-1.06l-1.06 1.06a3.52 3.52 0 0 0-1.116-.653V2.99a.75.75 0 0 0-1.5 0Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Fasilitas: <strong>{{ $ruangan->fasilitas ?? '-' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jadwal Peminjaman Ruangan -->
            <div class="bg-white rounded-2xl shadow-sm mb-8">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Jadwal Peminjaman Ruangan
                    </h3>
                </div>

                <div class="p-6">
                    <!-- Date Selector for Schedule -->
                    <div class="mb-6">
                        <label for="check-tanggal" class="block text-sm font-semibold text-gray-700 mb-2">
                            Pilih tanggal untuk melihat jadwal:
                        </label>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input type="date" id="check-tanggal" value="{{ date('Y-m-d') }}"
                                min="{{ date('Y-m-d') }}"
                                class="flex-1 px-4 py-2 text-sm rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200">
                            <button type="button" id="check-availability-btn"
                                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Cek Jadwal
                            </button>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div id="schedule-loading" class="hidden text-center py-8">
                        <svg class="animate-spin h-10 w-10 mx-auto text-green-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <p class="mt-3 text-sm text-gray-600">Memuat jadwal...</p>
                    </div>

                    <!-- Schedule Display -->
                    <div id="schedule-display" class="space-y-3">
                        <div class="bg-gray-50 border-l-4 border-gray-400 p-4 rounded-r-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p class="text-sm text-gray-700">
                                    Pilih tanggal di atas untuk melihat jadwal peminjaman ruangan ini.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div id="schedule-empty" class="hidden">
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="font-semibold text-green-800">
                                        ✅ Ruangan Tersedia!
                                    </p>
                                    <p class="text-sm text-green-700 mt-1">
                                        Tidak ada peminjaman pada tanggal yang dipilih. Ruangan dapat dipinjam sepanjang
                                        hari.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Error State -->
                    <div id="schedule-error" class="hidden">
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p class="text-sm text-red-700">
                                    Gagal memuat jadwal. Silakan coba lagi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Formulir Pengajuan
                    </h3>
                </div>

                <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data"
                    class="p-6 space-y-6">
                    @csrf
                    <input type="hidden" name="ruangan_id" value="{{ $ruangan->id }}">

                    <!-- Tanggal Peminjaman -->
                    <div class="space-y-2">
                        <label for="tanggal" class="block text-sm font-semibold text-gray-700">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Tanggal Peminjaman
                                <span class="text-red-500 ml-1">*</span>
                            </span>
                        </label>
                        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}"
                            min="{{ date('Y-m-d') }}" required
                            class="w-full px-4 py-2 text-sm rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200 @error('tanggal') border-red-500 @enderror">
                        @error('tanggal')
                            <p class="mt-1 text-xs text-red-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Waktu Peminjaman -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jam Mulai -->
                        <div class="space-y-2">
                            <label for="jam_mulai" class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Jam Mulai
                                    <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}"
                                required
                                class="w-full px-4 py-2 text-sm rounded-lg border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('jam_mulai') border-red-500 @enderror">
                            @error('jam_mulai')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Jam Selesai -->
                        <div class="space-y-2">
                            <label for="jam_selesai" class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Jam Selesai
                                    <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <input type="time" id="jam_selesai" name="jam_selesai"
                                value="{{ old('jam_selesai') }}" required
                                class="w-full px-4 py-2 text-sm rounded-lg border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('jam_selesai') border-red-500 @enderror">
                            @error('jam_selesai')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Info Waktu -->
                    <div class="bg-gray-50 border-l-4 border-gray-400 p-4 rounded-r-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-gray-500 mr-3 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm text-gray-700">
                                Pastikan jam selesai lebih besar dari jam mulai. Maksimal durasi peminjaman adalah 1
                                hari
                                penuh.
                            </p>
                        </div>
                    </div>

                    <!-- Tujuan Peminjaman -->
                    <div class="space-y-2">
                        <label for="tujuan" class="block text-sm font-semibold text-gray-700">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Tujuan Peminjaman
                                <span class="text-red-500 ml-1">*</span>
                            </span>
                        </label>
                        <textarea id="tujuan" name="tujuan" rows="5" required
                            placeholder="Contoh: Rapat organisasi, Seminar, Kuliah tamu, dll."
                            class="w-full px-4 py-2 text-sm rounded-lg border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 resize-none @error('tujuan') border-red-500 @enderror">{{ old('tujuan') }}</textarea>
                        @error('tujuan')
                            <p class="mt-1 text-sm text-red-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">
                            Jelaskan secara detail tujuan peminjaman ruangan (maksimal 500 karakter)
                        </p>
                    </div>

                    <!-- Upload Dokumen -->
                    <div class="space-y-2">
                        <label for="dokumen" class="block text-sm font-semibold text-gray-700">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                Dokumen Pendukung
                                <span class="text-gray-400 ml-1 text-xs">(Opsional)</span>
                            </span>
                        </label>
                        <div class="flex items-center justify-center w-full">
                            <label for="dokumen"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6"
                                    id="upload-placeholder">
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        PDF only (MAX. 2MB)
                                    </p>
                                </div>
                                <div class="hidden" id="file-info">
                                    <div class="flex items-center space-x-2 text-sm text-gray-700">
                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span id="file-name" class="font-medium"></span>
                                    </div>
                                </div>
                                <input id="dokumen" name="dokumen" type="file" class="hidden"
                                    accept=".pdf" />
                            </label>
                        </div>
                        @error('dokumen')
                            <p class="mt-1 text-sm text-red-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Info Penting -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="space-y-1">
                                <p class="text-sm font-semibold text-yellow-800">
                                    Informasi Penting:
                                </p>
                                <ul class="list-disc list-inside text-sm text-yellow-700 space-y-1">
                                    <li>Pengajuan akan diproses oleh admin maksimal 2x24 jam</li>
                                    <li>Pastikan semua data yang diisi sudah benar</li>
                                    <li>Dokumen pendukung akan mempercepat proses approval</li>
                                    <li>Anda akan mendapat notifikasi melalui email setelah pengajuan disetujui/ditolak
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100">
                        <button type="submit"
                            class="w-full sm:flex-1 px-6 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pilih & Ajukan Peminjaman
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tips Card -->
            <div class="mt-6 bg-white rounded-lg shadow-sm p-6">
                <h4 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    Tips Mengajukan Peminjaman:
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Ajukan minimal 3 hari sebelum tanggal penggunaan</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Sertakan dokumen pendukung seperti proposal atau surat</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Cek ketersediaan ruangan di kalender sebelum mengajukan</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Pastikan tujuan peminjaman jelas dan detail</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for file upload preview -->
    <script>
        document.getElementById('dokumen').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const placeholder = document.getElementById('upload-placeholder');
            const fileInfo = document.getElementById('file-info');
            const fileNameSpan = document.getElementById('file-name');

            if (fileName) {
                placeholder.classList.add('hidden');
                fileInfo.classList.remove('hidden');
                fileNameSpan.textContent = fileName;
            } else {
                placeholder.classList.remove('hidden');
                fileInfo.classList.add('hidden');
            }
        });

        // Validation for time
        document.getElementById('jam_selesai').addEventListener('change', function() {
            const jamMulai = document.getElementById('jam_mulai').value;
            const jamSelesai = this.value;

            if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
                alert('Jam selesai harus lebih besar dari jam mulai!');
                this.value = '';
            }
        });

        // Check Availability Function
        const checkAvailabilityBtn = document.getElementById('check-availability-btn');
        const checkTanggal = document.getElementById('check-tanggal');
        const scheduleDisplay = document.getElementById('schedule-display');
        const scheduleLoading = document.getElementById('schedule-loading');
        const scheduleEmpty = document.getElementById('schedule-empty');
        const scheduleError = document.getElementById('schedule-error');
        const ruanganId = {{ $ruangan->id }};

        checkAvailabilityBtn.addEventListener('click', function() {
            const tanggal = checkTanggal.value;

            if (!tanggal) {
                alert('Pilih tanggal terlebih dahulu!');
                return;
            }

            // Show loading, hide others
            scheduleLoading.classList.remove('hidden');
            scheduleDisplay.innerHTML = '';
            scheduleEmpty.classList.add('hidden');
            scheduleError.classList.add('hidden');

            // Fetch availability data
            fetch(`{{ route('peminjaman.availability') }}?ruangan_id=${ruanganId}&tanggal=${tanggal}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    scheduleLoading.classList.add('hidden');

                    if (data.length === 0) {
                        // No bookings, room is available
                        scheduleEmpty.classList.remove('hidden');
                    } else {
                        // Display bookings
                        displaySchedule(data, tanggal);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    scheduleLoading.classList.add('hidden');
                    scheduleError.classList.remove('hidden');
                });
        });

        function displaySchedule(bookings, selectedDate) {
            const formattedDate = new Date(selectedDate).toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            let html = `
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-800 mb-2">
                        📅 Jadwal pada ${formattedDate}
                    </h4>
                    <p class="text-sm text-gray-600 mb-4">
                        Terdapat <span class="font-bold text-red-600">${bookings.length} peminjaman</span> pada tanggal ini
                    </p>
                </div>
                <div class="space-y-3">
            `;

            bookings.forEach((booking, index) => {
                const statusBadge = getStatusBadge(booking.status);
                const timeRange = `${booking.start.substring(0, 5)} - ${booking.end.substring(0, 5)}`;

                html += `
                    <div class="bg-gray-50 rounded-lg p-4 border-l-4 ${getStatusBorderColor(booking.status)}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-semibold text-gray-900">${timeRange}</span>
                                    ${statusBadge}
                                </div>
                                <p class="text-sm text-gray-600 ml-7">
                                    ${booking.tujuan || 'Tidak ada keterangan'}
                                </p>
                            </div>
                        </div>
                    </div>
                `;
            });

            html += `
                </div>
                <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm text-yellow-700">
                            <strong>Perhatian:</strong> Pastikan waktu yang Anda pilih tidak bentrok dengan jadwal di atas.
                        </p>
                    </div>
                </div>
            `;

            scheduleDisplay.innerHTML = html;
        }

        function getStatusBadge(status) {
            const badges = {
                'menunggu': '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>',
                'disetujui': '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>',
                'ditolak': '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>'
            };
            return badges[status] || '';
        }

        function getStatusBorderColor(status) {
            const colors = {
                'menunggu': 'border-yellow-500',
                'disetujui': 'border-green-500',
                'ditolak': 'border-red-500'
            };
            return colors[status] || 'border-gray-500';
        }

        // Auto-fill tanggal form when checking schedule
        checkTanggal.addEventListener('change', function() {
            const tanggalInput = document.getElementById('tanggal');
            if (!tanggalInput.value) {
                tanggalInput.value = this.value;
            }
        });

        // Sync tanggal form with check-tanggal
        document.getElementById('tanggal').addEventListener('change', function() {
            checkTanggal.value = this.value;
            // Auto check availability when date changes
            if (this.value) {
                checkAvailabilityBtn.click();
            }
        });

        // Auto-check availability on page load for today
        document.addEventListener('DOMContentLoaded', function() {
            // Small delay to ensure everything is loaded
            setTimeout(() => {
                checkAvailabilityBtn.click();
            }, 300);
        });
    </script>
</x-app-layout>
