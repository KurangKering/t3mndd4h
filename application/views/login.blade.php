
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; Stisla</title>

  <style>
    body{
      margin: 0;
      padding: 0;
      background: url({{ base_url('assets/img/398368.jpg') }}) 
      no-repeat center center fixed;
      font-family: sans-serif;
     

      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;

    }
    .login-box{
      width: 320px;
      height: 400px;
      background: rgba(0, 0, 0, 0.5);
      color: #fff;
      top: 50%;
      left: 50%;
      position: absolute;
      transform: translate(-50%,-50%);
      box-sizing: border-box;
      padding: 70px 30px;
    }
    .avatar{
      width: 100px;
      height: 100px;
      position: absolute;
      top: -50px;
      left: calc(50% - 50px);
    }
    h1{
      margin: 0;
      padding: 0 0 20px;
      text-align: center;
      font-size: 22px;
    }
    .login-box p{
      margin: 0;
      padding: 0;
      font-weight: bold;
    }
    .login-box input{
      width: 100%;
      margin-bottom: 20px;
    }
    .login-box input[type="text"], input[type="password"]
    {
      border: none;
      border-bottom: 1px solid #fff;
      background: transparent;
      outline: none;
      height: 40px;
      color: #fff;
      font-size: 16px;
    }
    .login-box input[type="submit"]
    {
      border: none;
      outline: none;
      height: 40px;
      background: #1c8adb;
      color: #fff;
      font-size: 18px;
      border-radius: 20px;
    }
  /*  .login-box input[type="submit"]:hover
    {
      cursor: pointer;
      background: #39dc79;
      color: #000;
    }*/

    .login-box a{
      text-decoration: none;
      font-size: 14px;
      color: #fff;
    }
    .login-box a:hover
    {
      color: #39dc79;
    }

  </style>
</head>

<body>
  <div class="login-box">
    <img src="{{ base_url('assets/img/logo.png') }}" class="avatar">
    <h1>Login Page <br> Sistem Informasi Haji</h1>
    <form id="form-login">
      <p>Username</p>
      <input type="text" required id="username" name="username" placeholder="">
      <p>Password</p>
      <input type="password" required id="password" name="password" placeholder="">
      <input type="submit" name="submit" value="Login">
    </form>


  </div>

  <!-- General JS Scripts -->
  <script src="{{ base_url('assets/modules/jquery.min.js') }}"></script>
  <script src="{{ base_url('assets/modules/popper.js') }}"></script>
  <script src="{{ base_url('assets/modules/tooltip.js') }}"></script>
  <script src="{{ base_url('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ base_url('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ base_url('assets/axios.min.js') }}"></script>
  <script src="{{ base_url('assets/sweetalert2.all.min.js') }}"></script>
  <script src="{{ base_url('assets/modules/moment.min.js') }}"></script>
  <script src="{{ base_url('assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->

  <!-- Page Specific JS File -->

  <!-- Template JS File -->

  <script>
    $(function() {

      $btn_login = $("#btn-login");
      $username = $("#username");
      $password = $("#password");

      $("#form-login").submit(function(e) {

        e.preventDefault();

        $(this).find(':submit').attr('disabled','disabled');


        let post_data = {
          username: $username.val(),
          password: $password.val(),
        };

        post_data = Object.keys(post_data).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(post_data[key])).join('&')

        axios.post("{{ base_url("auth/login") }}", post_data)
        .then((res) => {
          $(this).find(':submit').attr('disabled',false);


          response = res.data;

          if (response.success == 0) {
           Swal.fire({
            title: 'Gagal!',
            text: response.message,
            icon: 'error',
            timer: 1000,
            showConfirmButton: false,

          });
         } else {
          window.location.href = "{{ base_url('') }}";
        }

      })
        .catch(() => {
          $(this).find(':submit').attr('disabled',false);


        })

      });


    });
  </script>
</body>
</html>