<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Event;
use App\Models\Peserta;

$handle = fopen('fix.csv', 'r');
$header = fgetcsv($handle);
fclose($handle);

$cleanedHeaders = array_map(function($h) {
    return strtolower(trim(preg_replace('/[^a-zA-Z0-9;_]/', ' ', strval($h))));
}, $header);

print_r($cleanedHeaders);
