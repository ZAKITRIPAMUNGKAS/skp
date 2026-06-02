<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_akhir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->decimal('nilai_pretest', 5, 2)->default(0);
            $table->decimal('nilai_posttest', 5, 2)->default(0);
            $table->decimal('nilai_afektif', 5, 2)->default(0);
            $table->decimal('nilai_psikomotor', 5, 2)->default(0);
            $table->decimal('nilai_kehadiran', 5, 2)->default(0);
            $table->decimal('skor_saw', 8, 6)->default(0);
            $table->integer('ranking')->nullable();
            $table->enum('predikat', ['Amat Baik', 'Baik', 'Cukup', 'Kurang'])->nullable();
            $table->string('status_kelulusan')->nullable();
            $table->timestamps();

            $table->index('event_id');
            $table->index('peserta_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_akhir');
    }
};
