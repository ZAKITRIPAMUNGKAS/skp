<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$ep = App\Models\EventPeserta::where('peserta_id', 11)->first();
print_r($ep ? $ep->toArray() : 'EventPeserta not found for peserta_id 11');
