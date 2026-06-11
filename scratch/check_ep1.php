<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$ep = App\Models\EventPeserta::where('peserta_id', 1)->first();
print_r($ep ? $ep->toArray() : 'not found');
