{{--
    File: resources/views/peminjam/peminjaman/show.blade.php

    Deskripsi:
    Tampilan untuk detail peminjaman yang diajukan oleh peminjam.
    Menampilkan informasi lengkap tentang peminjaman dengan layout yang bersih dan informatif.
--}}
<x-app-layout>
    {{-- Slot header di-nonaktifkan untuk integrasi judul yang lebih baik --}}

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Halaman -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Detail Peminjaman</h1>
                <p class="mt-1 text-sm text-gray-500">Informasi lengkap tentang peminjaman ruangan Anda.</p>
            </div>

            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm"
                    role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Notifikasi Error -->
            @if (session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm"
                    role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Kartu Detail Peminjaman -->
            <div class="bg-white rounded-2xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Informasi Peminjaman</h3>
                        <div>
                            @if ($peminjaman->status == 'disetujui')
                                <span
                                    class="px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">Disetujui</span>
                            @elseif ($peminjaman->status == 'ditolak')
                                <span
                                    class="px-3 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full">Ditolak</span>
                            @else
                                <span
                                    class="px-3 py-1 text-sm font-semibold text-yellow-800 bg-yellow-100 rounded-full">Menunggu</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm">
                        <div>
                            <dt class="font-medium text-gray-500">Ruangan</dt>
                            <dd class="mt-1 font-semibold text-gray-800">{{ $peminjaman->ruangan->nama }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Gedung</dt>
                            <dd class="mt-1 text-gray-800">{{ $peminjaman->ruangan->gedung->nama }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Kapasitas</dt>
                            <dd class="mt-1 text-gray-800">{{ $peminjaman->ruangan->kapasitas }} orang</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Tanggal Peminjaman</dt>
                            <dd class="mt-1 text-gray-800">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal)->isoFormat('dddd, D MMMM Y') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Waktu Mulai</dt>
                            <dd class="mt-1 text-gray-800">{{ $peminjaman->jam_mulai }} WIB</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Waktu Selesai</dt>
                            <dd class="mt-1 text-gray-800">{{ $peminjaman->jam_selesai }} WIB</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="font-medium text-gray-500">Tujuan Peminjaman</dt>
                            <dd class="mt-1 text-gray-800 whitespace-pre-wrap">{{ $peminjaman->tujuan }}</dd>
                        </div>
                        @if ($peminjaman->catatan_admin)
                            <div class="sm:col-span-2">
                                <dt class="font-medium text-gray-500">Catatan Admin</dt>
                                <dd class="mt-1 text-gray-800 bg-blue-50 p-3 rounded-lg border border-blue-200">
                                    {{ $peminjaman->catatan_admin }}
                                </dd>
                            </div>
                        @endif
                        <div>
                            <dt class="font-medium text-gray-500">Tanggal Pengajuan</dt>
                            <dd class="mt-1 text-gray-800">
                                {{ $peminjaman->created_at->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB
                            </dd>
                        </div>
                        @if ($peminjaman->updated_at != $peminjaman->created_at)
                            <div>
                                <dt class="font-medium text-gray-500">Terakhir Diperbarui</dt>
                                <dd class="mt-1 text-gray-800">
                                    {{ $peminjaman->updated_at->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Dokumen Pendukung -->
                @if ($peminjaman->dokumen)
                    <div class="p-6 border-t border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Surat Permohonan</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <iframe src="{{ asset('storage/' . $peminjaman->dokumen) }}"
                                class="w-full h-96 border border-gray-300 rounded-lg"></iframe>
                            <a href="{{ asset('storage/' . $peminjaman->dokumen) }}" target="_blank"
                                class="inline-flex items-center gap-2 mt-4 text-sm font-medium text-blue-600 hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path
                                        d="M10.75 2.75a.75.75 0 0 0-1.5 0v8.614L6.295 8.235a.75.75 0 1 0-1.09 1.03l4.25 4.5a.75.75 0 0 0 1.09 0l4.25-4.5a.75.75 0 0 0-1.09-1.03l-2.955 3.129V2.75Z" />
                                    <path
                                        d="M3.5 12.75a.75.75 0 0 0-1.5 0v2.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25v-2.5a.75.75 0 0 0-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5Z" />
                                </svg>
                                Unduh PDF
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div
                    class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-2xl flex items-center justify-between">
                    <a href="{{ route('peminjaman.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z"
                                clip-rule="evenodd" />
                        </svg>
                        Kembali ke Riwayat
                    </a>

                    @if ($peminjaman->status == 'menunggu')
                        <form action="{{ route('peminjaman.cancel', $peminjaman->id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Batalkan Peminjaman
                            </button>
                        </form>
                    @elseif ($peminjaman->status == 'disetujui')
                        <a href="{{ route('peminjaman.pdf', $peminjaman->id) }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 text-sm"
                            title="Unduh Bukti Peminjaman">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path
                                    d="M10.75 2.75a.75.75 0 0 0-1.5 0v8.614L6.295 8.235a.75.75 0 1 0-1.09 1.03l4.25 4.5a.75.75 0 0 0 1.09 0l4.25-4.5a.75.75 0 0 0-1.09-1.03l-2.955 3.129V2.75Z" />
                                <path
                                    d="M3.5 12.75a.75.75 0 0 0-1.5 0v2.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25v-2.5a.75.75 0 0 0-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5Z" />
                            </svg>
                            Unduh Bukti PDF
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
