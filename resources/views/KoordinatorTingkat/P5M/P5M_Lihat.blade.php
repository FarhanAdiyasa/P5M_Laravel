<?php
    $url = file_get_contents('https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3');
    $dataMahasiswa = json_decode($url, true);
?>

@extends('KoordinatorTingkat.layout.header')

@section('konten')

<main id="main" class="main">

<div class="pagetitle">
<br>
  <h1>Pertemuan 5 Menit</h1>
  <br> 
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
      <li class="breadcrumb-item active">P5M</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">

<div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="card-body">
                  <br>
					<?php 
                      $tanggal = $_POST['tanggalTransaksi'];
                      $kelasHistory = $_POST['kelasHistory']; ?> 
                      <table>
                        <th>
                      <p  style="text-align: end;">Tanggal : <?php echo $tanggal ?></p>
                      <p> Kelas :  <?php echo $kelasHistory ?></p>
                      </th>
                      </table>				  
                <form role="form" action='P5Mtingkat/tambah/' method="post">  
                 <table class="table table-bordered datatable">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">NIM</th>
                                                <th class="text-center">Nama Mahasiswa</th>
                                                
                                                <?php 
                                                $count=0;
                                                foreach ($pelanggaran as $m) {
                                                    $count++;    
                                                    ?>
                                                    
                                                    <th class="text-center"><?php echo $m->nama_pelanggaran ?></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php $i = 0; ?>
                                              <?php 
                                              $tanggal = $_POST['tanggalTransaksi'];
                                              $kelasHistory = $_POST['kelasHistory'];

                                              foreach ($dataMahasiswa as $dm) { 
                                               if($kelasHistory == $dm['kelas']){
                                                ?>
                                                  <tr>
                                                      <td class="text-center">
                                                          <?php $i++; ?>
                                                          <?php echo $i ?>
                                                      </td>
                                                      <td class="text-center"><?php echo $dm['nim']?></td>
                                                      <td ><?php echo $dm['nama']?></td>
                                                      
                                                    <?php  
                                                    
                                                    
                                                    foreach ($pelanggaran as $m) { 
                                                      $ischecked = '';
                                                      foreach ($get3tabel as $g){
                                                          if($g->id_pelanggaran == $m->id_pelanggaran && $dm['nim']==$g->nim_mahasiswa && $tanggal == $g->tgl_transaksi){
                                                            $ischecked = 'checked';
                                                          }
                                                      }
                                                      ?>
                                                      <td class="text-center">  <input type="checkbox" id="" name="" value="" <?= $ischecked ?> disabled >  </td>  

                                                      <?php  } ?>                                                  
                                                  </tr>


                                                <?php } }  ?>
                                        </tbody>
                                    </table>

                                    <br>
                                    <a href='p5mtingkat/history_lihat/' class="btn btn-info"><i class="fa fa-arrow-circle-left" > Kembali</a></i>
                  </form>
<br>

</div>

</div>
</div><!-- End Recent Sales -->


</section>

</main><!-- End #main -->

@endsection