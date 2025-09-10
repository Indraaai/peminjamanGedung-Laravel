{{--
    File: resources/views/admin/peminjaman/show.blade.php

    Deskripsi:
    Tampilan untuk meninjau detail dan memverifikasi sebuah permintaan peminjaman.
    Didesain ulang dengan layout dua kolom yang modern, memisahkan data
    informatif dengan form aksi untuk pengalaman pengguna yang lebih baik.
--}}
<x-app-layout>
    {{-- Slot header di-nonaktifkan untuk integrasi judul yang lebih baik --}}

    <x-slot name="styles">
        <style>
            .conflict-warning {
                background-color: #fef2f2;
                border: 2px solid #f87171;
                border-radius: 8px;
                padding: 16px;
                animation: pulse 2s infinite;
            }
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.8; }
            }
            .schedule-conflict {
                background-color: #fee2e2;
                border-left: 4px solid #ef4444;
                padding: 12px;
                margin: 8px 0;
                border-radius: 6px;
            }
        </style>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Halaman -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Tinjau Peminjaman</h1>
                <p class="mt-1 text-sm text-gray-500">Verifikasi detail peminjaman dan ubah statusnya.</p>
            </div>

            <!-- Notifikasi Error -->
            @if (session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm conflict-warning"
                    role="alert">
                    <p class="font-bold">🚫 Gagal Memproses</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Peringatan Konflik Jadwal -->
            <div id="schedule-warning" class="mb-6 hidden">
                <div class="conflict-warning">
                    <h3 class="text-lg font-bold text-red-800 mb-2">⚠️ Peringatan Konflik Jadwal!</h3>
                    <div id="conflict-details" class="text-red-700"></div>
                    <p class="text-red-600 mt-2 font-medium">Admin tidak dapat menyetujui peminjaman ini karena ada konflik jadwal.</p>
                </div>
            </div>

            <!-- Grid Layout Utama -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Kolom Kiri: Detail Peminjaman & Peminjam -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Kartu Detail Peminjaman -->
                    <div class="bg-white rounded-2xl shadow-sm">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Detail Permintaan</h3>
                        </div>
                        <div class="p-6">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm">
                                <div class="sm:col-span-2">
                                    <dt class="font-medium text-gray-500">Status Saat Ini</dt>
                                    <dd class="mt-1">
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
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Ruangan</dt>
                                    <dd class="mt-1 font-semibold text-gray-800">{{ $peminjaman->ruangan->nama }}
                                        ({{ $peminjaman->ruangan->gedung->nama }})</dd>
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
                                    <dt class="font-medium text-gray-500">Waktu</dt>
                                    <dd class="mt-1 text-gray-800">{{ $peminjaman->jam_mulai }} -
                                        {{ $peminjaman->jam_selesai }} WIB</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="font-medium text-gray-500">Tujuan Peminjaman</dt>
                                    <dd class="mt-1 text-gray-800 whitespace-pre-wrap">{{ $peminjaman->tujuan }}</dd>
                                </div>
                                @if ($peminjaman->catatan_admin)
                                    <div class="sm:col-span-2">
                                        <dt class="font-medium text-gray-500">Catatan Admin</dt>
                                        <dd
                                            class="mt-1 text-gray-800 bg-yellow-50 p-3 rounded-lg border border-yellow-200">
                                            {{ $peminjaman->catatan_admin }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Kartu Informasi Peminjam -->
                    <div class="bg-white rounded-2xl shadow-sm">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Informasi Peminjam</h3>
                        </div>
                        <div class="p-6">
                            @php
                                $profil = $user->role === 'mahasiswa' ? $user->profilMahasiswa : $user->profilDosen;
                            @endphp
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm">
                                <div>
                                    <dt class="font-medium text-gray-500">Nama Lengkap</dt>
                                    <dd class="mt-1 text-gray-800">{{ $user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1 text-gray-800 capitalize">{{ $user->role }}</dd>
                                </div>
                                @if ($user->role === 'mahasiswa')
                                    <div>
                                        <dt class="font-medium text-gray-500">NIM</dt>
                                        <dd class="mt-1 text-gray-800">{{ $profil->nim ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Fakultas</dt>
                                        <dd class="mt-1 text-gray-800">{{ $profil->fakultas ?? '-' }}</dd>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <dt class="font-medium text-gray-500">Program Studi</dt>
                                        <dd class="mt-1 text-gray-800">{{ $profil->jurusan ?? '-' }}</dd>
                                    </div>
                                @elseif ($user->role === 'dosen')
                                    <div>
                                        <dt class="font-medium text-gray-500">NIDN/NIP</dt>
                                        <dd class="mt-1 text-gray-800">{{ $profil->nidn_nip ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Fakultas</dt>
                                        <dd class="mt-1 text-gray-800">{{ $profil->fakultas ?? '-' }}</dd>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <dt class="font-medium text-gray-500">Departemen</dt>
                                        <dd class="mt-1 text-gray-800">{{ $profil->Departemen ?? '-' }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Kartu Dokumen Pendukung -->
                    @if ($peminjaman->dokumen)
                        <div class="bg-white rounded-2xl shadow-sm">
                            <div class="p-6 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800">Surat Permohonan</h3>
                            </div>
                            <div class="p-6">
                                <iframe src="{{ asset('storage/' . $peminjaman->dokumen) }}"
                                    class="w-full h-96 mt-2 border border-gray-300 rounded-lg"></iframe>
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
                </div>

                <!-- Kolom Kanan: Form Aksi -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm sticky top-24">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Aksi Verifikasi</h3>
                        </div>
                        
                        <!-- Info Jadwal Ruangan -->
                        <div class="p-6 border-b border-gray-100">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">📅 Cek Jadwal Ruangan</h4>
                            <div id="room-schedule" class="text-sm text-gray-600">
                                <p>Memuat jadwal ruangan...</p>
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('admin.peminjaman.update', $peminjaman->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="p-6 space-y-6">
                                <div>
                                    <label for="status" class="block mb-2 text-sm font-medium text-gray-700">Ubah
                                        Status</label>
                                    <select name="status" id="status"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                                        required>
                                        <option value="disetujui"
                                            {{ $peminjaman->status == 'disetujui' ? 'selected' : '' }}>Setujui</option>
                                        <option value="ditolak"
                                            {{ $peminjaman->status == 'ditolak' ? 'selected' : '' }}>Tolak</option>
                                        <option value="menunggu"
                                            {{ $peminjaman->status == 'menunggu' ? 'selected' : '' }}>Kembalikan ke
                                            Menunggu</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="catatan_admin"
                                        class="block mb-2 text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                                    <textarea name="catatan_admin" id="catatan_admin" rows="4"
                                        placeholder="Contoh: Kunci dapat diambil di sekretariat"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('catatan_admin', $peminjaman->catatan_admin) }}</textarea>
                                </div>
                            </div>
                            <div
                                class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-2xl flex items-center justify-end gap-4">
                                <a href="{{ route('admin.peminjaman.index') }}"
                                    class="font-medium text-sm text-gray-600 hover:text-gray-900">Kembali</a>
                                <button type="submit" id="submitBtn"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Proses Peminjaman
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const scheduleWarning = document.getElementById('schedule-warning');
                const conflictDetails = document.getElementById('conflict-details');
                const roomSchedule = document.getElementById('room-schedule');
                const statusSelect = document.getElementById('status');
                const submitBtn = document.getElementById('submitBtn');
                
                const peminjamanData = {
                    ruangan_id: {{ $peminjaman->ruangan_id }},
                    tanggal: '{{ $peminjaman->tanggal }}',
                    jam_mulai: '{{ $peminjaman->jam_mulai }}',
                    jam_selesai: '{{ $peminjaman->jam_selesai }}',
                    id: {{ $peminjaman->id }}
                };

                // Load room schedule and check for conflicts
                function checkScheduleConflict() {
                    fetch(`/peminjaman/availability?ruangan_id=${peminjamanData.ruangan_id}&tanggal=${peminjamanData.tanggal}`)
                        .then(response => response.json())
                        .then(events => {
                            updateRoomSchedule(events);
                            
                            // SIMPLIFIED CONFLICT CHECK: Check for any other booking on the same date
                            const conflicts = events.filter(event => {
                                // Skip current peminjaman
                                return event.id !== peminjamanData.id;
                            });
                            
                            if (conflicts.length > 0) {
                                showConflictWarning(conflicts);
                            } else {
                                hideConflictWarning();
                            }
                        })
                        .catch(error => {
                            console.error('Error checking schedule:', error);
                            roomSchedule.innerHTML = '<p class="text-red-500">Gagal memuat jadwal</p>';
                        });
                }

                function updateRoomSchedule(events) {
                    let html = '';
                    
                    if (events.length === 0) {
                        html = '<div class="text-green-600"><strong>✅ Tidak ada jadwal lain</strong><br><small>Ruangan kosong pada tanggal ini</small></div>';
                    } else {
                        html = '<div class="mb-2"><strong>Jadwal Ruangan pada Tanggal Ini:</strong></div>';
                        
                        events.forEach(event => {
                            const statusClass = event.status === 'disetujui' ? 'text-red-600' : 'text-yellow-600';
                            const statusIcon = event.status === 'disetujui' ? '🔒' : '⏳';
                            const statusText = event.status === 'disetujui' ? 'Disetujui' : 'Menunggu';
                            
                            html += `<div class="schedule-conflict mb-2">
                                <div class="${statusClass}">
                                    <strong>${statusIcon} ${event.start} - ${event.end} WIB</strong>
                                    <div class="text-xs mt-1">Status: ${statusText}</div>
                                    ${event.tujuan ? `<div class="text-xs text-gray-600">Tujuan: ${event.tujuan}</div>` : ''}
                                </div>
                            </div>`;
                        });
                        
                        html += '<div class="mt-3 p-2 bg-yellow-50 border border-yellow-200 rounded text-sm text-yellow-800">';
                        html += '<strong>⚠️ Perhatian:</strong> Ruangan sudah dipinjam pada tanggal ini. Hanya satu peminjaman per hari yang diizinkan.';
                        html += '</div>';
                    }
                    
                    roomSchedule.innerHTML = html;
                }

                function showConflictWarning(conflicts) {
                    let html = '<p class="mb-2">Ruangan sudah dipinjam pada tanggal ini:</p>';
                    
                    conflicts.forEach(conflict => {
                        const statusText = conflict.status === 'disetujui' ? 'Sudah Disetujui' : 'Menunggu Persetujuan';
                        const statusIcon = conflict.status === 'disetujui' ? '🔒' : '⏳';
                        
                        html += `<div class="schedule-conflict">
                            <strong>${statusIcon} ${conflict.start} - ${conflict.end} WIB</strong>
                            <div class="text-xs mt-1">Status: ${statusText}</div>
                            ${conflict.tujuan ? `<div class="text-xs text-gray-600">Tujuan: ${conflict.tujuan}</div>` : ''}
                        </div>`;
                    });
                    
                    html += '<div class="mt-3 p-2 bg-red-50 border border-red-200 rounded text-sm text-red-800">';
                    html += '<strong>🚫 Kebijakan:</strong> Hanya satu peminjaman per ruangan per hari yang diizinkan.';
                    html += '</div>';
                    
                    conflictDetails.innerHTML = html;
                    scheduleWarning.classList.remove('hidden');
                    
                    // Disable approval if there are any conflicts (approved or pending)
                    const hasAnyConflicts = conflicts.length > 0;
                    if (hasAnyConflicts) {
                        // Disable "disetujui" option
                        const approveOption = statusSelect.querySelector('option[value="disetujui"]');
                        if (approveOption) {
                            approveOption.disabled = true;
                            approveOption.textContent = 'Setujui (Tidak Tersedia - Ada Konflik)';
                        }
                        
                        // If currently selected, change to tolak
                        if (statusSelect.value === 'disetujui') {
                            statusSelect.value = 'ditolak';
                        }
                    }
                }

                function hideConflictWarning() {
                    scheduleWarning.classList.add('hidden');
                    
                    // Re-enable approval option
                    const approveOption = statusSelect.querySelector('option[value="disetujui"]');
                    if (approveOption) {
                        approveOption.disabled = false;
                        approveOption.textContent = 'Setujui';
                    }
                }

                // Monitor status changes
                statusSelect.addEventListener('change', function() {
                    if (this.value === 'disetujui') {
                        // Re-check conflicts when admin wants to approve
                        checkScheduleConflict();
                    }
                });

                // Initial load
                checkScheduleConflict();
            });
        </script>
    </x-slot>
</x-app-layout>