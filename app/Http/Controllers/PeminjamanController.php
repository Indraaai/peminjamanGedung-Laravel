<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use App\Models\Gedung;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ruangan_id'   => 'required|exists:ruangans,id',
            'tanggal'      => 'required|date|after_or_equal:today',
            'jam_mulai'    => 'required',
            'jam_selesai'  => 'required|after:jam_mulai',
            'tujuan'       => 'required|string|max:255',
            'dokumen'      => 'nullable|mimes:pdf|max:2048',
        ]);

        // SIMPLIFIED CONFLICT CHECK: Daily-based instead of time-based
        $conflict = Peminjaman::where('ruangan_id', $validated['ruangan_id'])
            ->where('tanggal', $validated['tanggal'])
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->exists();

        if ($conflict) {
            return back()
                ->withErrors(['conflict' => 'Ruangan sudah dipinjam pada tanggal yang dipilih. Silakan pilih tanggal lain.'])
                ->withInput();
        }

        if ($request->hasFile('dokumen')) {
            $validated['dokumen'] = $request->file('dokumen')->store('dokumen', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['status']  = 'menunggu';

        Peminjaman::create($validated);

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
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
    public function cancel(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id != Auth::id()) {
            abort(403); // Hanya pemilik peminjaman yang bisa membatalkan
        }

        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Peminjaman tidak bisa dibatalkan karena sudah diproses.');
        }

        $peminjaman->delete(); // Atau ->update(['status' => 'dibatalkan']) jika ingin riwayat tetap ada

        return back()->with('success', 'Peminjaman berhasil dibatalkan.');
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
            return back()->with('error', 'Bukti peminjaman hanya tersedia untuk peminjaman yang telah disetujui.');
        }

        try {
            // Load booking with relationships for PDF
            $peminjaman->load(['user', 'ruangan.gedung']);
            
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
            $filename = 'Bukti_Peminjaman_' . 
                        str_replace(' ', '_', $peminjaman->ruangan->nama) . '_' . 
                        $peminjaman->tanggal->format('Y-m-d') . '_' . 
                        str_replace(':', '', $peminjaman->jam_mulai) . '.pdf';

            // Return PDF download
            return $pdf->download($filename);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat membuat bukti peminjaman. Silakan coba lagi.');
        }
    }
}
