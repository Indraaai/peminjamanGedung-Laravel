<?php

namespace App\Services;

use App\Models\Peminjaman;
use Carbon\Carbon;

class ConflictDetectionService
{
    /**
     * Check if there's a daily conflict for a room on a specific date
     * 
     * @param int $ruanganId
     * @param string $tanggal
     * @param int|null $excludeId
     * @return bool
     */
    public function checkDailyConflict($ruanganId, $tanggal, $excludeId = null)
    {
        return Peminjaman::where('ruangan_id', $ruanganId)
            ->where('tanggal', $tanggal)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists();
    }
    
    /**
     * Get detailed conflict information for a room on a specific date
     * 
     * @param int $ruanganId
     * @param string $tanggal
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getConflictDetails($ruanganId, $tanggal)
    {
        return Peminjaman::with('user')
            ->where('ruangan_id', $ruanganId)
            ->where('tanggal', $tanggal)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->get();
    }
    
    /**
     * Suggest alternative dates for a room
     * 
     * @param int $ruanganId
     * @param string $startDate
     * @param int $days
     * @return array
     */
    public function suggestAlternativeDates($ruanganId, $startDate, $days = 7)
    {
        $availableDates = [];
        $currentDate = Carbon::parse($startDate);
        
        for ($i = 0; $i < $days; $i++) {
            $checkDate = $currentDate->copy()->addDays($i);
            
            // Skip past dates
            if ($checkDate->isPast()) {
                continue;
            }
            
            if (!$this->checkDailyConflict($ruanganId, $checkDate->format('Y-m-d'))) {
                $availableDates[] = [
                    'date' => $checkDate->format('Y-m-d'),
                    'formatted' => $checkDate->isoFormat('dddd, D MMMM Y'),
                    'day_name' => $checkDate->isoFormat('dddd')
                ];
            }
        }
        
        return $availableDates;
    }
    
    /**
     * Get conflict summary for a room
     * 
     * @param int $ruanganId
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getConflictSummary($ruanganId, $startDate, $endDate)
    {
        $conflicts = Peminjaman::where('ruangan_id', $ruanganId)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->selectRaw('tanggal, status, COUNT(*) as count')
            ->groupBy('tanggal', 'status')
            ->get();
            
        $summary = [
            'total_days' => 0,
            'approved_days' => 0,
            'pending_days' => 0,
            'available_days' => 0
        ];
        
        $conflictDates = $conflicts->pluck('tanggal')->unique();
        $summary['total_days'] = $conflictDates->count();
        
        foreach ($conflicts as $conflict) {
            if ($conflict->status === 'disetujui') {
                $summary['approved_days']++;
            } elseif ($conflict->status === 'menunggu') {
                $summary['pending_days']++;
            }
        }
        
        // Calculate available days in date range
        $totalDaysInRange = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;
        $summary['available_days'] = $totalDaysInRange - $summary['total_days'];
        
        return $summary;
    }
    
    /**
     * Check if a date is available for booking
     * 
     * @param int $ruanganId
     * @param string $tanggal
     * @return array
     */
    public function checkAvailability($ruanganId, $tanggal)
    {
        $hasConflict = $this->checkDailyConflict($ruanganId, $tanggal);
        $conflicts = $hasConflict ? $this->getConflictDetails($ruanganId, $tanggal) : collect();
        
        return [
            'available' => !$hasConflict,
            'date' => $tanggal,
            'conflicts' => $conflicts,
            'conflict_count' => $conflicts->count(),
            'has_approved' => $conflicts->where('status', 'disetujui')->count() > 0,
            'has_pending' => $conflicts->where('status', 'menunggu')->count() > 0
        ];
    }
}