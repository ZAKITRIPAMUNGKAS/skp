<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('sesi_id')->constrained('event_sesi')->onDelete('cascade');
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->timestamp('waktu_scan')->nullable();
            $table->foreignId('scanned_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index('event_id');
            $table->index('sesi_id');
            $table->index('peserta_id');
            $table->index('scanned_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
