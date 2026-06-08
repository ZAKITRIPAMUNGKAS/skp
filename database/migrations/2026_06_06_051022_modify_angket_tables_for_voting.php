<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('angket_item', function (Blueprint $table) {
            if (!Schema::hasColumn('angket_item', 'tipe')) {
                $table->string('tipe')->default('skala')->after('teks_item');
            }
        });

        Schema::table('angket_jawaban', function (Blueprint $table) {
            $table->string('jawaban', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('angket_item', function (Blueprint $table) {
            if (Schema::hasColumn('angket_item', 'tipe')) {
                $table->dropColumn('tipe');
            }
        });

        Schema::table('angket_jawaban', function (Blueprint $table) {
            $table->enum('jawaban', ['A', 'B', 'C', 'D'])->change();
        });
    }
};
