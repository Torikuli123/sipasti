<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$file = 'public/example.xlsx';
if (!file_exists($file)) {
    echo "File not found: $file";
    exit;
}
$spreadsheet = IOFactory::load($file);
$sheet = $spreadsheet->getActiveSheet();

$data = [];
for ($row = 1; $row <= 10; $row++) {
    $rowData = [];
    for ($col = 'A'; $col <= 'Z'; $col++) {
        $val = $sheet->getCell($col . $row)->getValue();
        if ($val !== null) {
            $rowData[$col] = $val;
        }
    }
    if (!empty($rowData)) {
        $data[$row] = $rowData;
    }
}

echo json_encode($data, JSON_PRETTY_PRINT);
