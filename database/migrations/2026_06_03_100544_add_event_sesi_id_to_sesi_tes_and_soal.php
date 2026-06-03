<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sesi_tes', function (Blueprint $table) {
            $table->foreignId('event_sesi_id')->nullable()->constrained('event_sesi')->nullOnDelete();
        });

        Schema::table('soal', function (Blueprint $table) {
            $table->foreignId('event_sesi_id')->nullable()->constrained('event_sesi')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesi_tes', function (Blueprint $table) {
            $table->dropForeign(['event_sesi_id']);
            $table->dropColumn('event_sesi_id');
        });

        Schema::table('soal', function (Blueprint $table) {
            $table->dropForeign(['event_sesi_id']);
            $table->dropColumn('event_sesi_id');
        });
    }
};
