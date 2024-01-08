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
            $tanggalFT1 = $_POST['tanggal1'];
            $totalJamMinus = 0; 
            $tanggal1 = $_POST['tanggal1'];
            while (strtotime($tanggal1) < strtotime($tanggal2)) { //MENGHITUNG JAM MINUS
              $waktuBerangkat = 0;
              $waktuPulang = 0;

              $JamMinusBerangkat = 0;
              $JamMinusPulang = 0;

              $today = $tanggal1; // mendapatkan tanggal hari ini
              $dayOfWeek = date("l", strtotime($today)); // mendapatkan nama hari dari tanggal hari ini
            
              // memeriksa apakah hari ini Sabtu atau Minggu
              if ($dayOfWeek != "Saturday" && $dayOfWeek != "Sunday") {
                foreach ($absen as $m) { 
                  $waktu = $m->waktu;
                  $compareAbsen = explode(' ', $waktu);
                  if ($dm['nim'] == $m->nim && !strcmp($compareAbsen[0], $tanggal1)){
                      if($waktuBerangkat == 0 || $waktuPulang == 0 ){
                        $waktuBerangkat = explode(' ',$waktu);
                        $waktuPulang = explode(' ',$waktu);
                      }if($waktu < $waktuBerangkat){
                          $waktuBerangkat = explode(' ',$waktu);
                      }elseif($waktu > $waktuPulang){
                          $waktuPulang = explode(' ',$waktu);
                      }
                        
                      //DEKLARASI ABSEN BERANGKAT
                      $time = "07:30:00";
                      $timestamp = strtotime($time);
                      $waktuMasuk = date("H:i:s", $timestamp);
                      $timestamp = strtotime($waktuBerangkat[1]);
                      $absenMhsMasuk = date("H:i:s", $timestamp);
                      $tempJamMinus = 0;
                      $status = '';

                      while ($status!= 'oke') {       
                        if($absenMhsMasuk > $waktuMasuk){
                            $interval = "+15 minutes";
                            $timestamp = strtotime($waktuMasuk);
                            $timestamp = strtotime($interval, $timestamp);
                            $waktuMasuk = date("H:i:s", $timestamp);
                            $tempJamMinus = $tempJamMinus + 0.5;
                            if ($tempJamMinus==4){
                                break;
                              }
                        }else if($absenMhsMasuk <= $waktuMasuk){
                            $status = 'oke';
                        }
                      }
                      $JamMinusBerangkat = $tempJamMinus;

                      //DEKLARASI ABSEN PULANG
                      $time = "16:30:00";
                      $timestamp = strtotime($time);
                      $jamPulang = date("H:i:s", $timestamp);
                      $timestamp = strtotime($waktuPulang[1]);
                      $absenMhsPulang = date("H:i:s", $timestamp);
                      $tempJamMinus = 0;
                      $status = '';
                      
                      //MENGHITUNG JAM MINUS PULANG 
                      while ($status!= 'oke') {       
                        if($absenMhsPulang < $jamPulang){
                            $interval = "+15 minutes";
                            $timestamp = strtotime($absenMhsPulang);
                            $timestamp = strtotime($interval, $timestamp);
                            $absenMhsPulang = date("H:i:s", $timestamp);
                            $tempJamMinus = $tempJamMinus + 0.5;

                            if ($tempJamMinus==4){
                              break;
                            }
                        }else if($absenMhsPulang >= $jamPulang){
                            $status = 'oke';
                        }
                      }
                      $JamMinusPulang = $tempJamMinus;                                  
                  }
                }
                if($waktuBerangkat == 0){
                  $totalJamMinus = $totalJamMinus + 4;
                }
                if($waktuPulang == 0){
                  $totalJamMinus = $totalJamMinus + 4;
                }
              }
                $totalJamMinus = $totalJamMinus + $JamMinusBerangkat + $JamMinusPulang; 
                $tanggal1 = date ("Y-m-d", strtotime("+1 days", strtotime($tanggal1)));
            }
			$tanggal1 = $_POST['tanggal1'];
			$tanggal2 = $_POST['tanggal2'];
            $sheet->setCellValue('E'.$row, $totalJamMinus);
            $sheet->setCellValue('F'.$row, 'Jam Minus Absensi Prodi MI Periode '.$tanggal1. ' - ' .$tanggal2);
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
    $sheet->setCellValue('A1', 'Laporan Jam Minus Absensi Kelas '.substr($_POST['dropdown'],-2) );
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

    $fileName = "Laporan Jam Minus Absensi Kelas ".substr($_POST['dropdown'],-2).".xlsx";
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment;filename=\"$fileName\"");
    $writer->save("php://output");


?>