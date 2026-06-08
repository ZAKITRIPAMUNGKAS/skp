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
        Schema::table('event_sesi', function (Blueprint $table) {
            if (!Schema::hasColumn('event_sesi', 'pemateri')) {
                $table->string('pemateri')->nullable()->after('nama_sesi');
            }
            if (!Schema::hasColumn('event_sesi', 'file_materi')) {
                $table->string('file_materi')->nullable()->after('pemateri');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_sesi', function (Blueprint $table) {
            if (Schema::hasColumn('event_sesi', 'pemateri')) {
                $table->dropColumn('pemateri');
            }
            if (Schema::hasColumn('event_sesi', 'file_materi')) {
                $table->dropColumn('file_materi');
            }
        });
    }
};
