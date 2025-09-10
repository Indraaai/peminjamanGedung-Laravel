<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $fillable = ['gedung_id', 'nama', 'kapasitas', 'fasilitas', 'foto'];

    public function gedung()
    {
        return $this->belongsTo(Gedung::class);
    }
    // Ruangan.php
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
