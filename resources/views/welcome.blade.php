<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Civinautas</title>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link id="gull-theme" rel="stylesheet" href="assets/styles/css/themes/lite-purple.min.css">
  <link rel="stylesheet" href="assets/styles/vendor/perfect-scrollbar.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
  <!-- -->
</head>

<body>
  <div class="auth-layout-wrap" style="background-image: url({{ asset('images/index/background_index.jpg') }})">
    <div class="auth-content">
      <div class="card o-hidden" style="background-color: rgba(255,255,255,0.9)">
        <div class="row">
          <div class="col-md-5 text-center" style="background-size: cover; background-image: url({{ asset('images/index/patrimonio.jpg') }})">
            <div class="row">
              <div class="col-lg-12 text-center">
                <br><br>
              </div>
            </div>            
          </div>
          <div class="col-md-7">
            <br>            
            <img src="{{ asset('images/index/logo_idpc.png') }}" class="img-fluid">
            <br><br>
            <div class="row">
              <div class="col-lg-12 text-center">
                <h4><strong>SISTEMA DE INFORMACIÓN<br>CIVINAUTAS</strong></h4>
              </div>
            </div>
            <div class="card o-hidden col-md-10 offset-md-1">
              <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-12 text-center">
                        <h4>Iniciar sesión</h4>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12 mt-3">
                        <label for="email">Usuario</label>
                        <input id="email" type="email" class="form-control form-control-rounded @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="password">{{ __('Contraseña') }}</label>
                        <input id="password" type="password" class="form-control form-control-rounded @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6 offset-md-3">
                        <button type="submit" class="btn btn-block btn-primary">
                          {{ __('Ingresar') }}
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-8 offset-md-2">
                        @if (Route::has('password.request'))
                        <a class="btn btn-block btn-link" href="{{ route('password.request') }}">
                          {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                        @endif
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div><br>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="assets/js/es5/script.min.js"></script>
  <script src="assets/js/es5/sidebar.large.script.min.js"></script>
  <script src="assets/js/vendor/sweetalert2.min.js"></script> 
</body>

</html>