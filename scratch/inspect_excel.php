<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$file = 'public/example.xlsx';
$spreadsheet = IOFactory::load($file);
$sheet = $spreadsheet->getActiveSheet();

$highestColumn = $sheet->getHighestColumn();
$highestRow = 1; // Just check the first row for headers

$headers = [];
for ($col = 'A'; $col <= $highestColumn; $col++) {
    $headers[$col] = $sheet->getCell($col . '1')->getValue();
}

echo json_encode($headers, JSON_PRETTY_PRINT);
