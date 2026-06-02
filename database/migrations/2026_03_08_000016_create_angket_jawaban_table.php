<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('angket_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('angket_item')->onDelete('cascade');
            $table->enum('jawaban', ['A', 'B', 'C', 'D']);
            $table->timestamps();

            $table->index('event_id');
            $table->index('peserta_id');
            $table->index('item_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('angket_jawaban');
    }
};
