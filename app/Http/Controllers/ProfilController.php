<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilMahasiswa;
use App\Models\ProfilDosen;
use App\Models\ProfilSatpam;

class ProfilController extends Controller
{
    // Menampilkan halaman form
    public function create()
    {
        return view('profile.create');
    }

    // Menyimpan data dari form
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role == 'mahasiswa') {
            $request->validate([
                'nim' => 'required|string|unique:profil_mahasiswas,nim',
                'fakultas' => 'required|string',
                'jurusan' => 'required|string',
            ]);

            ProfilMahasiswa::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'fakultas' => $request->fakultas,
                'jurusan' => $request->jurusan,
            ]);
        } elseif ($user->role == 'dosen') {
            $request->validate([
                'nidn_nip' => 'required|string|unique:profil_dosens,nidn_nip',
                'fakultas' => 'required|string',
                'Departemen' => 'required|string',
            ]);

            ProfilDosen::create([
                'user_id' => $user->id,
                'nidn_nip' => $request->nidn_nip,
                'fakultas' => $request->fakultas,
                'Departemen' => $request->Departemen,
            ]);
        } elseif ($user->role == 'satpam') {
            $request->validate([
                'no_telepon' => 'required|string',
                'alamat' => 'required|string',
            ]);

            ProfilSatpam::create([
                'user_id' => $user->id,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
            ]);
        }

        return $user->role === 'satpam'
            ? redirect()->route('satpam.dashboard')->with('status', 'Profil berhasil dilengkapi!')
            : redirect()->route('dashboard')->with('status', 'Profil berhasil dilengkapi!');
    }
}
