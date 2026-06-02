<?php
require 'vendor/autoload.php';

$filePath = 'rekap_semua.xlsx';
try {
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
    $worksheet = $spreadsheet->getSheetByName('rekap nilai semua.xlsx - PSIKOM');
    if ($worksheet) {
        $rows = $worksheet->toArray();
        echo "Headers for PSIKOM:\n";
        print_r($rows[0]);
        echo "\nRow 1:\n";
        print_r($rows[1]);
        echo "\nRow 2:\n";
        print_r($rows[2]);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
