<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->timestamp('rtl_deadline')->nullable()->after('registration_token');
        });

        Schema::table('rtl_soal', function (Blueprint $table) {
            $table->string('tipe')->default('essay')->after('pertanyaan'); // essay, deskripsi, upload
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('rtl_deadline');
        });

        Schema::table('rtl_soal', function (Blueprint $table) {
            $table->dropColumn('tipe');
        });
    }
};
