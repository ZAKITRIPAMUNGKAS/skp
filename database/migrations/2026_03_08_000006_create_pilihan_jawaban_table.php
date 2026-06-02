<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pilihan_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soal_id')->constrained('soal')->onDelete('cascade');
            $table->enum('huruf', ['A', 'B', 'C', 'D']);
            $table->text('teks_pilihan');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();

            $table->index('soal_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pilihan_jawaban');
    }
};
