<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('afektif_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->foreignId('sub_aspek_id')->constrained('afektif_sub_aspek')->onDelete('cascade');
            $table->foreignId('butir_id')->constrained('afektif_butir')->onDelete('cascade');
            $table->enum('jawaban', ['SS', 'S', 'TS', 'STS']);
            $table->integer('skor');
            $table->timestamps();

            $table->index('event_id');
            $table->index('peserta_id');
            $table->index('sub_aspek_id');
            $table->index('butir_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('afektif_jawaban');
    }
};
