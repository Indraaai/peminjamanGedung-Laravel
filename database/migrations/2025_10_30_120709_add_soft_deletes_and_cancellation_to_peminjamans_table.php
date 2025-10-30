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
            // Soft delete column
            $table->softDeletes()->after('updated_at');

            // Cancellation tracking columns
            $table->unsignedBigInteger('cancelled_by')->nullable()->after('deleted_at');
            $table->timestamp('cancelled_at')->nullable()->after('cancelled_by');
            $table->text('cancellation_reason')->nullable()->after('cancelled_at');

            // Foreign key for cancelled_by
            $table->foreign('cancelled_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['cancelled_by']);

            // Drop columns
            $table->dropColumn([
                'deleted_at',
                'cancelled_by',
                'cancelled_at',
                'cancellation_reason'
            ]);
        });
    }
};
