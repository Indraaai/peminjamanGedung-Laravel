<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'ruangan_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'tujuan',
        'dokumen',
        'status',
        'catatan_admin'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    // Query Scopes
    public function scopeForDate($query, $date)
    {
        return $query->where('tanggal', $date);
    }

    public function scopeForRoom($query, $roomId)
    {
        return $query->where('ruangan_id', $roomId);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['menunggu', 'disetujui']);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'ditolak');
    }

    public function scopeConflictCheck($query, $roomId, $date, $excludeId = null)
    {
        return $query->forRoom($roomId)
            ->forDate($date)
            ->active()
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId));
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('tanggal', '>=', now()->format('Y-m-d'));
    }

    // Accessors
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->tanggal)->isoFormat('dddd, D MMMM Y');
    }

    public function getTimeRangeAttribute()
    {
        return "{$this->jam_mulai} - {$this->jam_selesai} WIB";
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'menunggu' => 'bg-yellow-100 text-yellow-800',
            'disetujui' => 'bg-green-100 text-green-800',
            'ditolak' => 'bg-red-100 text-red-800'
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getStatusTextAttribute()
    {
        $texts = [
            'menunggu' => 'Menunggu Persetujuan',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak'
        ];

        return $texts[$this->status] ?? 'Status Tidak Diketahui';
    }

    public function getStatusIconAttribute()
    {
        $icons = [
            'menunggu' => '⏳',
            'disetujui' => '✅',
            'ditolak' => '❌'
        ];

        return $icons[$this->status] ?? '❓';
    }

    public function getIsUpcomingAttribute()
    {
        return $this->tanggal >= now()->format('Y-m-d');
    }

    public function getIsPastAttribute()
    {
        return $this->tanggal < now()->format('Y-m-d');
    }

    public function getCanBeCancelledAttribute()
    {
        return $this->status === 'menunggu' && $this->is_upcoming;
    }

    public function getCanBeEditedAttribute()
    {
        return $this->status === 'menunggu' && $this->is_upcoming;
    }
}
