<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;
use App\Services\PeminjamanService;
use App\Services\ConflictDetectionService;
use App\Traits\RespondsWithFlashMessages;
use Carbon\Carbon;

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
    public function index(Request $request)
    {
        // Fix N+1 Query: Add eager loading for profil relationships
        $query = Peminjaman::with([
            'ruangan.gedung',
            'user',
            'user.profilMahasiswa',
            'user.profilDosen'
        ]);

        // Filter: Status (hanya jika user memilih)
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // Filter: Rentang tanggal
        if ($request->filled('tanggal') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal, $request->tanggal_selesai]);
        }

        // Pencarian global
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($q) => $q->where('name', 'like', "%$search%"))
                    ->orWhereHas('ruangan', fn($q) => $q->where('nama', 'like', "%$search%"))
                    ->orWhere('tanggal', 'like', "%$search%");
            });
        }

        $permintaanBaru = $query->latest()->paginate(5);

        return view('admin.peminjaman.index', compact('permintaanBaru'));
    }




    public function show(Peminjaman $peminjaman)
    {
        // Eager load relationships to avoid N+1
        $peminjaman->load([
            'user.profilMahasiswa',
            'user.profilDosen',
            'ruangan.gedung'
        ]);

        $user = $peminjaman->user;

        if ($user->role === 'mahasiswa') {
            $profil = $user->profilMahasiswa;
        } elseif ($user->role === 'dosen') {
            $profil = $user->profilDosen;
        } else {
            $profil = null;
        }

        return view('admin.peminjaman.show', compact('peminjaman', 'user', 'profil'));
    }


    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak,menunggu',
            'catatan_admin' => 'nullable|string',
        ]);

        // CRITICAL FIX: Add authorization checks for approval
        if ($request->status === 'disetujui') {
            // Check if booking date has passed
            $tanggalPeminjaman = Carbon::parse($peminjaman->tanggal);

            if ($tanggalPeminjaman->isPast()) {
                return $this->respondWithError(
                    'Tidak dapat menyetujui peminjaman untuk tanggal yang sudah lewat.'
                );
            }

            // Check for conflicts using ConflictDetectionService
            if ($this->conflictService->checkDailyConflict(
                $peminjaman->ruangan_id,
                $peminjaman->tanggal,
                $peminjaman->id
            )) {
                return $this->respondWithError(
                    'Gagal menyetujui: Ruangan sudah dipinjam pada tanggal tersebut.'
                );
            }
        }

        // Validate status transitions
        $validTransitions = [
            'menunggu' => ['disetujui', 'ditolak'],
            'disetujui' => ['ditolak'],  // Can be cancelled
            'ditolak' => [],  // Cannot be changed
        ];

        $currentStatus = $peminjaman->status;
        $newStatus = $request->status;

        if (!in_array($newStatus, $validTransitions[$currentStatus] ?? [])) {
            return $this->respondWithError(
                "Tidak dapat mengubah status dari '{$currentStatus}' ke '{$newStatus}'."
            );
        }

        try {
            // Use service for consistent business logic
            $this->peminjamanService->updateStatus(
                $peminjaman,
                $request->status,
                $request->catatan_admin
            );

            $statusText = $newStatus === 'disetujui' ? 'disetujui' : 'ditolak';
            return $this->respondWithSuccess(
                "Peminjaman berhasil {$statusText}.",
                'admin.peminjaman.index'
            );
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
}
