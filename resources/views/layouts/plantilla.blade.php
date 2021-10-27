<!DOCTYPE html>
<html lang="ES">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{asset('dist/img/logoHSB.png')}}">

    <title>Programa de Nutrición</title>
    
    <link href="{{asset('plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('dist/css/adminlte.min.css')}}" rel="stylesheet">
    <link href="{{asset('datatables.min.css')}}" rel="stylesheet">
    <link href="/public/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">

  </head>
  <body class="hold-transition sidebar-mini">
  <div id="app">
    
        <?php $user = Auth::user() ?>
      @include('layouts.navbar')
      @yield('contenido')
      @include('layouts.footer') 
    <!-- REQUIRED SCRIPTS -->
  </div>
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <script src="{{asset('datatables.min.js')}}"></script>
    <script  src="{{asset('js/dataTables.responsive.min.js')}}"></script>
    <script  src="{{asset('js/select2.min.js')}}"></script>
    @stack('custom-scripts')
    <script src="{{asset('js/app.js')}}"></script> 
  </body>
</html>