<?php
    $url = file_get_contents('https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3');
    $dataMahasiswa = json_decode($url, true);

    $tanggal1 = $_POST['tanggal1'];
    $tanggal2 = date('Y-m-d', strtotime('+1 days', strtotime($_POST['tanggal2'])));
    $tanggalFT2 = $tanggal2;

    $date1 = new DateTime($tanggal1);
    $date2 = new DateTime($tanggal2);
    $diff = $date2->diff($date1);
    $jumlahHari = $diff->days;
    require 'vendor/autoload.php';

    // koneksi php dan mysql
    // $koneksi = mysqli_connect("localhost", "root", "", "test");

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;  

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // sheet pertama
    $sheet->setTitle('Sheet 1');
    $sheet->setCellValue('B4', 'No');
    $sheet->setCellValue('C4', 'Nim');
    $sheet->setCellValue('D4', 'Waktu');

    $no = 0;  $row = 4;

    foreach ($absen as $m) { 
        if(strtotime($m->waktu) > strtotime($tanggal1) && strtotime($m->waktu) < strtotime($tanggal2)){

            $no++;
            $row++;
            $sheet->setCellValue('B'.$row, $no);
            $sheet->setCellValue('C'.$row, $m->nim);
            $sheet->setCellValue('D'.$row, $m->waktu);

        }
    }


    $sheet->getColumnDimension('B')->setWidth(5);
    $sheet->getColumnDimension('C')->setWidth(15);
    $sheet->getColumnDimension('D')->setWidth(22);

    $sheet->mergeCells('B2:D2');
    $sheet->setCellValue('B2', 'Daftar Absensi P5M');
    $sheet->getStyle('B2:B2')->getFont()->setSize(15)->setBold(true);
    $sheet->getStyle('B2:B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B4:D4')->getFont()->setBold(true);
    $sheet->getStyle('B4:H'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // get the cell style
    $style = $sheet->getStyle('B4:D'.$row);
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THICK,
            ],
        ],
    ];
    $style->applyFromArray($styleArray);

    $writer = new Xlsx($spreadsheet);
    ob_clean();

    $fileName = "Daftar Absensi.xlsx";
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment;filename=\"$fileName\"");
    $writer->save("php://output");


?>
