<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilDosen extends Model
{
    use HasFactory;

    protected $table = 'profil_dosens';

    protected $fillable = [
        'user_id',
        'nidn_nip',
        'fakultas',
        'Departemen',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
