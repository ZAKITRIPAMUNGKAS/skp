<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban_peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->foreignId('soal_id')->constrained('soal')->onDelete('cascade');
            $table->foreignId('pilihan_id')->constrained('pilihan_jawaban')->onDelete('cascade');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();

            $table->index('event_id');
            $table->index('peserta_id');
            $table->index('soal_id');
            $table->index('pilihan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_peserta');
    }
};
