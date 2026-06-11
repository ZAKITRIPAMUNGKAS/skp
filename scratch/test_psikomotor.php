<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Event;
use App\Models\PsikomotorNilai;
use App\Models\PsikomotorTemplate;
use App\Models\PenilaianAkhir;

$events = Event::all();
foreach ($events as $event) {
    echo "=========================================\n";
    echo "Event ID: {$event->id} - {$event->nama_event}\n";
    
    $templates = PsikomotorTemplate::where('event_id', $event->id)->get();
    echo "Templates count: " . $templates->count() . "\n";
    foreach ($templates as $t) {
        echo "  - Template ID: {$t->id}, Aspek: {$t->nama_aspek}, Max Skor: {$t->skor_maks}\n";
    }
    
    $nilaiCount = PsikomotorNilai::where('event_id', $event->id)->count();
    echo "Psikomotor Nilai Count: $nilaiCount\n";
    
    $penilaians = PenilaianAkhir::where('event_id', $event->id)->get();
    echo "Penilaian Akhir Count: " . $penilaians->count() . "\n";
    foreach ($penilaians as $pa) {
        $pesertaNama = $pa->peserta->nama_lengkap ?? 'Unknown';
        echo "  Peserta ID: {$pa->peserta_id} ({$pesertaNama}) -> pretest: {$pa->nilai_pretest}, posttest: {$pa->nilai_posttest}, afektif: {$pa->nilai_afektif}, psikomotor: {$pa->nilai_psikomotor}, saw: {$pa->skor_saw}\n";
        
        // Let's check the sum of scores in psikomotor_nilai
        $sumSkor = PsikomotorNilai::where('event_id', $event->id)
            ->where('peserta_id', $pa->peserta_id)
            ->sum('skor');
        $nilaiCountForPeserta = PsikomotorNilai::where('event_id', $event->id)
            ->where('peserta_id', $pa->peserta_id)
            ->count();
        echo "    -> Detail Nilai count: $nilaiCountForPeserta, Sum Skor: $sumSkor\n";
    }
}
