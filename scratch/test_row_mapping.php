<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Services\ImportParticipantService;

$file = new \Illuminate\Http\UploadedFile(
    __DIR__ . '/../fix.csv',
    'fix.csv',
    'text/csv',
    null,
    true
);

$ref = new ReflectionMethod(ImportParticipantService::class, 'parseFile');
$ref->setAccessible(true);
$service = new ImportParticipantService();
$rows = $ref->invoke($service, $file);

print_r($rows[1]); // Ryan Rizki Adhisa
