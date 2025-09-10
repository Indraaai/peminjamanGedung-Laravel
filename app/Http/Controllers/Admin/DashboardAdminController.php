<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use Carbon\Carbon;
use DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $total = Peminjaman::count();
        $menunggu = Peminjaman::where('status', 'menunggu')->count();
        $disetujui = Peminjaman::where('status', 'disetujui')->count();
        $ditolak = Peminjaman::where('status', 'ditolak')->count();

        // Ruangan terfavorit
        $topRuangan = Ruangan::withCount('peminjamans')
            ->orderByDesc('peminjamans_count')
            ->first();

        // Data bulanan untuk grafik
        $bulanIni = Carbon::now()->startOfMonth();
        $dataBulanan = Peminjaman::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', date('Y'))
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->pluck('total', 'bulan');

        return view('admin.dashboard.index', compact(
            'total',
            'menunggu',
            'disetujui',
            'ditolak',
            'topRuangan',
            'dataBulanan'
        ));
    }
}
