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
            $table->string('nama_panggilan')->nullable()->after('nama_lengkap');
            $table->string('provinsi')->nullable()->after('kabupaten');
            $table->integer('jumlah_anak')->nullable()->after('status_pernikahan');
            $table->string('ukuran_kaos')->nullable()->after('aktivitas_kajian_agama');
            $table->string('rencana_keberangkatan')->nullable()->after('ukuran_kaos');
            $table->string('aktivitas_duduk')->nullable()->after('rencana_keberangkatan');
            $table->string('aktivitas_tangga')->nullable()->after('aktivitas_duduk');
            $table->string('aktivitas_sholat')->nullable()->after('aktivitas_tangga');
            $table->string('surat_komitmen')->nullable()->after('foto');
            $table->string('surat_tidak_bersedia')->nullable()->after('surat_komitmen');
            $table->string('kompetensi_keberagamaan')->nullable()->after('kemampuan_baca_quran');
            $table->string('kompetensi_akademis')->nullable()->after('kompetensi_keberagamaan');
            $table->string('kompetensi_sosial')->nullable()->after('kompetensi_akademis');
            $table->string('kompetensi_keorganisasian')->nullable()->after('kompetensi_sosial');
            $table->text('catatan_makanan')->nullable()->after('kompetensi_keorganisasian');
            $table->text('catatan_kesehatan')->nullable()->after('catatan_makanan');
            $table->text('catatan_panitia')->nullable()->after('catatan_kesehatan');
        });

        Schema::table('event_peserta', function (Blueprint $table) {
            $table->enum('konfirmasi_kesediaan', ['bersedia', 'tidak_bersedia', 'belum_konfirmasi'])->default('belum_konfirmasi')->after('status_aktif');
            $table->text('alasan_tidak_hadir')->nullable()->after('konfirmasi_kesediaan');
            $table->string('surat_tidak_hadir')->nullable()->after('alasan_tidak_hadir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn([
                'nama_panggilan',
                'provinsi',
                'jumlah_anak',
                'ukuran_kaos',
                'rencana_keberangkatan',
                'aktivitas_duduk',
                'aktivitas_tangga',
                'aktivitas_sholat',
                'surat_komitmen',
                'surat_tidak_bersedia',
                'kompetensi_keberagamaan',
                'kompetensi_akademis',
                'kompetensi_sosial',
                'kompetensi_keorganisasian',
                'catatan_makanan',
                'catatan_kesehatan',
                'catatan_panitia'
            ]);
        });

        Schema::table('event_peserta', function (Blueprint $table) {
            $table->dropColumn([
                'konfirmasi_kesediaan',
                'alasan_tidak_hadir',
                'surat_tidak_hadir'
            ]);
        });
    }
};
