<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('afektif_sub_aspek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('nama_sub_aspek');
            $table->foreignId('sesi_id')->nullable()->constrained('event_sesi')->onDelete('set null');
            $table->integer('urutan');
            $table->timestamps();

            $table->index('event_id');
            $table->index('sesi_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('afektif_sub_aspek');
    }
};
