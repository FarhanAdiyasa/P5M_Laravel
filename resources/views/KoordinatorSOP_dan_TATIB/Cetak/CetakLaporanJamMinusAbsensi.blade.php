<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

try {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // sheet pertama
    $sheet->setTitle('Sheet 1');
    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'Nim');
    $sheet->setCellValue('C3', 'Nama');
    $sheet->setCellValue('D3', 'Jenis');
    $sheet->setCellValue('E3', 'Jumlah Jam');
    $sheet->setCellValue('F3', 'Keterangan');
    $sheet->setCellValue('G3', 'Tanggal');

    $row = 3;
    $sheet->setCellValue('A' . $row, 1);
            $sheet->setCellValue('B' . $row, "AA");
            $sheet->setCellValue('C' . $row, "AA");
            $sheet->setCellValue('D' . $row, 'Murni');
            $sheet->setCellValue('E' . $row, "AA");
            $sheet->setCellValue('F' . $row, "AA");
            $sheet->setCellValue('G' . $row, "AA");

    $sheet->getColumnDimension('A')->setWidth(5);
    $sheet->getColumnDimension('B')->setWidth(15);
    $sheet->getColumnDimension('C')->setWidth(50);
    $sheet->getColumnDimension('D')->setWidth(10);
    $sheet->getColumnDimension('E')->setWidth(12);
    $sheet->getColumnDimension('F')->setWidth(55);
    $sheet->getColumnDimension('G')->setWidth(15);

    $sheet->mergeCells('A1:G1');
    $sheet->setCellValue('A1', 'Laporan Jam Minus Absensi Kelas ' . $kelas);
    $sheet->getStyle('A1:G1')->getFont()->setSize(18)->setBold(true);
    $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A3:G3')->getFont()->setBold(true);
    $sheet->getStyle('A3:G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('C4:C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

    // get the cell style
    $style = $sheet->getStyle('A3:G' . $row);
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
            ],
        ],
    ];
    $style->applyFromArray($styleArray);

    $writer = new Xlsx($spreadsheet);
    $fileName = "Laporan Jam Minus Absensi Kelas " . $kelas . ".xlsx";
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment;filename=\"$fileName\"");
    $writer->save("php://output");
    exit();
} catch (Exception $e) {
    // Handle the exception here
    dd( $e->getMessage());
}
?><?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

try {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // sheet pertama
    $sheet->setTitle('Sheet 1');
    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'Nim');
    $sheet->setCellValue('C3', 'Nama');
    $sheet->setCellValue('D3', 'Jenis');
    $sheet->setCellValue('E3', 'Jumlah Jam');
    $sheet->setCellValue('F3', 'Keterangan');
    $sheet->setCellValue('G3', 'Tanggal');

    $row = 3;
    $sheet->setCellValue('A' . $row, 1);
            $sheet->setCellValue('B' . $row, "AA");
            $sheet->setCellValue('C' . $row, "AA");
            $sheet->setCellValue('D' . $row, 'Murni');
            $sheet->setCellValue('E' . $row, "AA");
            $sheet->setCellValue('F' . $row, "AA");
            $sheet->setCellValue('G' . $row, "AA");

    $sheet->getColumnDimension('A')->setWidth(5);
    $sheet->getColumnDimension('B')->setWidth(15);
    $sheet->getColumnDimension('C')->setWidth(50);
    $sheet->getColumnDimension('D')->setWidth(10);
    $sheet->getColumnDimension('E')->setWidth(12);
    $sheet->getColumnDimension('F')->setWidth(55);
    $sheet->getColumnDimension('G')->setWidth(15);

    $sheet->mergeCells('A1:G1');
    $sheet->setCellValue('A1', 'Laporan Jam Minus Absensi Kelas ' . $kelas);
    $sheet->getStyle('A1:G1')->getFont()->setSize(18)->setBold(true);
    $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A3:G3')->getFont()->setBold(true);
    $sheet->getStyle('A3:G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('C4:C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

    // get the cell style
    $style = $sheet->getStyle('A3:G' . $row);
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
            ],
        ],
    ];
    $style->applyFromArray($styleArray);

    $writer = new Xlsx($spreadsheet);
    $fileName = "Laporan Jam Minus Absensi Kelas " . $kelas . ".xlsx";
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment;filename=\"$fileName\"");
    $writer->save("php://output");
    exit();
} catch (Exception $e) {
    // Handle the exception here
    dd( $e->getMessage());
}
?>