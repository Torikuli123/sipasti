<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExportController extends Controller
{
    public function index(Request $request)
    {
        $query = Arsip::query();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('category') && $request->category !== '') {
            $query->where('kategori', $request->category);
        }

        $arsips = $query->orderByDesc('created_at')->get();
        $categories = Arsip::query()
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori')
            ->filter()
            ->values()
            ->all();

        if (empty($categories)) {
            $categories = ['Surat', 'Laporan', 'Kontrak', 'Dokumen'];
        }

        return view('exports.index', compact('arsips', 'categories'));
    }

    public function download(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'category'   => 'nullable|string|max:100',
            'filename'   => 'nullable|string|max:100',
        ]);

        $query = Arsip::query();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('category') && $request->category !== '') {
            $query->where('kategori', $request->category);
        }

        $arsips = $query->orderByDesc('created_at')->get();
        $filename = ($request->filename ?: 'export_arsip') . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Arsip');

        // Set column headers
        $headers = [
            'ID Arsip',
            'Nomor Definitif',
            'Nomor Arsip Sementara',
            'Seri',
            'Masalah / Sub Seri',
            'Kode Klasifikasi',
            'Isi Informasi',
            'Tanggal Tertua',
            'Tanggal Termuda',
            'Kondisi',
            'Jumlah',
            'Satuan Arsip',
            'Tingkat Perkembangan',
            'Status',
            'Kategori',
        ];

        $headerRow = 1;
        foreach ($headers as $colIndex => $header) {
            $colLetter = chr(65 + $colIndex);
            $cell = $sheet->getCell("{$colLetter}{$headerRow}");
            $cell->setValue($header);

            // Style header
            $cell->getStyle()->getFont()->setBold(true)->setColor(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('1D4ED8');
            $cell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $cell->getStyle()->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        }

        // Add data rows
        $row = 2;
        foreach ($arsips as $arsip) {
            $sheet->setCellValue("A{$row}", $arsip->id);
            $sheet->setCellValue("B{$row}", $arsip->nomor_definitif);
            $sheet->setCellValue("C{$row}", $arsip->nomor_sementara);
            $sheet->setCellValue("D{$row}", $arsip->seri);
            $sheet->setCellValue("E{$row}", $arsip->masalah);
            $sheet->setCellValue("F{$row}", $arsip->kode_klasifikasi);
            $sheet->setCellValue("G{$row}", $arsip->isi_informasi);
            $sheet->setCellValue("H{$row}", $arsip->tanggal_terhitung?->format('Y-m-d'));
            $sheet->setCellValue("I{$row}", $arsip->tanggal_termuda?->format('Y-m-d'));
            $sheet->setCellValue("J{$row}", $arsip->kondisi);
            $sheet->setCellValue("K{$row}", $arsip->jumlah && $arsip->satuan_arsip ? "{$arsip->jumlah} {$arsip->satuan_arsip}" : $arsip->jumlah);
            $sheet->setCellValue("L{$row}", $arsip->satuan_arsip);
            $sheet->setCellValue("M{$row}", $arsip->tingkat_perkembangan);
            $sheet->setCellValue("N{$row}", $arsip->status);
            $sheet->setCellValue("O{$row}", $arsip->kategori);

            // Style data rows
            foreach (range('A', 'O') as $colLetter) {
                $cell = $sheet->getCell("{$colLetter}{$row}");
                $cell->getStyle()->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GRAY);
                $cell->getStyle()->getAlignment()->setVertical(Alignment::VERTICAL_TOP)->setWrapText(true);
            }

            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'O') as $colLetter) {
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        // Set minimum column width
        foreach (range('A', 'O') as $colLetter) {
            if ($sheet->getColumnDimension($colLetter)->getWidth() < 12) {
                $sheet->getColumnDimension($colLetter)->setWidth(12);
            }
        }

        // Freeze header row
        $sheet->freezePane('A2');

        // Generate Excel file
        $writer = new Xlsx($spreadsheet);

        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
