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
        Schema::table('peserta', function (Blueprint $table) {
            $table->text('alamat_rumah')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('nik')->nullable();
            $table->string('nbm')->nullable();
            $table->string('jabatan_aum')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->integer('umur')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('pendidikan_sd')->nullable();
            $table->string('bahasa_dikuasai')->nullable();
            $table->string('kemampuan_baca_quran')->nullable();
            $table->string('hafalan_quran_1')->nullable();
            $table->string('hafalan_quran_2')->nullable();
            $table->string('aktivitas_sholat_masjid')->nullable();
            $table->string('aktivitas_kajian_agama')->nullable();
            $table->integer('jumlah_buku_agama')->nullable();
            $table->string('sumber_info_muhammadiyah')->nullable();
            $table->string('langganan_suara_muhammadiyah')->nullable();
            $table->string('lembaga_zis_diikuti')->nullable();
            $table->string('tokoh_berpengaruh')->nullable();
            $table->text('alasan_pilih_tokoh')->nullable();
            $table->string('keaktifan_muhammadiyah')->nullable();
            $table->string('keaktifan_ortom')->nullable();
            $table->text('organisasi_lain')->nullable();
            $table->text('harapan_pcm')->nullable();
            $table->text('harapan_mengikuti_ba')->nullable();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            //
        });
    }
};
