<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\RespondsWithFlashMessages;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class SatpamPeminjamanController extends Controller
{
    use RespondsWithFlashMessages;
    /**
     * Tampilkan semua peminjaman yang sudah disetujui.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::where('status', 'disetujui');

        // Filter pencarian nama user atau nama ruangan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($qr) use ($search) {
                    $qr->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('ruangan', function ($qr) use ($search) {
                        $qr->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        // Filter berdasarkan tanggal (misalnya kolom "tanggal_peminjaman")
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_peminjaman', $request->tanggal);
        }

        $peminjaman = $query->paginate(5)->appends($request->all());

        return view('satpam.peminjaman.index', compact('peminjaman'));
    }



    /**
     * Detail 1 peminjaman.
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::where('status', 'disetujui')->findOrFail($id);

        return view('satpam.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Download PDF 1 peminjaman.
     */
    public function downloadPdf($id)
    {
        try {
            // Find approved booking only
            $peminjaman = Peminjaman::where('status', 'disetujui')->findOrFail($id);

            // Check if view exists
            if (!View::exists('satpam.peminjaman.pdf')) {
                Log::error('Satpam PDF template not found', [
                    'peminjaman_id' => $id,
                    'template' => 'satpam.peminjaman.pdf'
                ]);

                return $this->respondWithError(
                    'Template PDF tidak ditemukan. Silakan hubungi administrator.'
                );
            }

            // Load relationships
            $peminjaman->load(['user', 'ruangan.gedung']);

            // Validate required relationships
            if (!$peminjaman->ruangan) {
                throw new \Exception('Data ruangan tidak ditemukan');
            }

            // Generate PDF
            $pdf = Pdf::loadView('satpam.peminjaman.pdf', compact('peminjaman'))
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isPhpEnabled' => true,
                    'defaultFont' => 'Arial',
                    'isRemoteEnabled' => true,
                ]);

            // Generate filename
            $filename = sprintf(
                'Peminjaman_%s_%s.pdf',
                $peminjaman->id,
                $peminjaman->tanggal->format('Y-m-d')
            );

            // Log success
            Log::info('Satpam PDF generated', [
                'peminjaman_id' => $id,
                'filename' => $filename
            ]);

            return $pdf->download($filename);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Peminjaman not found for PDF', ['id' => $id]);

            return $this->respondWithError(
                'Peminjaman tidak ditemukan atau belum disetujui.'
            );
        } catch (\Exception $e) {
            Log::error('Satpam PDF generation failed', [
                'peminjaman_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'Terjadi kesalahan saat membuat PDF. Silakan coba lagi.';

            if (config('app.debug')) {
                $errorMessage .= ' Error: ' . $e->getMessage();
            }

            return $this->respondWithError($errorMessage);
        }
    }
    public function dashboard()
    {
        $totalDisetujui = Peminjaman::where('status', 'disetujui')->count();

        return view('satpam.dashboard', compact('totalDisetujui'));
    }
}
