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
    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'Nim');
    $sheet->setCellValue('C3', 'Nama');
    $sheet->setCellValue('D3', 'Jenis');
    $sheet->setCellValue('E3', 'Jumlah Jam');
    $sheet->setCellValue('F3', 'Keterangan');
    $sheet->setCellValue('G3', 'Tanggal');

    $no = 0;  $row = 3;

    foreach ($dataMahasiswa as $dm){
        if($dm['kelas'] == $_POST['dropdown']){ 
            $no++;
            $row++;
            $sheet->setCellValue('A'.$row, $no);
            $sheet->setCellValue('B'.$row, $dm['nim']);
            $sheet->setCellValue('C'.$row, $dm['nama']);
            $sheet->setCellValue('D'.$row, 'Murni');
            $totalJamMinus = 0;
            foreach ($p5m as $pm){
                if($pm->nim_mahasiswa == $dm['nim'] && $pm->tgl_transaksi > $tanggal1 && $pm->tgl_transaksi < $tanggal2 ){
                    $totalJamMinus = $pm->total_jam_minus;
                }
            }
            $sheet->setCellValue('E'.$row, $totalJamMinus);
            $sheet->setCellValue('F'.$row, 'Jam Minus P5M Prodi MI Periode '.$tanggal1. ' - ' .$tanggal2);
            $sheet->setCellValue('G'.$row, date("Y-m-d"));

        }
    }
    $sheet->getColumnDimension('A')->setWidth(5);
    $sheet->getColumnDimension('B')->setWidth(15);
    $sheet->getColumnDimension('C')->setWidth(50);
    $sheet->getColumnDimension('D')->setWidth(10);
    $sheet->getColumnDimension('E')->setWidth(12);
    $sheet->getColumnDimension('F')->setWidth(55);
    $sheet->getColumnDimension('G')->setWidth(15);

    $sheet->mergeCells('A1:G1');
    $sheet->setCellValue('A1', 'Laporan Jam Minus P5M Kelas '.substr($_POST['dropdown'],-2) );
    $sheet->getStyle('A1:G1')->getFont()->setSize(18)->setBold(true);
    $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A3:G3')->getFont()->setBold(true);
    $sheet->getStyle('A3:G'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('C4:C'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

    // get the cell style
    $style = $sheet->getStyle('A3:G'.$row);
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
            ],
        ],
    ];
    $style->applyFromArray($styleArray);

    $writer = new Xlsx($spreadsheet);
    ob_clean();

    $fileName = "Laporan Jam Minus Absensi P5M ".substr($_POST['dropdown'],-2).".xlsx";
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment;filename=\"$fileName\"");
    $writer->save("php://output");


?>