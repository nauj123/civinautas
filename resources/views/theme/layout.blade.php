<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Gull - Laravel + Bootstrap 4 admin template</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/styles/css/themes/lite-purple.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/styles/vendor/perfect-scrollbar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/styles/vendor/sweetalert2.min.css') }}">

  @yield('js-import')
</head>

<body class="text-left">
  <!-- Pre Loader Strat  -->
  <div class='loadscreen' id="preloader">

    <div class="loader spinner-bubble spinner-bubble-primary">



    </div>
  </div>
  <!-- Pre Loader end  -->
  <div class="app-admin-wrap layout-sidebar-large clearfix">

    @include("theme/header")
    @include("theme/aside")


    <!-- ============ Body content start ============= -->
    <div class="main-content-wrap sidenav-open d-flex flex-column">    
      <div class="breadcrumb"><br><br></div>
      @section('principal')
      <div class="separator-breadcrumb border-top"></div>

      <div class="row">
        <!-- ICON BG -->
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
              <i class="i-Video-Photographer"></i>
              <div class="content">
                <p class="text-muted mt-2 mb-0">COLEGIOS</p>
                <p class="text-primary text-24 line-height-1 mb-2">205</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
              <i class="i-Loading-3"></i>
              <div class="content">
                <p class="text-muted mt-2 mb-0">GRUPOS</p>
                <p class="text-primary text-24 line-height-1 mb-2">123</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
              <i class="i-Administrator"></i>
              <div class="content">
                <p class="text-muted mt-2 mb-0">BENEFICIARIOS</p>
                <p class="text-primary text-24 line-height-1 mb-2">2000</p>
              </div>
            </div>
          </div>
        </div>


      </div>
      <div class="row">
        <div class="col-lg-8 col-md-12">
          <div class="card mb-4">
            <div class="card-body">
              <div class="card-title">Total de atenciones por mes</div>
              <div id="echartBar" style="height: 300px;"></div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-12">
          <div class="card mb-4">
            <div class="card-body">
              <div class="card-title">Enfoque poblacional</div>
              <div id="echartPie" style="height: 300px;"></div>
            </div>
          </div>
        </div>
      </div>
      @show
      @yield('contenido')
    </div>


  </div>
</div>
<script src="{{ asset ('assets/js/vendor/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/home/home.js') }}" defer></script>
<!-- <script src="{{ asset ('assets/js/vendor/bootstrap.bundle.min.js') }}"></script> -->
<script src="{{ asset ('assets/js/vendor/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset ('assets/js/vendor/echarts.min.js') }}"></script>
<script src="{{ asset ('assets/js/es5/echart.options.min.js') }}"></script>
<script src="{{ asset ('assets/js/es5/dashboard.v1.script.min.js') }}"></script>
<script src="{{ asset ('assets/js/es5/script.min.js') }}"></script>
<script src="{{ asset ('assets/js/es5/sidebar.large.script.min.js') }}"></script>
<script src="{{ asset ('assets/js/vendor/sweetalert2.min.js') }}"></script>
<script src="{{ asset ('assets/js/sweetalert.script.js') }}"></script> 
</body>

</html>