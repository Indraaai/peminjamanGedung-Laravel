<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckProfileCompletion
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Jika user bukan admin dan sedang tidak mengakses halaman untuk melengkapi profil
        if ($user->role != 'admin' && !$request->routeIs('profil.create')) {
            $isMahasiswaIncomplete = $user->role == 'mahasiswa' && !$user->profilMahasiswa;
            $isDosenIncomplete = $user->role == 'dosen' && !$user->profilDosen;
            $isSatpamIncomplete = $user->role == 'satpam' && !$user->profilSatpam;

            if ($isMahasiswaIncomplete || $isDosenIncomplete || $isSatpamIncomplete) {
                // Paksa redirect ke halaman lengkapi profil
                return redirect()->route('profil.create');
            }
        }

        // Jika profil sudah lengkap, lanjutkan request
        return $next($request);
    }
}
