<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ubah kolom role agar bisa menampung "satpam"
            $table->enum('role', ['admin', 'mahasiswa', 'dosen', 'satpam'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kembalikan ke kondisi semula tanpa "satpam"
            $table->enum('role', ['admin', 'mahasiswa', 'dosen'])->change();
        });
    }
};
