<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use App\Models\Gedung;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\ConflictDetectionService;
use App\Services\PeminjamanService;
use App\Http\Requests\StorePeminjamanRequest;
use App\Traits\RespondsWithFlashMessages;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class PeminjamanController extends Controller
{
    use RespondsWithFlashMessages;

    protected $peminjamanService;
    protected $conflictService;

    public function __construct(
        PeminjamanService $peminjamanService,
        ConflictDetectionService $conflictService
    ) {
        $this->peminjamanService = $peminjamanService;
        $this->conflictService = $conflictService;
    }

    public function katalog()
    {
        $gedungs = Gedung::with('ruangans')->get();
        return view('peminjam.katalog.index', compact('gedungs'));
    }

    public function index()
    {
        $peminjamans = Peminjaman::with('ruangan')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10); // atau sesuaikan jumlah item per halaman


        return view('peminjam.peminjaman.index', compact('peminjamans'));
    }
    public function show(Peminjaman $peminjaman)
    {
        // Pastikan user hanya bisa lihat miliknya
        if ($peminjaman->user_id !== Auth::id()) {
            abort(403);
        }

        return view('peminjam.peminjaman.show', compact('peminjaman'));
    }


    /**
     * Terima ruangan_id dari katalog, agar form langsung terkunci untuk ruangan tsb.
     */
    public function create(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
        ]);

        $ruangan = Ruangan::with('gedung')->findOrFail($request->ruangan_id);

        return view('peminjam.peminjaman.create', compact('ruangan'));
    }

    public function store(StorePeminjamanRequest $request)
    {
        // Log untuk debugging
        Log::info('Store Peminjaman - Request Data:', $request->all());

        // Validation handled by StorePeminjamanRequest
        $validated = $request->validated();

        Log::info('Store Peminjaman - Validated Data:', $validated);

        // Use ConflictDetectionService for consistent conflict checking
        if ($this->conflictService->checkDailyConflict($validated['ruangan_id'], $validated['tanggal'])) {
            Log::warning('Store Peminjaman - Conflict detected');
            return $this->respondWithConflict(
                'Ruangan sudah dipinjam pada tanggal yang dipilih. Silakan pilih tanggal lain.'
            );
        }

        if ($request->hasFile('dokumen')) {
            $validated['dokumen'] = $request->file('dokumen')->store('dokumen', 'public');
            Log::info('Store Peminjaman - Dokumen uploaded:', ['path' => $validated['dokumen']]);
        }

        try {
            // Use PeminjamanService for consistent business logic
            $peminjaman = $this->peminjamanService->createPeminjaman($validated);

            Log::info('Store Peminjaman - Success:', ['id' => $peminjaman->id]);

            return $this->respondWithSuccess(
                'Pengajuan peminjaman berhasil dikirim. Mohon tunggu persetujuan dari admin.',
                'peminjaman.index'
            );
        } catch (\Exception $e) {
            Log::error('Store Peminjaman - Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->respondWithError(
                'Terjadi kesalahan: ' . $e->getMessage(),
                withInput: true
            );
        }
    }

    /**
     * (Opsional) Endpoint untuk kalender – mengembalikan jadwal ruangan dalam bentuk JSON.
     */
    public function availability(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'tanggal'    => 'required|date',
        ]);

        // Simplified: Return all bookings for the date without time filtering
        $events = Peminjaman::where('ruangan_id', $request->ruangan_id)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->get(['id', 'jam_mulai as start', 'jam_selesai as end', 'status', 'tujuan', 'user_id']);

        return response()->json($events);
    }
    public function cancel(Request $request, Peminjaman $peminjaman)
    {
        // Authorization: Only owner can cancel
        if ($peminjaman->user_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk membatalkan peminjaman ini.');
        }

        // Business rule: Can only cancel pending bookings
        if ($peminjaman->status !== 'menunggu') {
            return $this->respondWithError(
                'Peminjaman tidak bisa dibatalkan karena sudah diproses.'
            );
        }

        // Business rule: Cannot cancel past bookings
        if ($peminjaman->is_past) {
            return $this->respondWithError(
                'Peminjaman tidak bisa dibatalkan karena tanggal sudah lewat.'
            );
        }

        // Validate cancellation reason (optional)
        $validated = $request->validate([
            'alasan' => 'nullable|string|max:500'
        ]);

        // Update status and add cancellation tracking
        $peminjaman->update([
            'status' => 'dibatalkan',
            'cancelled_by' => Auth::id(),
            'cancelled_at' => now(),
            'cancellation_reason' => $validated['alasan'] ?? 'Dibatalkan oleh peminjam'
        ]);

        // Soft delete for audit trail
        $peminjaman->delete();

        return $this->respondWithSuccess(
            'Peminjaman berhasil dibatalkan. Anda dapat mengajukan peminjaman baru.'
        );
    }
    /**
     * Get all occupied dates for a specific room
     */
    public function occupiedDates(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
        ]);

        $occupiedDates = Peminjaman::where('ruangan_id', $request->ruangan_id)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get(['tanggal', 'jam_mulai', 'jam_selesai', 'status', 'tujuan']);

        return response()->json($occupiedDates);
    }

    /**
     * Check conflict for a specific date and room
     */
    public function checkConflict(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'tanggal' => 'required|date',
            'exclude_id' => 'nullable|exists:peminjamans,id'
        ]);

        $conflictService = app(ConflictDetectionService::class);
        $availability = $conflictService->checkAvailability(
            $request->ruangan_id,
            $request->tanggal
        );

        return response()->json($availability);
    }

    /**
     * Suggest alternative dates for a room
     */
    public function suggestDates(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'start_date' => 'required|date',
            'days' => 'nullable|integer|min:1|max:30'
        ]);

        $conflictService = app(ConflictDetectionService::class);
        $suggestions = $conflictService->suggestAlternativeDates(
            $request->ruangan_id,
            $request->start_date,
            $request->get('days', 7)
        );

        return response()->json([
            'suggestions' => $suggestions,
            'total_available' => count($suggestions)
        ]);
    }

    /**
     * Get room booking summary
     */
    public function roomSummary(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $conflictService = app(ConflictDetectionService::class);
        $summary = $conflictService->getConflictSummary(
            $request->ruangan_id,
            $request->start_date,
            $request->end_date
        );

        return response()->json($summary);
    }

    /**
     * Download PDF proof for approved booking
     */
    public function downloadPdf(Peminjaman $peminjaman)
    {
        // Authorization check - only booking owner can download
        if ($peminjaman->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh bukti peminjaman ini.');
        }

        // Only allow PDF download for approved bookings
        if ($peminjaman->status !== 'disetujui') {
            return $this->respondWithError(
                'Bukti peminjaman hanya tersedia untuk peminjaman yang telah disetujui.'
            );
        }

        try {
            // Check if PDF view exists
            if (!View::exists('pdf.booking-proof')) {
                Log::error('PDF template not found', [
                    'peminjaman_id' => $peminjaman->id,
                    'user_id' => Auth::id(),
                    'template' => 'pdf.booking-proof'
                ]);

                return $this->respondWithError(
                    'Template PDF tidak ditemukan. Silakan hubungi administrator.'
                );
            }

            // Load booking with relationships for PDF
            $peminjaman->load(['user', 'ruangan.gedung']);

            // Validate required relationships exist
            if (!$peminjaman->user) {
                throw new \Exception('Data pengguna tidak ditemukan');
            }

            if (!$peminjaman->ruangan) {
                throw new \Exception('Data ruangan tidak ditemukan');
            }

            if (!$peminjaman->ruangan->gedung) {
                throw new \Exception('Data gedung tidak ditemukan');
            }

            // Generate PDF from view
            $pdf = Pdf::loadView('pdf.booking-proof', compact('peminjaman'))
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isPhpEnabled' => true,
                    'defaultFont' => 'Arial',
                    'isRemoteEnabled' => true,
                ]);

            // Generate filename with booking details
            $filename = sprintf(
                'Bukti_Peminjaman_%s_%s_%s.pdf',
                str_replace(' ', '_', $peminjaman->ruangan->nama),
                $peminjaman->tanggal->format('Y-m-d'),
                str_replace(':', '', $peminjaman->jam_mulai)
            );

            // Log successful PDF generation
            Log::info('PDF generated successfully', [
                'peminjaman_id' => $peminjaman->id,
                'user_id' => Auth::id(),
                'filename' => $filename
            ]);

            // Return PDF download
            return $pdf->download($filename);
        } catch (\Exception $e) {
            // Log detailed error
            Log::error('PDF generation failed', [
                'peminjaman_id' => $peminjaman->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // User-friendly error message
            $errorMessage = 'Terjadi kesalahan saat membuat bukti peminjaman. Silakan coba lagi atau hubungi administrator.';

            // Add technical details in development environment
            if (config('app.debug')) {
                $errorMessage .= ' Error: ' . $e->getMessage();
            }

            return $this->respondWithError($errorMessage);
        }
    }
}
