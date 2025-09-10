<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Ruangan;

class DashboardController extends Controller
{
    /**
     * Mengarahkan pengguna ke dasbor yang sesuai berdasarkan peran mereka.
     */
    public function index()
    {
        $role = Auth::user()->role;

        if ($role == 'admin') {
            // Ambil data statistik
            $totalPeminjaman = Peminjaman::count();
            $totalDisetujui = Peminjaman::where('status', 'disetujui')->count();
            $totalDitolak = Peminjaman::where('status', 'ditolak')->count();
            $totalMenunggu = Peminjaman::where('status', 'menunggu')->count();
            // Jumlah user aktif (misalnya yang sudah melengkapi profil mahasiswa atau dosen)
            $totalUserAktif = User::whereHas('profilMahasiswa')
                ->orWhereHas('profilDosen')
                ->count();

            // Jumlah ruangan tersedia
            $totalRuangan = Ruangan::count(); // atau kasih kondisi jika punya kolom status

            return view('dashboards.admin', compact(
                'totalPeminjaman',
                'totalDisetujui',
                'totalDitolak',
                'totalMenunggu',
                'totalUserAktif',
                'totalRuangan'
            ));
        } elseif (in_array($role, ['mahasiswa', 'dosen'])) {
            $peminjamans = Peminjaman::with('ruangan')
                ->where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get();

            return view('dashboards.peminjam', compact('peminjamans'));
        } elseif ($role = 'satpam') {
            $totalDisetujui = Peminjaman::where('status', 'disetujui')->count();

            return view('satpam.dashboard', compact('totalDisetujui'));
        }
    }
}
