<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$filePath = __DIR__ . '/SET UP DATA ARQAM V2.0/32. Baitul Arqam Dosen UMS_Karanganyar (Jawaban)(1).xlsx';

$sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new class {}, new \Illuminate\Http\UploadedFile(
    $filePath, basename($filePath), null, null, true
));

echo "=== JUMLAH SHEET: " . count($sheets) . " ===\n\n";

foreach ($sheets as $sIndex => $sheet) {
    if (empty($sheet)) continue;
    echo "========================================\n";
    echo "SHEET $sIndex — " . count($sheet) . " baris\n";
    echo "========================================\n";

    $header = $sheet[0] ?? [];
    echo "\nHEADERS (" . count($header) . " kolom):\n";
    foreach ($header as $i => $h) {
        $cleaned = strtolower(trim(preg_replace('/[^a-zA-Z0-9;_]/', ' ', strval($h))));
        echo "  [$i] RAW: " . substr(strval($h), 0, 60) . "\n";
        echo "       CLN: $cleaned\n";
    }

    echo "\n--- BARIS DATA PERTAMA (baris ke-1 index) ---\n";
    if (isset($sheet[1])) {
        foreach ($sheet[1] as $i => $v) {
            echo "  [$i] " . substr(strval($v), 0, 80) . "\n";
        }
    }

    echo "\n--- BARIS DATA KEDUA (baris ke-2 index) ---\n";
    if (isset($sheet[2])) {
        foreach ($sheet[2] as $i => $v) {
            echo "  [$i] " . substr(strval($v), 0, 80) . "\n";
        }
    }
    echo "\n";
}
