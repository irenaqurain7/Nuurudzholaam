<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PPDBExcelExport
{
    public function __construct(
        protected Collection $rows,
        protected string $schoolName,
        protected string $exportDate,
    ) {
    }

    public function output(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data PPDB');

        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(24);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(24);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(24);
        $sheet->getColumnDimension('G')->setWidth(24);
        $sheet->getColumnDimension('H')->setWidth(14);
        $sheet->getColumnDimension('I')->setWidth(18);

        $sheet->setCellValue('A1', 'DATA PENDAFTAR PPDB');
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A2', $this->schoolName);
        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A3', 'Tanggal Export : ' . $this->exportDate);
        $sheet->mergeCells('A3:I3');

        $sheet->getStyle('A1:I3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('A3')->getFont()->setItalic(true)->setSize(10);

        $headerRow = 5;
        $headers = [
            'A' => 'No',
            'B' => 'Nama Lengkap',
            'C' => 'Jenjang',
            'D' => 'Email',
            'E' => 'Nomor HP',
            'F' => 'Asal Sekolah',
            'G' => 'Program/Jurusan',
            'H' => 'Status',
            'I' => 'Tanggal Daftar',
        ];

        foreach ($headers as $column => $heading) {
            $sheet->setCellValue($column . $headerRow, $heading);
        }

        $sheet->getStyle('A5:I5')->getFont()->setBold(true)->getColor()->setARGB(Color::COLOR_WHITE);
        $sheet->getStyle('A5:I5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F7F5F');
        $sheet->getStyle('A5:I5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $rowNumber = $headerRow + 1;
        foreach ($this->rows as $row) {
            $sheet->setCellValue('A' . $rowNumber, $row['no']);
            $sheet->setCellValue('B' . $rowNumber, $row['nama_lengkap']);
            $sheet->setCellValue('C' . $rowNumber, $row['jenjang']);
            $sheet->setCellValue('D' . $rowNumber, $row['email']);
            $sheet->setCellValue('E' . $rowNumber, $row['nomor_hp']);
            $sheet->setCellValue('F' . $rowNumber, $row['asal_sekolah']);
            $sheet->setCellValue('G' . $rowNumber, $row['program_jurusan']);
            $sheet->setCellValue('H' . $rowNumber, $row['status']);
            $sheet->setCellValue('I' . $rowNumber, $row['tanggal_daftar']);
            $rowNumber++;
        }

        $lastRow = max($headerRow, $rowNumber - 1);
        $sheet->getStyle('A5:I' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A6:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C6:C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H6:H' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A5:I' . $lastRow)->getAlignment()->setWrapText(true);

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
