// resources/js/peminjaman-calendar.js
/**
 * Peminjaman Calendar & Conflict Detection Module
 * Handles real-time booking conflict checking and date suggestions
 */

export class PeminjamanCalendar {
    constructor(options = {}) {
        this.ruanganId = options.ruanganId;
        this.tanggalInput = options.tanggalInput || document.getElementById('tanggal');
        this.jamMulaiInput = options.jamMulaiInput || document.getElementById('jam_mulai');
        this.jamSelesaiInput = options.jamSelesaiInput || document.getElementById('jam_selesai');
        this.conflictWarning = options.conflictWarning || document.getElementById('conflict-warning');
        this.suggestionContainer = options.suggestionContainer || document.getElementById('date-suggestions');

        this.init();
    }

    init() {
        if (!this.ruanganId) {
            console.warn('PeminjamanCalendar: ruanganId is required');
            return;
        }

        this.bindEvents();
    }

    bindEvents() {
        // Check conflict when date changes
        if (this.tanggalInput) {
            this.tanggalInput.addEventListener('change', () => {
                this.checkConflict();
            });
        }

        // Check conflict when time changes
        if (this.jamMulaiInput) {
            this.jamMulaiInput.addEventListener('change', () => {
                this.checkConflict();
            });
        }

        if (this.jamSelesaiInput) {
            this.jamSelesaiInput.addEventListener('change', () => {
                this.checkConflict();
            });
        }
    }

    /**
     * Check if selected date/time has conflict
     */
    async checkConflict() {
        const tanggal = this.tanggalInput?.value;

        if (!tanggal) {
            this.hideConflictWarning();
            return;
        }

        try {
            const url = `/peminjaman/check-conflict?ruangan_id=${this.ruanganId}&tanggal=${tanggal}`;
            const response = await fetch(url);
            const data = await response.json();

            if (!data.available) {
                this.showConflictWarning(data);
                this.suggestAlternativeDates(tanggal);
            } else {
                this.hideConflictWarning();
                this.hideSuggestions();
            }
        } catch (error) {
            console.error('Error checking conflict:', error);
        }
    }

    /**
     * Show conflict warning
     */
    showConflictWarning(data) {
        if (!this.conflictWarning) return;

        let message = `
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            🚫 Ruangan Tidak Tersedia
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>Ruangan sudah dipinjam pada tanggal ini.</p>
                            ${data.conflicts && data.conflicts.length > 0 ? `
                                <p class="mt-2 font-semibold">Detail Peminjaman:</p>
                                <ul class="list-disc list-inside mt-1">
                                    ${data.conflicts.map(c => `
                                        <li>Status: ${c.status === 'disetujui' ? '✅ Disetujui' : '⏳ Menunggu'}</li>
                                    `).join('')}
                                </ul>
                            ` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;

        this.conflictWarning.innerHTML = message;
        this.conflictWarning.classList.remove('hidden');
    }

    /**
     * Hide conflict warning
     */
    hideConflictWarning() {
        if (!this.conflictWarning) return;
        this.conflictWarning.classList.add('hidden');
    }

    /**
     * Suggest alternative dates
     */
    async suggestAlternativeDates(startDate) {
        if (!this.suggestionContainer) return;

        try {
            const url = `/peminjaman/suggest-dates?ruangan_id=${this.ruanganId}&start_date=${startDate}&days=7`;
            const response = await fetch(url);
            const data = await response.json();

            if (data.suggestions && data.suggestions.length > 0) {
                this.showSuggestions(data.suggestions);
            } else {
                this.showNoSuggestions();
            }
        } catch (error) {
            console.error('Error getting suggestions:', error);
        }
    }

    /**
     * Show date suggestions
     */
    showSuggestions(suggestions) {
        if (!this.suggestionContainer) return;

        let html = `
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mt-4">
                <h4 class="text-sm font-medium text-blue-800 mb-3">
                    💡 Tanggal Alternatif yang Tersedia:
                </h4>
                <div class="space-y-2">
                    ${suggestions.map(s => `
                        <button
                            type="button"
                            class="w-full text-left px-3 py-2 bg-white border border-blue-200 rounded hover:bg-blue-100 transition text-sm"
                            onclick="document.getElementById('tanggal').value='${s.date}'; this.closest('.bg-blue-50').remove();"
                        >
                            <span class="font-semibold text-blue-900">${s.formatted}</span>
                            <span class="text-blue-600 ml-2">(${s.day_name})</span>
                        </button>
                    `).join('')}
                </div>
            </div>
        `;

        this.suggestionContainer.innerHTML = html;
        this.suggestionContainer.classList.remove('hidden');
    }

    /**
     * Show no suggestions message
     */
    showNoSuggestions() {
        if (!this.suggestionContainer) return;

        let html = `
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded mt-4">
                <p class="text-sm text-yellow-800">
                    ⚠️ Tidak ada tanggal alternatif tersedia dalam 7 hari ke depan.
                    Silakan pilih tanggal yang lebih jauh.
                </p>
            </div>
        `;

        this.suggestionContainer.innerHTML = html;
        this.suggestionContainer.classList.remove('hidden');
    }

    /**
     * Hide suggestions
     */
    hideSuggestions() {
        if (!this.suggestionContainer) return;
        this.suggestionContainer.classList.add('hidden');
    }

    /**
     * Get room summary for date range
     */
    async getRoomSummary(startDate, endDate) {
        try {
            const url = `/peminjaman/room-summary?ruangan_id=${this.ruanganId}&start_date=${startDate}&end_date=${endDate}`;
            const response = await fetch(url);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error getting room summary:', error);
            return null;
        }
    }

    /**
     * Display room summary
     */
    displayRoomSummary(summary, container) {
        if (!summary || !container) return;

        let html = `
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 mb-3">📊 Ringkasan Ketersediaan Ruangan</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-3 bg-gray-50 rounded">
                        <div class="text-2xl font-bold text-gray-900">${summary.total_days}</div>
                        <div class="text-xs text-gray-600">Hari Terpakai</div>
                    </div>
                    <div class="text-center p-3 bg-green-50 rounded">
                        <div class="text-2xl font-bold text-green-600">${summary.available_days}</div>
                        <div class="text-xs text-gray-600">Hari Tersedia</div>
                    </div>
                    <div class="text-center p-3 bg-blue-50 rounded">
                        <div class="text-2xl font-bold text-blue-600">${summary.approved_days}</div>
                        <div class="text-xs text-gray-600">Disetujui</div>
                    </div>
                    <div class="text-center p-3 bg-yellow-50 rounded">
                        <div class="text-2xl font-bold text-yellow-600">${summary.pending_days}</div>
                        <div class="text-xs text-gray-600">Menunggu</div>
                    </div>
                </div>
            </div>
        `;

        container.innerHTML = html;
    }
}

// Export for use in other modules
export default PeminjamanCalendar;
