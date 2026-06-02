<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('psikomotor_nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->foreignId('template_id')->constrained('psikomotor_template')->onDelete('cascade');
            $table->integer('skor');
            $table->foreignId('dinilai_oleh')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index('event_id');
            $table->index('peserta_id');
            $table->index('template_id');
            $table->index('dinilai_oleh');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('psikomotor_nilai');
    }
};
