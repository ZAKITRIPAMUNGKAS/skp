<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ahp_bobot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->json('matriks');
            $table->decimal('bobot_c1', 8, 6);
            $table->decimal('bobot_c2', 8, 6);
            $table->decimal('bobot_c3', 8, 6);
            $table->decimal('bobot_c4', 8, 6);
            $table->decimal('bobot_c5', 8, 6);
            $table->decimal('cr_value', 8, 6);
            $table->boolean('is_consistent')->default(false);
            $table->timestamps();

            $table->index('event_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ahp_bobot');
    }
};
