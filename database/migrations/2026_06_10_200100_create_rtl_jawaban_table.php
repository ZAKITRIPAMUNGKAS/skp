<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rtl_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rtl_id')->constrained('rtl')->onDelete('cascade');
            $table->foreignId('rtl_soal_id')->constrained('rtl_soal')->onDelete('cascade');
            $table->text('jawaban');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rtl_jawaban');
    }
};
