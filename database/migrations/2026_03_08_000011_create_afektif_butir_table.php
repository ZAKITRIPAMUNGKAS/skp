<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('afektif_butir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_aspek_id')->constrained('afektif_sub_aspek')->onDelete('cascade');
            $table->text('teks_pernyataan');
            $table->boolean('is_positif')->default(true);
            $table->integer('urutan');
            $table->timestamps();

            $table->index('sub_aspek_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('afektif_butir');
    }
};
