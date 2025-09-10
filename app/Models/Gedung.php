<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'lokasi'];

    public function ruangans()
    {
        return $this->hasMany(Ruangan::class);
    }
}
