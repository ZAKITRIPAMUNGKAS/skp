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
        Schema::table('peserta', function (Blueprint $table) {
            // Kolom untuk mencatat peserta ini mengikuti Baitul Arqam ke berapa
            $table->string('arqam_ke', 50)->nullable()->after('harapan_mengikuti_ba');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn('arqam_ke');
        });
    }
};
