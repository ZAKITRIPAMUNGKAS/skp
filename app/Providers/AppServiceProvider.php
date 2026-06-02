<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

use App\Models\Absensi;
use App\Models\PenilaianAkhir;
use App\Observers\AbsensiObserver;
use App\Observers\PenilaianAkhirObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Daftarkan layanan aplikasi apa pun.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap layanan aplikasi apa pun.
     */
    public function boot(): void
    {
        Absensi::observe(AbsensiObserver::class);
        PenilaianAkhir::observe(PenilaianAkhirObserver::class);

        Blade::directive('angka', function ($expression) {
            return "<?php echo number_format($expression, 0, ',', '.'); ?>";
        });

        Blade::directive('tanggal', function ($expression) {
            return "<?php echo \Carbon\Carbon::parse($expression)->translatedFormat('d F Y'); ?>";
        });

        Blade::directive('predikat', function ($expression) {
            return "<?php 
                \$p = $expression;
                \$bg = match(\$p) {
                    'Amat Baik' => 'bg-green-50 text-green-700 border-green-200',
                    'Baik' => 'bg-blue-50 text-blue-700 border-blue-200',
                    'Cukup' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                    'Kurang' => 'bg-red-50 text-red-700 border-red-200',
                    default => 'bg-gray-50 text-gray-700 border-gray-200'
                };
                echo \"<span class='px-2 py-1 rounded-full border text-[10px] whitespace-nowrap font-semibold {\$bg}'>{\$p}</span>\";
            ?>";
        });
    }
}
