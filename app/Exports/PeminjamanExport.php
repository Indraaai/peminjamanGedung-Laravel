<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class PeminjamanExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        try {
            return Peminjaman::with(['user.profilMahasiswa', 'user.profilDosen', 'ruangan.gedung'])
                ->get()
                ->map(function ($item) {
                    $user = $item->user;
                    
                    // Handle missing user gracefully
                    if (!$user) {
                        return [
                            'Nama' => 'Data tidak tersedia',
                            'Role' => '-',
                            'Nim/nidn_nip' => '-',
                            'Fakultas' => '-',
                            'Program Studi/Departemen' => '-',
                            'Ruangan' => $item->ruangan->nama ?? '-',
                            'Gedung' => $item->ruangan->gedung->nama ?? '-',
                            'Tanggal' => $item->tanggal ?? '-',
                            'Jam Mulai' => $item->jam_mulai ?? '-',
                            'Jam Selesai' => $item->jam_selesai ?? '-',
                            'Tujuan' => $item->tujuan ?? '-',
                            'Status' => ucfirst($item->status ?? 'unknown'),
                            'catatan' => $item->catatan_admin ?? '-',
                            'Dibuat Pada' => $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-',
                        ];
                    }

                    $profil = $user->role === 'mahasiswa' ? $user->profilMahasiswa : $user->profilDosen;

                    return [
                        'Nama' => $user->name ?? '-',
                        'Role' => $user->role ?? '-',
                        'Nim/nidn_nip' => $user->role === 'mahasiswa'
                            ? ($profil->nim ?? '-')
                            : ($profil->nidn_nip ?? '-'),
                        'Fakultas' => $profil->fakultas ?? '-',
                        'Program Studi/Departemen' => $user->role === 'mahasiswa'
                            ? ($profil->jurusan ?? '-')
                            : ($profil->departemen ?? '-'),
                        'Ruangan' => $item->ruangan->nama ?? '-',
                        'Gedung' => $item->ruangan->gedung->nama ?? '-',
                        'Tanggal' => $item->tanggal ?? '-',
                        'Jam Mulai' => $item->jam_mulai ?? '-',
                        'Jam Selesai' => $item->jam_selesai ?? '-',
                        'Tujuan' => $item->tujuan ?? '-',
                        'Status' => ucfirst($item->status ?? 'unknown'),
                        'catatan' => $item->catatan_admin ?? '-',
                        'Dibuat Pada' => $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-',
                    ];
                });
                
        } catch (\Exception $e) {
            \Log::error('Error saat mengambil data untuk export: ' . $e->getMessage());
            
            // Return empty collection jika ada error
            return collect([]);
        }
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Role',
            'NIM/NIP',
            'Fakultas',
            'Program Studi/Departemen',
            'Ruangan',
            'Gedung',
            'Tanggal',
            'Jam Mulai',
            'Jam Selesai',
            'Tujuan',
            'Status',
            'Catatan',
            'Dibuat Pada',
        ];
    }
}
