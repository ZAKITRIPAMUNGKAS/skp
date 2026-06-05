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
        Schema::table('peserta', function (Blueprint $table) {
            $table->text('keaktifan_ortom')->nullable()->change();
            $table->text('keaktifan_muhammadiyah')->nullable()->change();
            $table->text('kemampuan_baca_quran')->nullable()->change();
            $table->text('aktivitas_sholat_masjid')->nullable()->change();
            $table->text('aktivitas_kajian_agama')->nullable()->change();
            $table->text('kompetensi_keberagamaan')->nullable()->change();
            $table->text('kompetensi_akademis')->nullable()->change();
            $table->text('kompetensi_sosial')->nullable()->change();
            $table->text('kompetensi_keorganisasian')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
