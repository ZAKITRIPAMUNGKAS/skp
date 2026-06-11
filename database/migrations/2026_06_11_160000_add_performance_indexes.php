<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Composite index on jawaban_peserta for faster "hasSubmitted" lookups
        Schema::table('jawaban_peserta', function (Blueprint $table) {
            $table->index(['event_id', 'peserta_id'], 'idx_jawaban_event_peserta');
        });

        // Composite index on penilaian_akhir for frequent lookups
        Schema::table('penilaian_akhir', function (Blueprint $table) {
            $table->index(['event_id', 'peserta_id'], 'idx_penilaian_event_peserta');
        });

        // Unique constraint on rtl to prevent duplicate submissions
        Schema::table('rtl', function (Blueprint $table) {
            $table->unique(['event_id', 'peserta_id'], 'idx_rtl_event_peserta_unique');
        });

        // Index on rtl for faster status checks
        Schema::table('rtl', function (Blueprint $table) {
            $table->index(['event_id', 'peserta_id', 'status'], 'idx_rtl_event_peserta_status');
        });

        // Index on rtl_jawaban for faster lookups
        Schema::table('rtl_jawaban', function (Blueprint $table) {
            $table->index(['rtl_id', 'rtl_soal_id'], 'idx_rtl_jawaban_composite');
        });

        // Index on rtl_soal for faster event queries
        Schema::table('rtl_soal', function (Blueprint $table) {
            $table->index(['event_id', 'urutan'], 'idx_rtl_soal_event_urutan');
        });

        // Composite index on sesi_tes for dashboard queries
        Schema::table('sesi_tes', function (Blueprint $table) {
            $table->index(['event_id', 'tipe', 'status'], 'idx_sesi_tes_composite');
        });

        // Composite index on absensi for kehadiran queries
        Schema::table('absensi', function (Blueprint $table) {
            $table->index(['event_id', 'peserta_id'], 'idx_absensi_event_peserta');
        });

        // Composite index on afektif_jawaban
        Schema::table('afektif_jawaban', function (Blueprint $table) {
            $table->index(['event_id', 'peserta_id'], 'idx_afektif_jawaban_composite');
        });

        // Composite index on angket_jawaban
        Schema::table('angket_jawaban', function (Blueprint $table) {
            $table->index(['event_id', 'peserta_id'], 'idx_angket_jawaban_composite');
        });

        // Composite index on event_peserta (most frequent query)
        Schema::table('event_peserta', function (Blueprint $table) {
            $table->index(['peserta_id', 'event_id'], 'idx_event_peserta_composite');
        });
    }

    public function down(): void
    {
        Schema::table('jawaban_peserta', function (Blueprint $table) {
            $table->dropIndex('idx_jawaban_event_peserta');
        });

        Schema::table('penilaian_akhir', function (Blueprint $table) {
            $table->dropIndex('idx_penilaian_event_peserta');
        });

        Schema::table('rtl', function (Blueprint $table) {
            $table->dropUnique('idx_rtl_event_peserta_unique');
            $table->dropIndex('idx_rtl_event_peserta_status');
        });

        Schema::table('rtl_jawaban', function (Blueprint $table) {
            $table->dropIndex('idx_rtl_jawaban_composite');
        });

        Schema::table('rtl_soal', function (Blueprint $table) {
            $table->dropIndex('idx_rtl_soal_event_urutan');
        });

        Schema::table('sesi_tes', function (Blueprint $table) {
            $table->dropIndex('idx_sesi_tes_composite');
        });

        Schema::table('absensi', function (Blueprint $table) {
            $table->dropIndex('idx_absensi_event_peserta');
        });

        Schema::table('afektif_jawaban', function (Blueprint $table) {
            $table->dropIndex('idx_afektif_jawaban_composite');
        });

        Schema::table('angket_jawaban', function (Blueprint $table) {
            $table->dropIndex('idx_angket_jawaban_composite');
        });

        Schema::table('event_peserta', function (Blueprint $table) {
            $table->dropIndex('idx_event_peserta_composite');
        });
    }
};
