<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>P5M Manajemen Informatika</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link rel="icon" type="image/png" href="{{ asset('assets_login/images/icons/icon.ico') }}" />
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/stylenew.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet">
    <!-- =======================================================
      * Template Name: NiceAdmin - v2.5.0
      * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
      * Author: BootstrapMade.com
      * License: https://bootstrapmade.com/license/
      ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
         <img src='assets/img/himma.png' alt="Profile" class="rounded-circle">
          <span class="d-none d-lg-block">&nbsp;P5M</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

   
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->



      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed " href='tingkat'>
          <i class="bi bi-bar-chart-line"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->



      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-ui-checks-grid"></i><span>Pelanggaran</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href='p5mtingkat'>
              <i class="bi bi-circle"></i><span>P5M</span>
            </a>
          </li>
		  <li>
            <a href='p5mtingkathistory'>
              <i class="bi bi-circle"></i><span>History P5M</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->
	  
	  <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-postcard"></i><span>Absensi</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        @php
    $isLaporanActive = request()->segment(1) == 'absesitingkat' && request()->segment(2) == 'laporan';
@endphp

<li class="{{ $isLaporanActive ? 'active' : '' }}">
    <a href="{{ url('tingkatlapabsensi') }}">
        <i class="bi bi-circle"></i><span>Laporan Absensi</span>
    </a>
</li>
		   <li>
            <a href='tingkatlapmnsabsen'>
              <i class="bi bi-circle"></i><span>Laporan Jam Minus Absensi</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->
	  
	  <li class="nav-item">
        <a class="nav-link collapsed" href='sso' >
          <i class="bi bi-file-earmark-person"></i>
          <span>Halaman SSO</span>
        </a>
      </li><!-- End SSO Page Nav -->
	  

      <li class="nav-item">
        <a class="nav-link collapsed" href='actionlogout' >
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Logout</span>
        </a>
      </li><!-- End Login Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  @yield('konten')

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Manajemen Informatika<strong>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
     <a href="https://www.polytechnic.astra.ac.id//">Politeknik Astra</a>
    </div>
  </footer><!-- End Footer -->




  

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src='assets/vendor/apexcharts/apexcharts.min.js'></script>
  <script src='assets/vendor/bootstrap/js/bootstrap.bundle.min.js'></script>
  <script src='assets/vendor/chart.js/chart.umd.js'></script>
  <script src='assets/vendor/echarts/echarts.min.js'></script>
  <script src='assets/vendor/quill/quill.min.js'></script>
  <script src='assets/vendor/simple-datatables/simple-datatables.js'></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.13.2/b-2.3.4/b-html5-2.3.4/b-print-2.3.4/datatables.min.js"></script> -->
  <script src='assets/vendor/tinymce/tinymce.min.js'></script>
  <script src='assets/vendor/php-email-form/validate.js'></script>
  <script src='assets/js/sweetalert2.min.js'></script>
   <script src='assets/js/sweetalert2.min.js'></script>
   <script src='assets/js/sweetalert2.min.js'></script>
  <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    
    $('#myTable').DataTable();
    $(document).ready(function () {
      serverSide: true,
      lengthMenu: [[25, 100, -1], [25, 100, "All"]],
      pageLength: 25,
      buttons: [
          {
              extend: 'excel',
              text: '<span class="fa fa-file-excel-o"></span> Excel Export',
              exportOptions: {
                  modifier: {
                      search: 'applied',
                      order: 'applied'
                  }
              }
          }
      ],

    });
  </script>

    <script>
        var flash = $('#flash').data('flash');
        if(flash) {
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: 'Data berhasil ' + flash
            })
        }
    </script>

   
    <script>
        $(document).on('click', '#tombol-hapus', function(e) {
            e.preventDefault();
            var link = $(this).attr('href');

            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Data akan dihapus !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Data!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = link;
                  
                }
            })
        })
		
		$(document).on('click', '#tombol-simpan', function(e) {
            e.preventDefault();
            var link = $(this).attr('href');

            Swal.fire({
                title: 'Apakah Anda yakin ingin menyimpan data?',
                text: "Data yang sudah diinputkan tidak dapat diubah!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Simpan Data!'
            }).then((result) => {
                if (result.isConfirmed) {
                  document.getElementById('formP5M').submit();
                }
            })
        })
    </script> 

  <!-- Template Main JS File -->
  <script src='assets/js/main.js'></script>
  <script src='assets/fontawesome-free/js/fontawesome.min.js' crossorigin='anonymous'></script>

  
</script>
</body>

</html>