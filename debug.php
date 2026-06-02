<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true]);
    echo "Seed successful\n";
} catch (\Exception $e) {
    file_put_contents(__DIR__.'/debug_out.txt', $e->getMessage() . "\n" . $e->getTraceAsString());
    echo "Written to debug_out.txt\n";
}
