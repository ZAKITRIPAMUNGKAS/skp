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
        Schema::table('angket_komentar', function (Blueprint $table) {
            $table->foreignId('nominasi_disiplin_id')->nullable()->after('komentar')->constrained('peserta')->onDelete('set null');
            $table->foreignId('nominasi_aktif_id')->nullable()->after('nominasi_disiplin_id')->constrained('peserta')->onDelete('set null');
            $table->foreignId('nominasi_favorit_id')->nullable()->after('nominasi_aktif_id')->constrained('peserta')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('angket_komentar', function (Blueprint $table) {
            $table->dropForeign(['nominasi_disiplin_id']);
            $table->dropForeign(['nominasi_aktif_id']);
            $table->dropForeign(['nominasi_favorit_id']);
            $table->dropColumn(['nominasi_disiplin_id', 'nominasi_aktif_id', 'nominasi_favorit_id']);
        });
    }
};
