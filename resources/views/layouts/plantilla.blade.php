<!DOCTYPE html>
<html lang="ES">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/dist/img/logoHSB.png">

    <title>Programa de Nutrición</title>

    <link href="/plugins/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="/dist/css/adminlte.min.css" rel="stylesheet">
    <link href="/datatables.min.css" rel="stylesheet">
    <link href="/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="/css/select2.min.css" rel="stylesheet">

  </head>
  <body class="hold-transition sidebar-mini">
  <div id="app">
    
        <?php $user = Auth::user() ?>
      @include('layouts.navbar')
      @yield('contenido')
      @include('layouts.footer') 
    <!-- REQUIRED SCRIPTS -->
  </div>
    <script src="/plugins/jquery/jquery.min.js"></script>
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/dist/js/adminlte.min.js"></script>
    <script src="/datatables.min.js"></script>
    <script  src="/js/dataTables.responsive.min.js"></script>
    <script  src="/js/select2.min.js"></script>
    @stack('custom-scripts')
    <script src="/js/app.js"></script> 
  </body>
</html>