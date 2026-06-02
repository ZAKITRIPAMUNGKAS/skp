<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        // Data and schema already updated manually via tinker to avoid PDO error.
        // Hanya memastikan status akhir dan mencatat migrasi.
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'peserta') NOT NULL DEFAULT 'peserta'");
        }
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'panitia', 'peserta') NOT NULL DEFAULT 'peserta'");
        }
    }
};
