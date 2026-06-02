<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('angket_komentar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->text('komentar');
            $table->timestamps();

            $table->index('event_id');
            $table->index('peserta_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('angket_komentar');
    }
};
