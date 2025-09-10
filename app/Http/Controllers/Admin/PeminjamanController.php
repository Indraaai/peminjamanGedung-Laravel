<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['ruangan.gedung', 'user']);

        // Filter: Status (hanya jika user memilih)
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // Filter: Rentang tanggal
        if ($request->filled('tanggal') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal, $request->tanggal_selesai]);
        }

        // Pencarian global
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($q) => $q->where('name', 'like', "%$search%"))
                    ->orWhereHas('ruangan', fn($q) => $q->where('nama', 'like', "%$search%"))
                    ->orWhere('tanggal', 'like', "%$search%");
            });
        }

        $permintaanBaru = $query->latest()->paginate(5);

        return view('admin.peminjaman.index', compact('permintaanBaru'));
    }




    public function show(Peminjaman $peminjaman)
    {
        $user = $peminjaman->user;

        if ($user->role === 'mahasiswa') {
            $profil = $user->profilMahasiswa;
        } elseif ($user->role === 'dosen') {
            $profil = $user->profilDosen;
        } else {
            $profil = null;
        }

        return view('admin.peminjaman.show', compact('peminjaman', 'user', 'profil'));
    }


    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak,menunggu',
            'catatan_admin' => 'nullable|string',
        ]);

        // SIMPLIFIED CONFLICT CHECK: Daily-based for approval
        if ($request->status === 'disetujui') {
            $conflict = Peminjaman::where('ruangan_id', $peminjaman->ruangan_id)
                ->where('tanggal', $peminjaman->tanggal)
                ->where('status', 'disetujui')
                ->where('id', '!=', $peminjaman->id)
                ->exists();

            if ($conflict) {
                return back()->with('error', 'Gagal menyetujui: Ruangan sudah dipinjam pada tanggal tersebut.');
            }
        }

        $peminjaman->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman diperbarui.');
    }
}
