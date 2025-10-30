<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\GedungController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Exports\PeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Admin\PeminjamanExportController;
use App\Http\Controllers\Admin\SatpamController;
use App\Http\Controllers\Satpam;
use App\Http\Controllers\SatpamPeminjamanController;



Route::get('/', function () {
    return view('auth/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'profile.completed'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Halaman profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Lengkapi profil (mahasiswa/dosen)
    Route::get('/profil/lengkapi', [ProfilController::class, 'create'])->name('profil.create');
    Route::post('/profil/lengkapi', [ProfilController::class, 'store'])->name('profil.store');

    // Routing untuk peminjam (mahasiswa/dosen)
    Route::middleware(['profile.completed'])->group(function () {
        // Katalog ruangan
        Route::get('/katalog', [PeminjamanController::class, 'katalog'])->name('katalog.index');

        // Peminjaman routes
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');

        // API endpoints MUST come BEFORE dynamic routes
        Route::get('/peminjaman/availability', [PeminjamanController::class, 'availability'])
            ->name('peminjaman.availability');
        Route::get('/peminjaman/occupied-dates', [PeminjamanController::class, 'occupiedDates'])
            ->name('peminjaman.occupied-dates');
        Route::get('/peminjaman/check-conflict', [PeminjamanController::class, 'checkConflict'])
            ->name('peminjaman.check-conflict');
        Route::get('/peminjaman/suggest-dates', [PeminjamanController::class, 'suggestDates'])
            ->name('peminjaman.suggest-dates');
        Route::get('/peminjaman/room-summary', [PeminjamanController::class, 'roomSummary'])
            ->name('peminjaman.room-summary');

        Route::post('/peminjaman', [PeminjamanController::class, 'store'])
            ->name('peminjaman.store');
        Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])
            ->name('peminjaman.show');

        Route::delete('/peminjaman/{peminjaman}/batal', [PeminjamanController::class, 'cancel'])
            ->middleware(['auth'])
            ->name('peminjaman.cancel');

        // PDF Download Route
        Route::get('/peminjaman/{peminjaman}/pdf', [PeminjamanController::class, 'downloadPdf'])
            ->middleware(['auth'])
            ->name('peminjaman.pdf');
    });


    // Routing admin
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'auth.admin'])->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
        Route::resource('gedung', GedungController::class);
        Route::resource('ruangan', RuanganController::class);

        // Export route MUST be before resource route to avoid conflict with {peminjaman} wildcard
        Route::get('peminjaman/export', [PeminjamanExportController::class, 'export'])->name('peminjaman.export');

        Route::resource('peminjaman', AdminPeminjamanController::class)->only(['index', 'show', 'update']);
        Route::resource('satpam', SatpamController::class);

        // Route test Excel yang berfungsi - dikembalikan untuk debugging
        Route::get('test-excel', function () {
            try {
                $export = new \App\Exports\PeminjamanExport();
                return \Maatwebsite\Excel\Facades\Excel::download($export, 'test_data.xlsx');
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ], 500);
            }
        })->name('test.excel');
    });

    // routes/web.php
    Route::middleware(['auth', 'satpam'])->prefix('satpam')->name('satpam.')->group(function () {
        Route::get('/dashboard', [SatpamPeminjamanController::class, 'dashboard'])->name('dashboard');
        Route::get('/peminjaman', [SatpamPeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/peminjaman/{id}', [SatpamPeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::get('/peminjaman/{id}/pdf', [SatpamPeminjamanController::class, 'downloadPdf'])->name('peminjaman.pdf');
    });
});

require __DIR__ . '/auth.php';
