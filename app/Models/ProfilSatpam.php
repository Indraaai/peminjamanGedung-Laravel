<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfilSatpam extends Model
{
    use HasFactory;

    protected $table = 'profil_satpam';

    protected $fillable = [
        'user_id',
        'no_telepon',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
