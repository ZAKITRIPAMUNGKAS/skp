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
        Schema::table('afektif_sub_aspek', function (Blueprint $table) {
            $table->enum('status', ['belum_buka', 'aktif', 'tutup'])->default('belum_buka')->after('urutan');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('afektif_sub_aspek', function (Blueprint $table) {
            //
        });
    }
};
