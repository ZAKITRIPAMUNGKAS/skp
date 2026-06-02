<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('penilaian_akhir', function (Blueprint $table) {
            $table->string('verification_hash')->nullable()->after('status_kelulusan');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('penilaian_akhir', function (Blueprint $table) {
            $table->dropColumn('verification_hash');
        });
    }
};
