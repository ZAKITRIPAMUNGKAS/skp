<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('psikomotor_template')
            ->where('nama_aspek', 'Gerakan Shalat (Movement)')
            ->update(['nama_aspek' => 'Ketertiban Sholat (Orderliness)']);

        DB::table('psikomotor_template')
            ->where('nama_aspek', 'Bacaan Shalat (Recitation)')
            ->update(['nama_aspek' => 'Bacaan Al-Quran (Recitation)']);

        DB::table('psikomotor_template')
            ->where('nama_aspek', 'Tata Tertib Tarjih (Tarjih Order)')
            ->update(['nama_aspek' => 'Kesesuaian dengan Tarjih (Tarjih Compliance)']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('psikomotor_template')
            ->where('nama_aspek', 'Ketertiban Sholat (Orderliness)')
            ->update(['nama_aspek' => 'Gerakan Shalat (Movement)']);

        DB::table('psikomotor_template')
            ->where('nama_aspek', 'Bacaan Al-Quran (Recitation)')
            ->update(['nama_aspek' => 'Bacaan Shalat (Recitation)']);

        DB::table('psikomotor_template')
            ->where('nama_aspek', 'Kesesuaian dengan Tarjih (Tarjih Compliance)')
            ->update(['nama_aspek' => 'Tata Tertib Tarjih (Tarjih Order)']);
    }
};
