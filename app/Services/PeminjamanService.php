<?php

namespace App\Services;

use App\Models\Peminjaman;
use App\Services\ConflictDetectionService;
use Illuminate\Support\Facades\Auth;
use Exception;

class PeminjamanService
{
    protected $conflictService;
    
    public function __construct(ConflictDetectionService $conflictService)
    {
        $this->conflictService = $conflictService;
    }
    
    /**
     * Create a new peminjaman with conflict checking
     * 
     * @param array $data
     * @return Peminjaman
     * @throws Exception
     */
    public function createPeminjaman($data)
    {
        // Check for daily conflict
        if ($this->conflictService->checkDailyConflict($data['ruangan_id'], $data['tanggal'])) {
            throw new Exception('Ruangan sudah dipinjam pada tanggal tersebut. Silakan pilih tanggal lain.');
        }
        
        // Set default values
        $data['user_id'] = $data['user_id'] ?? Auth::id();
        $data['status'] = $data['status'] ?? 'menunggu';
        
        return Peminjaman::create($data);
    }
    
    /**
     * Approve a peminjaman with conflict checking
     * 
     * @param Peminjaman $peminjaman
     * @param string|null $catatanAdmin
     * @return Peminjaman
     * @throws Exception
     */
    public function approvePeminjaman(Peminjaman $peminjaman, $catatanAdmin = null)
    {
        // Check for conflicts with other approved bookings
        if ($this->conflictService->checkDailyConflict(
            $peminjaman->ruangan_id, 
            $peminjaman->tanggal, 
            $peminjaman->id
        )) {
            throw new Exception('Tidak dapat menyetujui: Ada konflik dengan peminjaman lain yang sudah disetujui.');
        }
        
        $peminjaman->update([
            'status' => 'disetujui',
            'catatan_admin' => $catatanAdmin
        ]);
        
        return $peminjaman;
    }
    
    /**
     * Reject a peminjaman
     * 
     * @param Peminjaman $peminjaman
     * @param string|null $catatanAdmin
     * @return Peminjaman
     */
    public function rejectPeminjaman(Peminjaman $peminjaman, $catatanAdmin = null)
    {
        $peminjaman->update([
            'status' => 'ditolak',
            'catatan_admin' => $catatanAdmin
        ]);
        
        return $peminjaman;
    }
    
    /**
     * Update peminjaman status with proper validation
     * 
     * @param Peminjaman $peminjaman
     * @param string $status
     * @param string|null $catatanAdmin
     * @return Peminjaman
     * @throws Exception
     */
    public function updateStatus(Peminjaman $peminjaman, $status, $catatanAdmin = null)
    {
        switch ($status) {
            case 'disetujui':
                return $this->approvePeminjaman($peminjaman, $catatanAdmin);
                
            case 'ditolak':
                return $this->rejectPeminjaman($peminjaman, $catatanAdmin);
                
            case 'menunggu':
                $peminjaman->update([
                    'status' => 'menunggu',
                    'catatan_admin' => $catatanAdmin
                ]);
                return $peminjaman;
                
            default:
                throw new Exception('Status tidak valid: ' . $status);
        }
    }
    
    /**
     * Get available dates for a room
     * 
     * @param int $ruanganId
     * @param string $startDate
     * @param int $days
     * @return array
     */
    public function getAvailableDates($ruanganId, $startDate, $days = 30)
    {
        return $this->conflictService->suggestAlternativeDates($ruanganId, $startDate, $days);
    }
    
    /**
     * Get occupied dates for a room
     * 
     * @param int $ruanganId
     * @param string|null $startDate
     * @param string|null $endDate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOccupiedDates($ruanganId, $startDate = null, $endDate = null)
    {
        $query = Peminjaman::with('user')
            ->where('ruangan_id', $ruanganId)
            ->whereIn('status', ['menunggu', 'disetujui']);
            
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->where('tanggal', '>=', $startDate);
        }
        
        return $query->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get(['tanggal', 'jam_mulai', 'jam_selesai', 'status', 'tujuan', 'user_id']);
    }
    
    /**
     * Get availability info for a specific date
     * 
     * @param int $ruanganId
     * @param string $tanggal
     * @return array
     */
    public function getDateAvailability($ruanganId, $tanggal)
    {
        return $this->conflictService->checkAvailability($ruanganId, $tanggal);
    }
    
    /**
     * Cancel a peminjaman (only if status is 'menunggu')
     * 
     * @param Peminjaman $peminjaman
     * @param int $userId
     * @return bool
     * @throws Exception
     */
    public function cancelPeminjaman(Peminjaman $peminjaman, $userId)
    {
        // Check ownership
        if ($peminjaman->user_id !== $userId) {
            throw new Exception('Anda tidak memiliki izin untuk membatalkan peminjaman ini.');
        }
        
        // Check status
        if ($peminjaman->status !== 'menunggu') {
            throw new Exception('Peminjaman tidak dapat dibatalkan karena sudah diproses.');
        }
        
        return $peminjaman->delete();
    }
    
    /**
     * Get conflict summary for admin dashboard
     * 
     * @param int $ruanganId
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getConflictSummary($ruanganId, $startDate, $endDate)
    {
        return $this->conflictService->getConflictSummary($ruanganId, $startDate, $endDate);
    }
}