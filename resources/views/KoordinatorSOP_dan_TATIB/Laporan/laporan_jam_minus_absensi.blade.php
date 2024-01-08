<?php
	ini_set('max_execution_time', 600);
    ini_set('memory_limit', '-1');
		
    $url = file_get_contents('https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3');
    $dataMahasiswa = json_decode($url, true);
?>
@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Laporan Jam Minus</h1>
  <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Absensi</li>
            <li class="breadcrumb-item active" aria-current="page">Laporan Jam Minus Absensi</li>
        </ol>
    </nav>
</div><!-- End Page Title -->


<section class="section">
<div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <br> 
                  <div class="row">
                    <div class="col-1">
                      <form method="get">
                      <select class="form-select" style="display:inline; padding: 0.375rem 1.25rem .375rem .75rem;" name="chooseFilter" id="chooseFilter">
                      <option value="kelas" <?php if (isset($_GET['chooseFilter']) && $_GET['chooseFilter'] == 'kelas') echo 'selected'; ?>>Kelas</option>
                      <option value="nim" <?php if (isset($_GET['chooseFilter']) && $_GET['chooseFilter'] == 'nim') echo 'selected'; ?>>Nim</option>    
                        </select>
                      </form>
                    </div>

                    <script>
                      document.querySelector('#chooseFilter').addEventListener('change', function() {
                        document.querySelector('form').submit();
                      });
                    </script>

                    <div class="col-9">
                    <form action="" method="post" name="pilih" id="pilih">  
                    <?php if (isset($_GET['chooseFilter'])) { ?>

                       
                      <?php if($_GET['chooseFilter'] == 'kelas'){ ?>
                        <select class="form-select" style="width:20%; display:inline;" name="dropdown">
                          <?php
                            $kelas = array();                    
                            $i=0;
                            foreach ($dataMahasiswa as $dm){
                              $i++;
                              array_push($kelas, $dataMahasiswa[$i-1]['kelas']);
                            }
                            sort($kelas);
                            $arrayLength = count($kelas);
                            ?>
                              <?php
                      for ($i = 0; $i < $arrayLength; $i++) {
                        if ($i == 0 || $kelas[$i] != $kelas[$i - 1]) {
                                    echo "<option value='" . $kelas[$i] . "'>" . $kelas[$i] . "</option>";
                                  }
                                }
                              ?>
                        </select>
                      <?php } elseif($_GET['chooseFilter'] == 'nim'){ ?>
                        <input class="form-control" style="width:20%; display:inline;" type="text" id="nim" name="nim">
                      <?php } } else { ?>
                        <select class="form-select" style="width:20%; display:inline;" name="dropdown">
                        <?php
                          $kelas = array();                    
                          $i=0;
                          foreach ($dataMahasiswa as $dm){
                            $i++;
                            array_push($kelas, $dataMahasiswa[$i-1]['kelas']);
                          }
                          sort($kelas);
                          $arrayLength = count($kelas);
                          ?>
                            <?php
                      for ($i = 0; $i < $arrayLength; $i++) {
                        if ($i == 0 || $kelas[$i] != $kelas[$i - 1]) {
                                  echo "<option value='" . $kelas[$i] . "'>" . $kelas[$i] . "</option>";
                                }
                              }
                            ?>
                      </select>

                      <?php } ?>
                          &nbsp&nbsp&nbsp&nbsp
                          <label for="birthday">Mulai Tanggal &nbsp:</label>
                          &nbsp
                          <input class="form-control" style="width:20%; display:inline;" class="text-left" type="date" id="tanggal1" name="tanggal1">
                          &nbsp&nbsp&nbsp&nbsp
                          <label for="birthday">Sampai Tanggal &nbsp:</label>
                          &nbsp
                          <input class="form-control" style="width:20%; display:inline;" float: right; type="date" id="tanggal2" name="tanggal2"> 
                          &nbsp
                          <input  type="submit" id="cetak" name="cetak"class="btn btn-primary" value="Pilih"/>
                      </form>
                    </div>


                  <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
                    <div class="col-1">
                        <form action="cetakJamMinusAbsensi" method="post" name="cetak" id="cetak">  
                          <input type="submit" id="cetak" name="cetak"class="btn btn-primary" value="Cetak"/>
                          <input type="hidden" id="tanggal1" name="tanggal1" value="<?php echo $_POST['tanggal1'];?>"/>
                          <input type="hidden" id="tanggal2" name="tanggal2" value="<?php echo $_POST['tanggal2'];?>"/>
                          <?php $DDL=(isset($_POST['dropdown']))? $_POST['dropdown'] : ""; ?>
                          <input type="hidden" id="dropdown" name="dropdown" value="<?php echo $DDL;?>"/>   
                        </form><br>
                    </div>
                  </div>
                </div>
  
  
                  <?php
                    $tanggal1 = $_POST['tanggal1'];
                    $tanggal2 = date('Y-m-d', strtotime('+1 days', strtotime($_POST['tanggal2'])));
                    $tanggalFT1 = date('Y-M-d', strtotime('+0 days', strtotime($_POST['tanggal1'])));
                    $tanggalFT2 = date('Y-M-d', strtotime('+0 days', strtotime($_POST['tanggal2'])));

                    $date1 = new DateTime($tanggal1);
                    $date2 = new DateTime($tanggal2);
                    $diff = $date2->diff($date1);
                    $jumlahHari = $diff->days;
                  ?>

                  <div class="container">
                  <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">No.</th>
                                <th class="text-center" scope="col">Nim</th>
                                <th class="text-center" scope="col">Nama</th>
                                <th class="text-center" scope="col">Jenis</th>
                                <th class="text-center" scope="col">Jumlah Jam</th>
                                <th class="text-center" scope="col">Keterangan</th>
                                <th class="text-center" scope="col">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0;$no = 0; ?>
                        
                        
                        <?php foreach ($dataMahasiswa as $dm){
                          $i++;
                          if(isset($_POST['dropdown'])){
                            if($dataMahasiswa[$i-1]['kelas'] == $_POST['dropdown']){ 
                            $no++;
                        ?>

                        <tr>
                        <td class="text-center"><?php echo $no?></td>
                        <td class="text-center"><?php echo $dataMahasiswa[$i-1]['nim']?></td>
                        <td ><?php echo $dataMahasiswa[$i-1]['nama']?></td>
                        <td class="text-center">Murni</td>
                        
                        <?php 
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
                              if ($dataMahasiswa[$i-1]['nim'] == $m->nim && !strcmp($compareAbsen[0], $tanggal1)){
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
                        ?>

                        <td class="text-center"><?php echo $totalJamMinus?></td>
                        <td class="text-center">Jam Minus Absensi Prodi MI Periode <?php echo $tanggalFT1?> Sampai <?php echo $tanggalFT2?></td>
                        <td class="text-center"><?php echo date("Y-m-d")?></td>
                        </tr>
                        <?php }                        
                         
                        } else if(isset($_POST['nim'])){
                          if($dataMahasiswa[$i-1]['nim'] == $_POST['nim']){ 
                              $no++;
                        ?>

                        <tr>
                        <td class="text-center"><?php echo $no?></td>
                        <td class="text-center"><?php echo $dataMahasiswa[$i-1]['nim']?></td>
                        <td ><?php echo $dataMahasiswa[$i-1]['nama']?></td>
                        <td class="text-center">Murni</td>
                        
                        <?php 
                          
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
                                if ($dataMahasiswa[$i-1]['nim'] == $m->nim && !strcmp($compareAbsen[0], $tanggal1)){
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
                             
                             ?>  

                        <td class="text-center"><?php echo $totalJamMinus?></td>
                        <td class="text-center">Jam Minus Absensi Prodi MI Periode <?php echo $tanggalFT1?> Sampai <?php echo $tanggalFT2?></td>
                        <td class="text-center"><?php echo date("y-M-d")?></td>
                        </tr>
                        <?php }?>

                        <?php    }?>
                      
                      <?php  } }?>
                        </tbody>
                    </table>
                    </div>
                    <br>
                    <br>
                </div>

              </div>
            </div><!-- End Recent Sales -->
</section>

</main><!-- End #main -->
<script>
function submitForm(selected_car) {
  document.getElementById("selected_car").value = selected_car;
  document.forms[0].submit();
}
</script>

@endsection