<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rtl', function (Blueprint $table) {
            $table->dropColumn(['tujuan', 'sasaran', 'indikator_keberhasilan', 'waktu_pelaksanaan', 'pihak_terlibat']);
        });
    }

    public function down(): void
    {
        Schema::table('rtl', function (Blueprint $table) {
            $table->text('tujuan')->nullable();
            $table->text('sasaran')->nullable();
            $table->text('indikator_keberhasilan')->nullable();
            $table->string('waktu_pelaksanaan')->nullable();
            $table->text('pihak_terlibat')->nullable();
        });
    }
};
