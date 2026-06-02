<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('nama_event');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('lokasi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['persiapan', 'berlangsung', 'selesai'])->default('persiapan');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();

            $table->index('created_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
