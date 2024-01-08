  <!DOCTYPE html>
  <html class=""><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>
    Halaman Login
  </title> <link rel="stylesheet" href='Styles/Style.css'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->	
    <link rel="icon" type="image/png" href='assets_login/images/icons/icon.ico'>
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href='assets_login/vendor/bootstrap/css/bootstrap.min.css'>
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href='assets_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css'>
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href='assets_login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css'>
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href='assets_login/vendor/animate/animate.css'>
  <!--===============================================================================================-->	
    <link rel="stylesheet" type="text/css" href='assets_login/vendor/css-hamburgers/hamburgers.min.css'>
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href='assets_login/vendor/animsition/css/animsition.min.css'>
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href='assets_login/vendor/select2/select2.min.css'>
  <!--===============================================================================================-->	
    <link rel="stylesheet" type="text/css" href='assets_login/vendor/daterangepicker/daterangepicker.css'>
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href='assets_login/css/util.css'>
    <!-- <link rel="stylesheet" type="text/css" href='assets_login/css/mains.css'> -->
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Nunito:300,300i,400,600,800'>
        
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" crossorigin="anonymous" href='https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU'>
        
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href='assets/css/main.css'>
        
    <!-- Animation CSS -->
    <link rel="stylesheet" type="text/css" href='assets/css/vendor/aos.css'>

  </head>
      
  <body style="background-repeat: no-repeat; background-size: cover; background-image: url('assets_login/images/IMG_Background.jpg');">

    <div class="polman-nav-static-top" style="opacity: 0.9;">
                        <div class="float-left">
    <img src='assets_login/images/IMG_Logo.png' style="height: 40px; margin-top: 5px;"></a>                   
                      </div>
                  </div>

  <!-- 	Main -->
  <div class="limiter">
  <br>
  <br>
  <br>
  <br>
  @if(session('error'))
              <div class="alert alert-danger">
                  <b>Opps!</b> {{session('error')}}
              </div>
              @endif

  <form class="polman-form-login" action="{{ route('actionlogin') }}" method="post">
  @csrf

          <h4>Masuk Akun</h4>
          <hr>
          <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" placeholder="email" required="">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="polman-nav-static-bottom">
                Copyright © 2023 - MI Politeknik Astra
            </div>

  <button type="submit" class="btn btn-primary btn-block" style="color: white; width: 100%; margin-top: 10px; margin-bottom: 10px;">Log In</button>
  </form>
    </div>
    </div>
    </div>
    </head>
    <div id="dropDownSelect1"></div>
  </body>
    
  <!--===============================================================================================-->
    <script src='assets_login/vendor/jquery/jquery-3.2.1.min.js'></script>
  <!--===============================================================================================-->
    <script src='assets_login/vendor/animsition/js/animsition.min.js'></script>
  <!--===============================================================================================-->
    <script src='assets_login/vendor/bootstrap/js/popper.js'></script>
    <script src='assets_login/vendor/bootstrap/js/bootstrap.min.js'></script>
  <!--===============================================================================================-->
    <script src='assets_login/vendor/select2/select2.min.js'></script>
  <!--===============================================================================================-->
    <script src='assets_login/vendor/daterangepicker/moment.min.js'></script>
    <script src='assets_login/vendor/daterangepicker/daterangepicker.js'></script>
  <!--===============================================================================================-->
    <script src='assets_login/vendor/countdowntime/countdowntime.js'></script>
  <!--===============================================================================================-->
    <script src='assets_login/js/main.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/swal/sweetalert2@11.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <!-- Include jQuery or use an alternative -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Include SweetAlert2 or use an alternative -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>




  </body>
  </html>