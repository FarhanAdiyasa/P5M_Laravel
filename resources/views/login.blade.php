  <!DOCTYPE html>
  <html class=""><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>
    Halaman Login
  </title> <link rel="stylesheet" href='Styles/Style.css'>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
  <form class="polman-form-login" action="{{ route('actionlogin') }}" method="post">
  @csrf

          <h4>Masuk Akun</h4>
          <hr>

          <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" placeholder="username" required="">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="polman-nav-static-bottom">
                Copyright © 2023 - MI Politeknik Astra
            </div>


  <button type="button" onclick="daftarakun(event)" class="btn btn-primary btn-block" style="color: white; width: 100%; margin-top: 10px; margin-bottom: 10px;">Log In</button>

  </form>
    </div>
    </div>
    </div>
    </head>
    <div id="dropDownSelect1"></div>
  </body>
    
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Include SweetAlert2 or use an alternative -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <script>
    function daftarakun(event) {
       event.preventDefault();
   var csrfToken = $('meta[name="csrf-token"]').attr('content');

       // Collect data from the form
       var username = $('[name="username"]').val();
       var katasandi = $('[name="password"]').val();

       var formData =  {
       username: username,
       password: katasandi,
       }
       
   var data = JSON.stringify(formData); 	
       $.ajax({
     url: '{{ route("actionlogin") }}',
           method: 'POST',
     headers: {
       'X-CSRF-TOKEN': csrfToken
     },
           data: data,
     dataType: 'json', 
       contentType: 'application/json', 
     success: function(response) {
       if(response.success === true){
         Swal.fire({
         icon: "success",
         title: response.message,
         showConfirmButton: false,
         timer: 2000
       }).then(() => {
        window.location.href = response.redirect_url;
         
       });
       }else{
                   Swal.fire({
         icon: "error",
         title: response.message,
         showConfirmButton: false,
         timer: 2000
       });
       }
       
           },
     error: function(xhr, status, error, response) {
       console.log(response);  	
       console.log(xhr);  	
       console.log(status); // Log the status
       console.error(error); // Log the error
     }
       });
   }
</script>


  </body>
  </html>

  