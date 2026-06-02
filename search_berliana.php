<?php
require 'vendor/autoload.php';

$filePath = 'rekap_semua.xlsx';
try {
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
    foreach ($spreadsheet->getSheetNames() as $sheetName) {
        $worksheet = $spreadsheet->getSheetByName($sheetName);
        $rows = $worksheet->toArray();
        echo "Sheet: $sheetName\n";
        foreach ($rows as $i => $row) {
            foreach ($row as $cell) {
                if (stripos((string)$cell, 'berliana') !== false) {
                    echo "Row " . ($i+1) . " -> " . $cell . "\n";
                }
            }
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
