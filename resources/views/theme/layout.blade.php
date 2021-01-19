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
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />

  <link rel="stylesheet" href="{{ asset('assets/styles/css/themes/lite-purple.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/styles/vendor/perfect-scrollbar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/styles/vendor/sweetalert2.min.css') }}">
  <style type="text/css">
    .rojo {
      color: red;
    }
  </style>

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
      <div class="breadcrumb"><br><br>
      </div>

      @section('principal')

      <div class="separator-breadcrumb border-top"></div>

      <div class="form-group">
        <div class="row">
          <div class="col-lg-4">
            <span>Seleccione un año:</span>
            <select id="filtro-anio">
              <option value="2020">2020</option>
              <option value="2021">2021</option>
            </select>
          </div>    
        </div>
      </div>

      <div class="row">
        <!-- ICON BG -->
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
              <i class="fas fa-4x fa-school"></i>
              <div class="content">
                <p class="text-muted mt-2 mb-0">COLEGIOS</p>
                <p class="text-primary text-24 line-height-1 mb-2" id="cantidad-colegios"></p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
              <i class="fas fa-4x fa-users"></i>
              <div class="content">
                <p class="text-muted mt-2 mb-0">GRUPOS</p>
                <p class="text-primary text-24 line-height-1 mb-2" id="cantidad-grupos"></p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
              <i class="fas fa-4x fa-user"></i>
              <div class="content">
                <p class="text-muted mt-2 mb-0">BENEFICIARIOS</p>
                <p class="text-primary text-24 line-height-1 mb-2" id="cantidad-beneficiarios"></p>
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
              <div class="form-group">
                <div class="row">
                  <div class="col-lg-12">
                    <div id="echart-total-atenciones" style="height: 300px;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-12">
          <div class="card mb-4">
            <div class="card-body">
              <div class="card-title">Total beneficiarios SIMAT por género</div>
              <div class="form-group">
                <div class="row">
                  <div class="col-lg-12">
                    <div id="echart-beneficiarios-por-genero" style="height: 300px;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8 col-md-12">
          <div class="card mb-4">
            <div class="card-body">
              <div class="card-title">Total beneficiarios atendidos por ciclo vital</div>
              <div class="form-group">
                <div class="row">
                  <div class="col-lg-12">
                    <div id="echart-total-beneficiarios-ciclo-vital" style="height: 300px;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-12">
          <div class="card mb-4">
            <div class="card-body">
              <div class="card-title">Total beneficiarios atendidos por género</div>
              <div id="echart-beneficiarios-atendidos-por-genero" style="height: 300px;"></div>
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
<script src="{{ asset ('js/home/home.js?v=2020.12.24.02') }}" defer></script>
<script src="../../node_modules/pdfmake/build/pdfmake.js" ></script>
<script src="../../node_modules/pdfmake/build/vfs_fonts.js" ></script>
<!-- <script src="{{ asset ('assets/js/vendor/bootstrap.bundle.min.js') }}"></script> -->
<script src="{{ asset ('assets/js/vendor/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset ('assets/js/vendor/echarts.min.js') }}"></script>
<script src="{{ asset ('assets/js/es5/echart.options.min.js') }}"></script>
<script src="{{ asset ('assets/js/es5/dashboard.v1.script.min.js') }}"></script>
<script src="{{ asset ('assets/js/es5/script.min.js') }}"></script>
<script src="{{ asset ('assets/js/es5/sidebar.large.script.min.js') }}"></script>
<script src="{{ asset ('assets/js/vendor/sweetalert2.min.js') }}"></script>
<script src="{{ asset ('assets/js/sweetalert.script.js') }}"></script>
<script src="{{ asset ('assets/js/jquery.validate.min.js') }}"></script>
<script src="https://cdn.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://cdn.amcharts.com/lib/3/ammap.js"></script>

</body>

</html>