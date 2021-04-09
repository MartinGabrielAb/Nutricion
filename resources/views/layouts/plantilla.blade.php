<!DOCTYPE html>
<html lang="en"><head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Programa de Nutrición</title>

  <!-- Font Awesome Icons -->
  <link href="{{asset('plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
  <!-- Theme style -->
  <link href="{{asset('dist/css/adminlte.min.css')}}" rel="stylesheet">
  <!-- DataTables-->
  <!-- <link href="{{asset('dataTables.min.css')}}" rel="stylesheet"> -->
  <link href="{{asset('datatables.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/responsive.dataTables.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">

  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
  

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<?php 
$user = Auth::user()
 ?>
 @include('layouts.navbar')


  @yield('contenido')
<!-- Main Footer -->
  @include('layouts.footer')

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- Data Tables -->
<script src="{{asset('datatables.min.js')}}"></script>
<script  src="{{asset('js/dataTables.responsive.min.js')}}"></script>
<!-- Select2 -->
<script  src="{{asset('js/select2.min.js')}}"></script>

@stack('custom-scripts')

</body></html>