<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Event;
use App\Models\Peserta;
use App\Services\ImportParticipantService;

$event = Event::first();
if (!$event) {
    echo "No event found!\n";
    exit;
}

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

echo "Total Peserta now: " . Peserta::count() . "\n";
echo "Total Peserta with nickname: " . Peserta::whereNotNull('nama_panggilan')->where('nama_panggilan', '<>', '')->count() . "\n";
