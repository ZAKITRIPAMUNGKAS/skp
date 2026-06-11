<?php
$handle = fopen('fix.csv', 'r');
$header = fgetcsv($handle);
$row = fgetcsv($handle);
fclose($handle);

echo "Header count: " . count($header) . "\n";
echo "Row count: " . count($row) . "\n";
print_r($header);
print_r($row);
