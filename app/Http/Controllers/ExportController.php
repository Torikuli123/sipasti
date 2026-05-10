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

        $query = Arsip::query()->with('user');

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

        $templatePath = public_path('example.xlsx');
        
        if (file_exists($templatePath)) {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        } else {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        }

        $sheet = $spreadsheet->getActiveSheet();

        // Clear existing data rows if template is used (from row 7 onwards)
        $highestRow = $sheet->getHighestRow();
        if ($highestRow >= 7) {
            for ($i = 7; $i <= $highestRow; $i++) {
                foreach (range('A', 'Y') as $column) {
                    $sheet->setCellValue($column . $i, null);
                }
                // Reset styling for the cleared row
                $sheet->getStyle("A{$i}:Y{$i}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
            }
        }

        // Optional: Update title year range if data exists
        if ($arsips->isNotEmpty()) {
            $minDate = $arsips->min('tanggal_terhitung') ?? $arsips->min('created_at');
            $maxDate = $arsips->max('tanggal_termuda') ?? $arsips->max('created_at');
            
            $minYear = $minDate instanceof \Carbon\Carbon ? $minDate->year : date('Y', strtotime($minDate));
            $maxYear = $maxDate instanceof \Carbon\Carbon ? $maxDate->year : date('Y', strtotime($maxDate));
            
            $sheet->setCellValue('A3', "TAHUN $minYear - $maxYear");
        }

        // Add data rows starting from row 7
        $row = 7;
        foreach ($arsips as $index => $arsip) {
            $sheet->setCellValue("A{$row}", $arsip->nomor_definitif ?: ($index + 1));
            $sheet->setCellValue("B{$row}", $arsip->nomor_sementara);
            $sheet->setCellValue("C{$row}", $arsip->user->name ?? 'Admin');
            $sheet->setCellValue("D{$row}", $arsip->seri);
            $sheet->setCellValue("E{$row}", $arsip->masalah);
            $sheet->setCellValue("F{$row}", $arsip->kode_klasifikasi);
            $sheet->setCellValue("G{$row}", $arsip->isi_informasi);
            $sheet->setCellValue("H{$row}", $arsip->tanggal_terhitung?->format('Y.m.d'));
            $sheet->setCellValue("I{$row}", $arsip->tanggal_termuda?->format('Y.m.d'));
            $sheet->setCellValue("J{$row}", $arsip->kondisi);
            $sheet->setCellValue("K{$row}", $arsip->jumlah && $arsip->satuan_arsip ? "{$arsip->jumlah} {$arsip->satuan_arsip}" : $arsip->jumlah);
            $sheet->setCellValue("L{$row}", $arsip->tingkat_perkembangan);
            $sheet->setCellValue("M{$row}", $arsip->indeks_nama);
            $sheet->setCellValue("P{$row}", $arsip->indeks_tempat);
            $sheet->setCellValue("S{$row}", $arsip->indeks_masalah);
            $sheet->setCellValue("T{$row}", $arsip->daftar_singkatan);
            $sheet->setCellValue("U{$row}", $arsip->kepanjangan_singkatan);
            $sheet->setCellValue("V{$row}", $arsip->daftar_istilah);
            $sheet->setCellValue("W{$row}", $arsip->arti_istilah);
            $sheet->setCellValue("X{$row}", $arsip->kategori);
            $sheet->setCellValue("Y{$row}", $arsip->status);
            
            // Apply borders to the new data row
            $sheet->getStyle("A{$row}:Y{$row}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            
            $row++;
        }

        // Generate Excel file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
