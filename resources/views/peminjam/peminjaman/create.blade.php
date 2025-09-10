{{--
    File: resources/views/peminjaman/create.blade.php

    Deskripsi:
    Tampilan untuk form pengajuan peminjaman ruangan. Didesain ulang
    dengan gaya modern, memisahkan form input dengan informasi ruangan
    dan kalender ketersediaan untuk pengalaman pengguna yang lebih baik.
--}}
<x-app-layout>
    {{-- Slot header di-nonaktifkan untuk integrasi judul yang lebih baik --}}

    {{-- FullCalendar CSS --}}
    <x-slot name="styles">
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
        <style>
            .unavailable-slot {
                background-color: #fee2e2;
                border-left: 4px solid #ef4444;
                padding: 12px;
                margin: 6px 0;
                border-radius: 8px;
                font-size: 0.875rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }
            .pending-slot {
                background-color: #fef3c7;
                border-left: 4px solid #f59e0b;
                padding: 12px;
                margin: 6px 0;
                border-radius: 8px;
                font-size: 0.875rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }
            .available-info {
                background-color: #dcfce7;
                border-left: 4px solid #22c55e;
                padding: 12px;
                margin: 6px 0;
                border-radius: 8px;
                font-size: 0.875rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }
            .time-slot-indicator {
                display: inline-block;
                width: 12px;
                height: 12px;
                border-radius: 50%;
                margin-right: 8px;
            }
            .conflict-warning {
                animation: pulse 2s infinite;
                background-color: #fef2f2;
                border: 2px solid #f87171;
                border-radius: 8px;
                padding: 12px;
            }
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.8; }
            }
            .time-picker-container {
                position: relative;
            }
            .time-suggestion {
                background-color: #f0f9ff;
                border: 1px solid #0ea5e9;
                border-radius: 6px;
                padding: 8px 12px;
                margin: 4px 0;
                cursor: pointer;
                transition: all 0.2s;
                font-size: 0.875rem;
            }
            .time-suggestion:hover {
                background-color: #0ea5e9;
                color: white;
            }
            .occupied-dates-list {
                max-height: 300px;
                overflow-y: auto;
            }
            .date-item {
                padding: 8px 12px;
                border-radius: 6px;
                margin: 4px 0;
                border-left: 4px solid;
                font-size: 0.875rem;
            }
            .date-approved {
                background-color: #fee2e2;
                border-left-color: #ef4444;
            }
            .date-pending {
                background-color: #fef3c7;
                border-left-color: #f59e0b;
            }
        </style>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('peminjaman.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ruangan_id" value="{{ $ruangan->id }}">

                <!-- Header Halaman -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Ajukan Peminjaman Ruangan</h1>
                    <p class="mt-1 text-sm text-gray-500">Isi formulir di bawah untuk mengajukan peminjaman.</p>
                </div>

                <!-- Notifikasi Error Global -->
                @if ($errors->has('conflict'))
                    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm conflict-warning"
                        role="alert">
                        <p class="font-bold">🚫 Jadwal Konflik</p>
                        <p>{{ $errors->first('conflict') }}</p>
                    </div>
                @endif

                <!-- Layout Grid Utama -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Kolom Kiri: Form Input -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-4 mb-6">Detail
                                Pengajuan</h3>

                            <!-- Jadwal -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-1">
                                    <label for="tanggal"
                                        class="block text-sm font-medium text-gray-700 mb-2">Tanggal Peminjaman</label>
                                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                        required>
                                    @error('tanggal')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="md:col-span-1 time-picker-container">
                                    <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-2">Jam
                                        Mulai</label>
                                    <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                        min="07:00" max="22:00" step="900" required>
                                    @error('jam_mulai')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="md:col-span-1 time-picker-container">
                                    <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-2">Jam
                                        Selesai</label>
                                    <input type="time" id="jam_selesai" name="jam_selesai"
                                        value="{{ old('jam_selesai') }}"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                        min="07:00" max="22:00" step="900" required>
                                    @error('jam_selesai')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Peringatan Konflik -->
                            <div id="warning" class="mt-4 text-red-600 text-sm hidden conflict-warning">
                                <p><strong>Perhatian:</strong> Jam yang Anda pilih sudah terpakai atau tumpang tindih
                                    dengan jadwal lain.</p>
                            </div>

                            <!-- Saran Waktu Tersedia -->
                            <div id="time-suggestions" class="mt-4 hidden">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">💡 Saran Waktu Tersedia:</h4>
                                <div id="suggestions-container" class="space-y-2"></div>
                            </div>

                            <!-- Tujuan -->
                            <div class="mt-6">
                                <label for="tujuan" class="block text-sm font-medium text-gray-700 mb-2">Tujuan
                                    Peminjaman</label>
                                <input type="text" id="tujuan" name="tujuan" value="{{ old('tujuan') }}"
                                    placeholder="Contoh: Rapat Himpunan Mahasiswa"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                    required>
                                @error('tujuan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Upload Dokumen -->
                            <div class="mt-6">
                                <label for="dokumen" class="block text-sm font-medium text-gray-700 mb-2">Upload Surat
                                    Permohonan <span class="text-gray-400">(Opsional, PDF)</span></label>
                                <input type="file" id="dokumen" name="dokumen" accept="application/pdf"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                @error('dokumen')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Informasi Jadwal yang Tidak Tersedia -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-4 mb-4">
                                <i class="fas fa-clock mr-2"></i>Status Ketersediaan Waktu
                            </h3>
                            <div id="availability-info">
                                <p class="text-gray-500 text-sm">Pilih tanggal untuk melihat jadwal yang tidak tersedia</p>
                            </div>
                        </div>

                        <!-- Daftar Tanggal yang Sudah Dipinjam -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-4 mb-4">
                                <i class="fas fa-calendar-times mr-2"></i>Daftar Tanggal yang Sudah Dipinjam
                            </h3>
                            <div id="occupied-dates" class="occupied-dates-list">
                                <p class="text-gray-500 text-sm">Memuat data...</p>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="bg-white p-4 rounded-2xl shadow-sm flex justify-end items-center">
                            <a href="{{ route('katalog.index') }}"
                                class="font-semibold text-gray-600 hover:text-gray-800 mr-4">Batal</a>
                            <button id="submitBtn" type="submit"
                                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-paper-plane mr-1"></i>
                                Kirim Pengajuan
                            </button>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Info & Kalender -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Informasi Ruangan -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-4 mb-4">Informasi
                                Ruangan</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Nama Ruangan</label>
                                    <p class="text-gray-800 font-semibold">{{ $ruangan->nama }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Gedung</label>
                                    <p class="text-gray-800">{{ $ruangan->gedung->nama }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Kapasitas</label>
                                    <p class="text-gray-800">{{ $ruangan->kapasitas }} orang</p>
                                </div>
                            </div>
                        </div>

                        <!-- Kalender -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Jadwal Ketersediaan</h3>
                            <div id="calendar" class="border rounded-lg shadow-inner p-2 bg-gray-50"></div>
                            <div class="text-xs text-gray-500 mt-3">
                                <div class="flex items-center mb-1">
                                    <span class="time-slot-indicator bg-red-500"></span>
                                    <span>Sudah Disetujui (Tidak Tersedia)</span>
                                </div>
                                <div class="flex items-center mb-1">
                                    <span class="time-slot-indicator bg-yellow-400"></span>
                                    <span>Menunggu Persetujuan</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="time-slot-indicator bg-green-500"></span>
                                    <span>Tersedia</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- FullCalendar JS --}}
    <x-slot name="scripts">
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('calendar');
                const submitBtn = document.getElementById('submitBtn');
                const warningEl = document.getElementById('warning');
                const availabilityInfo = document.getElementById('availability-info');
                const occupiedDates = document.getElementById('occupied-dates');
                const timeSuggestions = document.getElementById('time-suggestions');
                const suggestionsContainer = document.getElementById('suggestions-container');
                const tanggalInput = document.getElementById('tanggal');
                const jamMulaiInput = document.getElementById('jam_mulai');
                const jamSelesaiInput = document.getElementById('jam_selesai');
                let existingEvents = [];
                let currentDateEvents = [];
                let allOccupiedDates = [];

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridDay',
                    headerToolbar: {
                        left: '',
                        center: 'title',
                        right: ''
                    },
                    slotMinTime: '07:00:00',
                    slotMaxTime: '22:00:00',
                    allDaySlot: false,
                    height: 'auto',
                    selectable: false,
                    events: function(fetchInfo, successCallback, failureCallback) {
                        const selectedDate = tanggalInput.value;
                        if (!selectedDate) {
                            successCallback([]);
                            updateAvailabilityInfo([]);
                            return;
                        }

                        fetch(
                                `/peminjaman/availability?ruangan_id={{ $ruangan->id }}&tanggal=${selectedDate}`)
                            .then(response => response.json())
                            .then(events => {
                                currentDateEvents = events;
                                existingEvents = events.map(e => ({
                                    start: new Date(`${selectedDate}T${e.start}`),
                                    end: new Date(`${selectedDate}T${e.end}`),
                                    status: e.status
                                }));

                                const formatted = events.map(e => ({
                                    title: e.status === 'disetujui' ? 'Tidak Tersedia' : 'Menunggu Persetujuan',
                                    start: `${selectedDate}T${e.start}`,
                                    end: `${selectedDate}T${e.end}`,
                                    backgroundColor: e.status === 'disetujui' ? '#ef4444' : '#facc15',
                                    borderColor: e.status === 'disetujui' ? '#dc2626' : '#eab308',
                                    textColor: '#ffffff'
                                }));
                                
                                updateAvailabilityInfo(events);
                                successCallback(formatted);
                                checkConflict();
                            })
                            .catch(failureCallback);
                    },
                    dateSet: function(dateInfo) {
                        const newDate = dateInfo.view.currentStart.toISOString().slice(0, 10);
                        if (tanggalInput.value !== newDate) {
                            tanggalInput.value = newDate;
                            calendar.refetchEvents();
                        }
                    }
                });
                calendar.render();

                // Load all occupied dates for this room
                function loadAllOccupiedDates() {
                    fetch(`/peminjaman/occupied-dates?ruangan_id={{ $ruangan->id }}`)
                        .then(response => response.json())
                        .then(data => {
                            allOccupiedDates = data;
                            updateOccupiedDatesList();
                        })
                        .catch(error => {
                            console.error('Error loading occupied dates:', error);
                            occupiedDates.innerHTML = '<p class="text-red-500 text-sm">Gagal memuat data</p>';
                        });
                }

                function updateOccupiedDatesList() {
                    let html = '';
                    
                    if (allOccupiedDates.length === 0) {
                        html = '<div class="available-info"><strong>✅ Belum ada peminjaman yang disetujui</strong><br><small>Ruangan masih kosong untuk semua tanggal</small></div>';
                    } else {
                        // Group by date
                        const groupedByDate = {};
                        allOccupiedDates.forEach(item => {
                            if (!groupedByDate[item.tanggal]) {
                                groupedByDate[item.tanggal] = [];
                            }
                            groupedByDate[item.tanggal].push(item);
                        });

                        html = '<div class="mb-3"><strong>📅 Jadwal Peminjaman yang Sudah Ada:</strong></div>';
                        
                        Object.keys(groupedByDate).sort().forEach(date => {
                            const dateEvents = groupedByDate[date];
                            const formattedDate = new Date(date).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                            
                            html += `<div class="mb-3">
                                <h4 class="font-semibold text-gray-700 mb-2">${formattedDate}</h4>`;
                            
                            dateEvents.forEach(event => {
                                const statusClass = event.status === 'disetujui' ? 'date-approved' : 'date-pending';
                                const statusText = event.status === 'disetujui' ? 'Disetujui' : 'Menunggu';
                                const statusIcon = event.status === 'disetujui' ? '🔒' : '⏳';
                                
                                html += `<div class="date-item ${statusClass}">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <strong>${statusIcon} ${event.jam_mulai} - ${event.jam_selesai} WIB</strong>
                                            <div class="text-xs mt-1">Status: ${statusText}</div>
                                            <div class="text-xs text-gray-600">Tujuan: ${event.tujuan}</div>
                                        </div>
                                    </div>
                                </div>`;
                            });
                            
                            html += '</div>';
                        });
                    }
                    
                    occupiedDates.innerHTML = html;
                }

                function updateAvailabilityInfo(events) {
                    let html = '';
                    
                    if (events.length === 0) {
                        html = '<div class="available-info"><strong>✅ Ruangan tersedia sepanjang hari</strong><br><small>Anda dapat memilih waktu dari 07:00 - 22:00 WIB</small></div>';
                    } else {
                        html = '<div class="mb-3"><strong>📅 Jadwal yang Tidak Tersedia:</strong></div>';
                        
                        // Grup berdasarkan status
                        const approvedEvents = events.filter(e => e.status === 'disetujui');
                        const pendingEvents = events.filter(e => e.status === 'menunggu');
                        
                        if (approvedEvents.length > 0) {
                            html += '<div class="mb-2"><strong>🔒 Sudah Disetujui (Tidak Bisa Dipilih):</strong></div>';
                            approvedEvents.forEach(event => {
                                html += `<div class="unavailable-slot">
                                    <strong>${event.start} - ${event.end} WIB</strong>
                                    <div class="text-xs text-red-600 mt-1">Ruangan sudah dipinjam pada waktu ini</div>
                                </div>`;
                            });
                        }
                        
                        if (pendingEvents.length > 0) {
                            html += '<div class="mb-2 mt-3"><strong>⏳ Menunggu Persetujuan:</strong></div>';
                            pendingEvents.forEach(event => {
                                html += `<div class="pending-slot">
                                    <strong>${event.start} - ${event.end} WIB</strong>
                                    <div class="text-xs text-yellow-700 mt-1">Peminjaman sedang diproses admin</div>
                                </div>`;
                            });
                        }
                        
                        // Tampilkan waktu yang tersedia
                        const availableSlots = getAvailableTimeSlots(events);
                        if (availableSlots.length > 0) {
                            html += '<div class="mb-2 mt-3"><strong>✅ Waktu Tersedia:</strong></div>';
                            availableSlots.forEach(slot => {
                                html += `<div class="available-info">
                                    <strong>${slot.start} - ${slot.end} WIB</strong>
                                    <div class="text-xs text-green-700 mt-1">Waktu ini dapat dipilih</div>
                                </div>`;
                            });
                        }
                    }
                    
                    availabilityInfo.innerHTML = html;
                    updateTimeSuggestions(events);
                }

                function updateTimeSuggestions(events) {
                    const availableSlots = getAvailableTimeSlots(events);
                    
                    if (availableSlots.length === 0) {
                        timeSuggestions.classList.add('hidden');
                        return;
                    }
                    
                    let html = '';
                    availableSlots.forEach(slot => {
                        html += `<div class="time-suggestion" data-start="${slot.start}" data-end="${slot.end}">
                            <strong>${slot.start} - ${slot.end} WIB</strong>
                            <div class="text-xs mt-1">Klik untuk menggunakan waktu ini</div>
                        </div>`;
                    });
                    
                    suggestionsContainer.innerHTML = html;
                    timeSuggestions.classList.remove('hidden');
                    
                    // Add click handlers to suggestions
                    document.querySelectorAll('.time-suggestion').forEach(suggestion => {
                        suggestion.addEventListener('click', function() {
                            jamMulaiInput.value = this.dataset.start;
                            jamSelesaiInput.value = this.dataset.end;
                            checkConflict();
                        });
                    });
                }

                function getAvailableTimeSlots(events) {
                    const slots = [];
                    const startHour = 7; // 07:00
                    const endHour = 22; // 22:00
                    
                    // Sort events by start time
                    const sortedEvents = events.sort((a, b) => a.start.localeCompare(b.start));
                    
                    let currentTime = `${startHour.toString().padStart(2, '0')}:00`;
                    
                    sortedEvents.forEach(event => {
                        if (currentTime < event.start) {
                            // Only add slots that are at least 1 hour long
                            const startMinutes = timeToMinutes(currentTime);
                            const endMinutes = timeToMinutes(event.start);
                            if (endMinutes - startMinutes >= 60) {
                                slots.push({
                                    start: currentTime,
                                    end: event.start
                                });
                            }
                        }
                        currentTime = event.end > currentTime ? event.end : currentTime;
                    });
                    
                    // Check if there's time after the last event
                    if (currentTime < `${endHour}:00`) {
                        const startMinutes = timeToMinutes(currentTime);
                        const endMinutes = timeToMinutes(`${endHour}:00`);
                        if (endMinutes - startMinutes >= 60) {
                            slots.push({
                                start: currentTime,
                                end: `${endHour}:00`
                            });
                        }
                    }
                    
                    return slots;
                }

                function timeToMinutes(time) {
                    const [hours, minutes] = time.split(':').map(Number);
                    return hours * 60 + minutes;
                }

                function isTimeConflict(start, end) {
                    return existingEvents.some(event =>
                        (start >= event.start && start < event.end) ||
                        (end > event.start && end <= event.end) ||
                        (start <= event.start && end >= event.end)
                    );
                }

                function checkConflict() {
                    const tanggal = tanggalInput.value;
                    const jamMulai = jamMulaiInput.value;
                    const jamSelesai = jamSelesaiInput.value;

                    if (!tanggal || !jamMulai || !jamSelesai) {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
                        warningEl.classList.add('hidden');
                        return;
                    }

                    if (jamSelesai <= jamMulai) {
                        warningEl.innerHTML =
                            "<p><strong>⚠️ Perhatian:</strong> Jam selesai tidak boleh sebelum atau sama dengan jam mulai.</p>";
                        warningEl.classList.remove('hidden');
                        submitBtn.disabled = true;
                        submitBtn.classList.add('disabled:opacity-50', 'disabled:cursor-not-allowed');
                        return;
                    }

                    const startTime = new Date(`${tanggal}T${jamMulai}`);
                    const endTime = new Date(`${tanggal}T${jamSelesai}`);
                    const conflict = isTimeConflict(startTime, endTime);

                    submitBtn.disabled = conflict;
                    if (conflict) {
                        // Find conflicting event details
                        const conflictingEvent = existingEvents.find(event =>
                            (startTime >= event.start && startTime < event.end) ||
                            (endTime > event.start && endTime <= event.end) ||
                            (startTime <= event.start && endTime >= event.end)
                        );
                        
                        const conflictType = conflictingEvent.status === 'disetujui' ? 'sudah disetujui' : 'sedang menunggu persetujuan';
                        const conflictStart = conflictingEvent.start.toTimeString().slice(0, 5);
                        const conflictEnd = conflictingEvent.end.toTimeString().slice(0, 5);
                        
                        warningEl.innerHTML =
                            `<p><strong>🚫 Jadwal Bentrok!</strong> Waktu ${jamMulai}-${jamSelesai} bentrok dengan peminjaman yang ${conflictType} (${conflictStart}-${conflictEnd} WIB). Silakan pilih waktu lain dari saran di bawah.</p>`;
                        warningEl.classList.remove('hidden');
                        submitBtn.classList.add('disabled:opacity-50', 'disabled:cursor-not-allowed');
                    } else {
                        warningEl.classList.add('hidden');
                        submitBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
                    }
                }

                jamMulaiInput.addEventListener('change', checkConflict);
                jamSelesaiInput.addEventListener('change', checkConflict);
                tanggalInput.addEventListener('change', function() {
                    if (this.value) {
                        calendar.gotoDate(this.value);
                        calendar.refetchEvents();
                    }
                });

                // Set default date to today
                const today = new Date().toISOString().slice(0, 10);
                tanggalInput.value = today;
                calendar.gotoDate(today);
                calendar.refetchEvents();
                
                // Load all occupied dates on page load
                loadAllOccupiedDates();
            });
        </script>
    </x-slot>
</x-app-layout>