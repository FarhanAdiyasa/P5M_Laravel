<!DOCTYPE html>
<html lang="en">



<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>P5M Manajemen Informatika</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

<!-- Favicons -->

<link rel="icon" href="{{ asset('assets/img/favicon.png') }}" />
<link rel="icon" type="image/png" href="{{ asset('assets_login/images/icons/icon.ico') }}" />
<link rel="apple-touch-icon" href="{{ asset('assets/img/apple-touch-icon.png') }}" />

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

<!-- Vendor CSS Files -->
<link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet" />
<!-- Uncomment the next line if using the CDN for DataTables -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.2/b-2.3.4/b-html5-2.3.4/b-print-2.3.4/datatables.min.css"/> -->

<!-- Template Main CSS Files -->
<link href="{{ asset('assets/css/stylenew.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/fontawesome/css/all.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet" />
<!-- Include SweetAlert CSS -->
@yield('style')
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10"> --}}
<script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Link Script Swal -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Link CSS Swal -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">


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
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
              Selamat Datang {{ Auth::user()->nama_pengguna }}
          </a>
        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

       

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
         <!--    <img src='assets/img/profile-img.jpg' alt="Profile" class="rounded-circle"> -->
           <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                  </a>


          </a><!-- End Profile Iamge Icon -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->


  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed " href="{{url('sop')}}">
          <i class="bi bi-bar-chart-line"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      @if (session('role') == "KOORDINATOR SOP dan TATIB")
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('user_lihat')}}">
          <i class="bi bi-person-rolodex"></i><span>Pengguna</span>
        
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('libur')}}">
          <i class="bi bi-people"></i><span>Libur</span>
         
        </a>
      </li>
      @endif
          

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('mahasiswa')}}">
          <i class="bi bi-people"></i><span>Mahasiswa</span>
         
        </a>
      </li>


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-postcard"></i><span>Absensi</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          @if (session('role') == "KOORDINATOR SOP dan TATIB")
          <li>
            
            <a href="{{url('daftarAbsensi')}}">
              <i class="bi bi-circle"></i><span>Import Absensi</span>
            </a>
          </li>
          @endif
            <a href="{{url('laporan_absensi')}}">
              <i class="bi bi-circle"></i><span>Laporan Absensi</span>
            </a>
          </li>
          <li>
            <a href="{{url('laporanJamMinusAbsensi')}}">
              <i class="bi bi-circle"></i><span>Laporan Jam Minus Absensi</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-ui-checks-grid"></i><span>Pelanggaran</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          @if(session('role') == "KOORDINATOR SOP dan TATIB")
          <li>
            <a href="{{url('pelanggaran')}}">
              <i class="bi bi-circle"></i><span>Kelola Pelanggaran</span>
            </a>
          </li>
          @endif
          @if ( session('role') != "SEKRETARIS PRODI")
          <li>
            <a href="{{url('p5msop')}}">
              <i class="bi bi-circle"></i><span>P5M</span>
            </a>
          </li>
          @endif
		      <li>
            <a  href="{{url('pilihkls')}}">
              <i class="bi bi-circle"></i><span>History P5M</span>
            </a>
          </li>
          <li>
            <a href='laporan_jam_minus/'>
              <i class="bi bi-circle"></i><span>Laporan Jam Minus P5M</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->
	  
	  <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('sso')}}" >
          <i class="bi bi-file-earmark-person"></i>
          <span>Halaman SSO</span>
        </a>
      </li><!-- End SSO Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="actionlogout" >
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

<!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
<!-- Include SweetAlert JS -->


<!-- Template Main JS Files -->
<script src="{{ asset('assets/js/main.js') }}"></script>
@yield('script')