<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Event;
use App\Models\Peserta;
use App\Models\EventPeserta;
use App\Services\ImportParticipantService;

$event = Event::find(2); // BA DOSEN DEMO
if (!$event) {
    echo "BA DOSEN DEMO not found!\n";
    exit;
}

// Hapus relasi peserta di event ini dulu agar bersih
EventPeserta::where('event_id', $event->id)->delete();

$file = new \Illuminate\Http\UploadedFile(
    __DIR__ . '/../fix.csv',
    'fix.csv',
    'text/csv',
    null,
    true
);

$service = new ImportParticipantService();
$result = $service->import($file, $event, 'update');

print_r($result);

echo "Total EventPeserta in Event 2: " . EventPeserta::where('event_id', 2)->count() . "\n";
echo "Total EventPeserta with status 'tidak_bersedia': " . EventPeserta::where('event_id', 2)->where('konfirmasi_kesediaan', 'tidak_bersedia')->count() . "\n";
echo "Total EventPeserta with status 'bersedia': " . EventPeserta::where('event_id', 2)->where('konfirmasi_kesediaan', 'bersedia')->count() . "\n";
