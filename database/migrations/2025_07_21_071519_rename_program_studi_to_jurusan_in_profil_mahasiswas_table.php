<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profil_mahasiswas', function (Blueprint $table) {
            $table->renameColumn('Program studi', 'jurusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profil_mahasiswas', function (Blueprint $table) {
            $table->renameColumn('jurusan', 'Program studi');
        });
    }
};
