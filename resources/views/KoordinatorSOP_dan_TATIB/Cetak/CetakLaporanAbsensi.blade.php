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
    $sheet->mergeCells('B4:B5');
    $sheet->setCellValue('B4', 'No');
    $sheet->mergeCells('C4:C5');
    $sheet->setCellValue('C4', 'Nim');
    $sheet->mergeCells('D4:D5');
    $sheet->setCellValue('D4', 'Nama');
    
    $cel1 = 'E';
    $cel2 = 'F';

    while (strtotime($tanggal1) < strtotime($tanggal2)) {
        $sheet->mergeCells($cel1.'4:'.$cel2.'4');
        $sheet->setCellValue($cel1.'4', $tanggal1);
        $cel1++;
        $cel1++;
        $cel2++;
        $cel2++;
    $tanggal1 = date ("Y-m-d", strtotime("+1 days", strtotime($tanggal1)));  }

    $cel1 = 'E';
    $cel2 = 'F';

    for($i=0; $i<$jumlahHari; $i++){
        $sheet->setCellValue($cel1.'5', 'IN');
        $sheet->setCellValue($cel2.'5', 'OUT');
        $cel1++;
        $cel1++;
        $cel2++;
        $cel2++;
    }


    $i = 0; $no = 0; $bulan = 1; $row = 5;
    
    $cel1 = 'E';
    $cel2 = 'F';

    foreach ($dataMahasiswa as $dm){
        $i++;

        if($dataMahasiswa[$i-1]['kelas'] == $_POST['dropdown']){ 
            $no++;
            $row++;
            $sheet->setCellValue('B'.$row, $no);
            $sheet->setCellValue('C'.$row, $dataMahasiswa[$i-1]['nim']);
            $sheet->setCellValue('D'.$row, $dataMahasiswa[$i-1]['nama']);


            $tanggalFT1 = $_POST['tanggal1'];

            while (strtotime($tanggalFT1) < strtotime($tanggal2)) {
              $waktuBerangkat = 0;
              $waktuPulang = 0;

                foreach ($absen as $m) { 
                  $waktu = $m->waktu;
                  $compareAbsen = explode(' ', $waktu);
                  if ($dataMahasiswa[$i-1]['nim'] == $m->nim && !strcmp($compareAbsen[0], $tanggalFT1)){
                      if($waktuBerangkat == 0 || $waktuPulang == 0 ){
                        $waktuBerangkat = explode(' ',$waktu);
                        $waktuPulang = explode(' ',$waktu);
                      }if($waktu < $waktuBerangkat){
                          $waktuBerangkat = explode(' ',$waktu);
                      }elseif($waktu > $waktuPulang){
                          $waktuPulang = explode(' ',$waktu);
                      }
                  }
                  // else if ($dataMahasiswa[$i-1]['nim'] == $m->nim && strcmp($compareAbsen[0], $tanggalFT1)){
                  //   $waktuBerangkat = 0;
                  //   $waktuPulang = 0;
                  // }
                }
                if($waktuBerangkat==0) {
                    $sheet->setCellValue($cel1.$row, '-');
                }else{
                    $sheet->setCellValue($cel1.$row, $waktuBerangkat[1]);
                }
                if($waktuPulang==0) {
                    $sheet->setCellValue($cel2.$row, '-');
                }else{ if($waktuBerangkat[1] == $waktuPulang[1]){
                    $sheet->setCellValue($cel2.$row, '-');
                    }else{
                    $sheet->setCellValue($cel2.$row, $waktuPulang[1]);
                }}
                $tanggalFT1 = date ("Y-m-d", strtotime("+1 days", strtotime($tanggalFT1))); 
                $cel1++;
                $cel1++;
                $celCetak = $cel2;
                $cel2++;
                $cel2++;
            } 
            $cel1 = 'E';
            $cel2 = 'F'; 
        }
    }
    $tanggal1 = $_POST['tanggal1'];
    $sheet->mergeCells('B2:'.$celCetak.'2');
    $sheet->setCellValue('B2', 'Laporan Absensi Periode '. $tanggal1. ' - ' .$tanggal2);
    $sheet->getStyle('B2:'.$celCetak.'2')->getFont()->setSize(18)->setBold(true);
    $sheet->getStyle('B2:'.$celCetak.'2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
   
    $sheet->getStyle('B4:'.$celCetak.'5')->getFont()->setBold(true);
    $sheet->getStyle('B4:'.$celCetak.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('D5:D'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

    // $employee = mysqli_query($koneksi,"select * from my_form");
    // $row = 2;
    // $no =1;
    // while($record = mysqli_fetch_array($employee))
    // {
    //     $sheet->setCellValue('A'.$row, $no);
    //     $sheet->setCellValue('B'.$row, $record['name']);
    //     $sheet->setCellValue('C'.$row, $record['email']);
    //     $row++;
    //     $no++;
    // }

    // get the cell style
    // $style = $sheet->getStyle('B1:E5');
    // $styleArray = [
    //     'borders' => [
    //         'allBorders' => [
    //             'borderStyle' => Border::BORDER_THIN,
    //         ],
    //     ],
    // ];
    // $style->applyFromArray($styleArray);

    // $style = $sheet->getStyle('B4:'.$celCetak.'5');
    // $styleArray = [
    //     'borders' => [
    //         'outline' => [
    //             'borderStyle' => Border::BORDER_THICK,
    //         ],
    //     ],
    // ];
    // $style->applyFromArray($styleArray);

    $sheet->getColumnDimension('B')->setWidth(5);
    $sheet->getColumnDimension('C')->setWidth(15);
    $sheet->getColumnDimension('D')->setWidth(50);


    $style = $sheet->getStyle('B4:'.$celCetak.$row);
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THICK,
            ],
        ],
    ];
    $style->applyFromArray($styleArray);

    // $style = $sheet->getStyle('B4:'.$celCetak.'5');
    // $styleArray = [
    //     'borders' => [
    //         'allBorders' => [
    //             'borderStyle' => Border::BORDER_THICK,
    //         ],
    //     ],
    // ];
    // $style->applyFromArray($styleArray);




    $writer = new Xlsx($spreadsheet);
    ob_clean();

    $fileName = "Laporan Absensi $tanggal1-$tanggal2.xlsx";
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment;filename=\"$fileName\"");
    $writer->save("php://output");


?>
