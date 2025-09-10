<x-app-layout>
    {{-- Slot header di-nonaktifkan untuk integrasi judul yang lebih baik --}}

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Halaman -->
            <div class="mb-10 text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Katalog Ruangan</h1>
                <p class="mt-2 text-md text-gray-500">Pilih ruangan yang sesuai dengan kebutuhan Anda.</p>
            </div>

            <!-- Loop untuk setiap Gedung -->
            @foreach ($gedungs as $gedung)
                <div class="mb-12">
                    <!-- Header Gedung -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">{{ $gedung->nama }}</h2>
                        <p class="text-sm text-gray-500 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-4 h-4">
                                <path fill-rule="evenodd"
                                    d="m9.69 18.933.003.001a9.75 9.75 0 0 1 5.312-5.312l.001-.003.001-.002a9.755 9.755 0 0 0-5.314-5.314l-.002-.001-.001-.002A9.75 9.75 0 0 0 4.368 13.62l-.002.001-.001.002.001.002a9.75 9.75 0 0 1 5.312 5.312Zm0-1.5c-2.52 0-4.63-1.89-5.12-4.438a.75.75 0 0 1 .63-1.062l.068.018a5.25 5.25 0 0 0 4.422-4.422l-.018-.068a.75.75 0 0 1 1.062-.63c2.548.49 4.438 2.6 4.438 5.12 0 2.87-2.33 5.2-5.2 5.2Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $gedung->lokasi }}
                        </p>
                    </div>

                    <!-- Grid untuk Ruangan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse ($gedung->ruangans as $ruangan)
                            <div
                                class="bg-white rounded-2xl shadow-sm flex flex-col overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <!-- Gambar Ruangan -->
                                <div class="h-48 bg-gray-200">
                                    @if ($ruangan->foto)
                                        <img src="{{ asset('storage/' . $ruangan->foto) }}"
                                            alt="Foto {{ $ruangan->nama }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Konten Kartu -->
                                <div class="p-6 flex-grow flex flex-col">
                                    <h4 class="font-bold text-lg text-gray-800">{{ $ruangan->nama }}</h4>

                                    <div class="mt-4 space-y-3 text-sm text-gray-600">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-5 h-5 text-gray-400">
                                                <path
                                                    d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.095a1.23 1.23 0 0 0 .41-1.412A9.99 9.99 0 0 0 10 12c-2.31 0-4.438.784-6.131 2.095Z" />
                                            </svg>
                                            <span>Kapasitas: <strong>{{ $ruangan->kapasitas }} orang</strong></span>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-5 h-5 text-gray-400 flex-shrink-0">
                                                <path fill-rule="evenodd"
                                                    d="M15.99 5.99a5 5 0 1 0-11.98 0A5 5 0 0 0 15.99 6Zm-5-3a.75.75 0 0 0-1.5 0v1.51a3.52 3.52 0 0 0-1.116.652l-1.06-1.06a.75.75 0 0 0-1.06 1.06l1.06 1.06a3.522 3.522 0 0 0-.653 1.116H4.49a.75.75 0 0 0 0 1.5h1.51c.14 1.25.783 2.348 1.653 3.099l-1.01 1.75a.75.75 0 1 0 1.3  .75l1.01-1.75A4.989 4.989 0 0 0 10 14.5a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 0 1.5 0v-1.5a.75.75 0 0 1 .75-.75c1.29 0 2.47-.48 3.35-1.28l1.01 1.75a.75.75 0 1 0 1.3-.75l-1.01-1.75a4.954 4.954 0 0 0 1.652-3.1h1.51a.75.75 0 0 0 0-1.5h-1.51a3.52 3.52 0 0 0-.653-1.116l1.06-1.06a.75.75 0 0 0-1.06-1.06l-1.06 1.06a3.52 3.52 0 0 0-1.116-.653V2.99a.75.75 0 0 0-1.5 0Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span>Fasilitas: <strong>{{ $ruangan->fasilitas ?? '-' }}</strong></span>
                                        </div>
                                    </div>

                                    <div class="flex-grow"></div>

                                    <div class="mt-6 pt-6 border-t border-gray-100">
                                        <a href="{{ route('peminjaman.create', ['ruangan_id' => $ruangan->id]) }}"
                                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-sm">
                                            Pilih & Ajukan Peminjaman
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="md:col-span-2 lg:col-span-3 bg-white rounded-2xl shadow-sm p-12 text-center text-gray-500">
                                <p>Tidak ada ruangan yang tersedia di gedung ini saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
