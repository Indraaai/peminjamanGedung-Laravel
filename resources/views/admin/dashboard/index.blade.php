{{--
    File: resources/views/admin/statistik.blade.php (atau nama file yang sesuai)

    Deskripsi:
    Tampilan halaman statistik peminjaman dengan desain modern dan responsif.
    Menggunakan Tailwind CSS dengan skema warna putih dan hijau muda lembut.
    Fokus pada visualisasi data yang bersih melalui kartu statistik dan grafik.
--}}
<x-app-layout>
    {{-- Slot header di-nonaktifkan untuk integrasi judul yang lebih baik --}}

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Halaman: Judul dan Tombol Aksi -->
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Statistik Peminjaman</h1>

            </div>

            <!-- Kartu Statistik Utama -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Peminjaman -->
                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center space-x-4 transition hover:shadow-lg">
                    <div class="bg-blue-100 p-3 rounded-full"><svg class="w-6 h-6 text-blue-600"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                        </svg></div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Peminjaman</p>
                        <p class="text-2xl font-semibold text-gray-800">{{ $total }}</p>
                    </div>
                </div>
                <!-- Menunggu Persetujuan -->
                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center space-x-4 transition hover:shadow-lg">
                    <div class="bg-yellow-100 p-3 rounded-full"><svg class="w-6 h-6 text-yellow-600"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg></div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Menunggu</p>
                        <p class="text-2xl font-semibold text-gray-800">{{ $menunggu }}</p>
                    </div>
                </div>
                <!-- Disetujui -->
                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center space-x-4 transition hover:shadow-lg">
                    <div class="bg-green-100 p-3 rounded-full"><svg class="w-6 h-6 text-green-600"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg></div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Disetujui</p>
                        <p class="text-2xl font-semibold text-gray-800">{{ $disetujui }}</p>
                    </div>
                </div>
                <!-- Ditolak -->
                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center space-x-4 transition hover:shadow-lg">
                    <div class="bg-red-100 p-3 rounded-full"><svg class="w-6 h-6 text-red-600"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg></div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Ditolak</p>
                        <p class="text-2xl font-semibold text-gray-800">{{ $ditolak }}</p>
                    </div>
                </div>
            </div>

            <!-- Grid untuk Info Tambahan (Ruangan Populer & Grafik) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Kartu Ruangan Terpopuler -->
                @if ($topRuangan)
                    <div
                        class="lg:col-span-1 bg-white p-6 rounded-2xl shadow-sm border border-transparent hover:border-green-300 transition">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ruangan Terpopuler</h3>
                        <div class="flex items-center gap-4">
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5 text-green-600">
                                    <path fill-rule="evenodd"
                                        d="M10.868 2.884c.321-.772 1.415-.772 1.736 0l1.99 4.815 5.232.756c.83.12 1.162 1.14.562 1.703l-3.79 3.694.9 5.212c.142.824-.725 1.45-1.45.986L10 17.585l-4.665 2.453c-.724.464-1.591-.162-1.45-.986l.9-5.212-3.79-3.694c-.6-.563-.268-1.583.562-1.703l5.232-.756L10.868 2.884Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700">{{ $topRuangan->nama }}</p>
                                <p class="text-sm text-gray-500">{{ $topRuangan->gedung->nama }}</p>
                                <p class="text-sm text-green-600 font-semibold mt-1">
                                    {{ $topRuangan->peminjamans_count }} kali dipinjam</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Kartu Grafik -->
                <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Tren Peminjaman Tahun Ini</h3>
                    <div>
                        <canvas id="grafikBulan"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('grafikBulan').getContext('2d');

            // Membuat gradien untuk bar chart
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(74, 222, 128, 0.6)'); // green-400 dengan transparansi
            gradient.addColorStop(1, 'rgba(34, 197, 94, 0.8)'); // green-500 dengan transparansi

            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov',
                        'Des'
                    ],
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: [
                            @for ($i = 1; $i <= 12; $i++)
                                {{ $dataBulanan[$i] ?? 0 }},
                            @endfor
                        ],
                        backgroundColor: gradient,
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 1,
                        borderRadius: 8,
                        hoverBackgroundColor: 'rgba(34, 197, 94, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#e5e7eb', // gray-200
                                borderWidth: 1,
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#6b7280', // gray-500
                                padding: 10,
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                            },
                            ticks: {
                                color: '#6b7280', // gray-500
                                padding: 10,
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Sembunyikan legenda karena sudah jelas dari judul
                        },
                        tooltip: {
                            backgroundColor: '#1f2937', // gray-800
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 12
                            },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false,
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
