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
        Schema::create('rtl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->string('judul_kegiatan');
            $table->string('kategori_rtl');
            $table->text('tujuan');
            $table->text('sasaran');
            $table->text('indikator_keberhasilan');
            $table->string('waktu_pelaksanaan');
            $table->text('pihak_terlibat');
            $table->json('langkah_langkah'); // [{step: 1, deskripsi: 'x', target_tanggal: 'y'}]
            $table->string('status')->default('submitted'); // draft, submitted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rtl');
    }
};
