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
        Schema::table('peminjamans', function (Blueprint $table) {
            // Composite index untuk conflict checking - ruangan + tanggal + status
            $table->index(['ruangan_id', 'tanggal', 'status'], 'peminjamans_conflict_check');
            
            // Index untuk filter berdasarkan tanggal dan status
            $table->index(['tanggal', 'status'], 'peminjamans_date_status');
            
            // Index untuk filter berdasarkan user dan status
            $table->index(['user_id', 'status'], 'peminjamans_user_status');
            
            // Index untuk tanggal saja (untuk occupied dates query)
            $table->index(['tanggal'], 'peminjamans_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropIndex('peminjamans_conflict_check');
            $table->dropIndex('peminjamans_date_status');
            $table->dropIndex('peminjamans_user_status');
            $table->dropIndex('peminjamans_date');
        });
    }
};