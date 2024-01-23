<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>P5M Manajemen Informatika</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="icon" type="image/png" href="assets_login/images/icons/icon.ico">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/stylesso.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!--Export-->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <!--End Export-->
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

      <div class="d-flex align-items-center justify-content-between">
          <a href="index.html" class="logo d-flex align-items-center">
              <img src="~/Content/assets/img/himma.png" alt="">
              <span class="d-none d-lg-block">P5M</span>
          </a>
          <i class="bi bi-list toggle-sidebar-btn"></i>
      </div><!-- End Logo -->

      <nav class="header-nav ms-auto">
          <ul class="d-flex align-items-center">

              <li class="nav-item d-block d-lg-none">

              </li><!-- End Search Icon-->



              <li class="nav-item dropdown pe-3">

                  <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                      Selamat Datang {{ Auth::user()->nama_pengguna }}
                  </a>
          </ul>

      </nav>

  </header><!-- End Header -->
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
      <ul class="sidebar-nav" id="sidebar-nav">
          <li class="nav-item">
              <a class="nav-link collapsed" href="javascript:void(0);" onclick="refreshPage()">
                  <i class="bi bi-grid"></i>
                  <span>Home</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link collapsed" asp-controller="Login" asp-action="Logout">
                  <i class="bi bi-box-arrow-in-right"></i>
                  <span>Logout</span>
              </a>
          </li>
      </ul>
  </aside><!-- End Sidebar-->

  <main id="main" class="main">
          <div class="pagetitle">
      <nav class="page-breadcrumb">
          <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#" onclick="refreshPage()" class="text-primary">Single Sign On Application</a></li>
              <li class="breadcrumb-item active" aria-current="page"><a >Home</a></li>
          </ol>
      </nav>
  </div><!-- End Page Title -->
  <div class="accordion" id="accordionApp">
  <div class="card z-depth-0" style="border: solid 1px #CCC;">
      <div class="card-header" id="heading0" data-toggle="collapse" data-target="#collapse0" aria-expanded="false" aria-controls="collapse0" style="cursor: pointer; background-color:#F7F7F9; max-height:3rem; align-items:center">
          <h5 class="mb-0" style="margin-top: -0.5rem">
              <button class="btn btn-link collapsed text-primary menuapp waves-effect waves-light" type="button" style="font-weight: bold; text-decoration:none">Sistem Pertemuan 5 Menit</button>
          </h5>
      </div>
      <div id="collapse0" class="collapse mt-2" aria-labelledby="heading0" data-parent="#accordionApp">
          <div class="card-body">
              <ul class="list-group">
                @if(session()->has('roles'))
                @foreach(session('roles') as $role)
                <a href="/pelanggaran">
                  <li class="list-group-item list-group-item-action my-1" style="cursor: pointer;">
                   Login sebagai {{ $role }}
                  </li>
                </a>
                @endforeach
               @endif
              </ul>
          </div>
      </div>
   </div>
</div>

  </main><!-- End #main -->
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
      <div class="copyright">
          &copy; Manajemen <strong>Informatika</strong>
          <div class="credits">
              <a href="https://www.polytechnic.astra.ac.id//">Politeknik Astra</a>
          </div>
      </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>



  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
  
  <script>
    function refreshPage() {
        location.reload();
    }
</script>
</body>

