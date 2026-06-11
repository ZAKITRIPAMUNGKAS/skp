<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta_tes_mulai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('event_sesi_id')->constrained('event_sesi')->onDelete('cascade');
            $table->string('tipe'); // pretest, posttest
            $table->timestamp('waktu_mulai');
            $table->timestamps();

            $table->unique(['peserta_id', 'event_id', 'event_sesi_id', 'tipe'], 'idx_peserta_tes_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_tes_mulai');
    }
};
