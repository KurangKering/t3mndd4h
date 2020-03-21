
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ base_url('assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ base_url('assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ base_url('assets/modules/bootstrap-social/bootstrap-social.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ base_url('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ base_url('assets/css/components.css') }}">
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              {{-- <img src="{{ base_url('assets/img/stisla-fill.svg') }}" alt="logo" width="100" class="shadow-light rounded-circle"> --}}
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Login</h4></div>

              <div class="card-body">
                <form id="form-login">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input required id="username" type="username" class="form-control" name="username" tabindex="1" required autofocus>
                    
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Password</label>
                      
                    </div>
                    <input required id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    
                  </div>

                  

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
                
                

              </div>
            </div>
            
            <div class="simple-footer">
              Copyright &copy; Stisla 2018
            </div>
          </div>
        </div>
      </div>
    </section>
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