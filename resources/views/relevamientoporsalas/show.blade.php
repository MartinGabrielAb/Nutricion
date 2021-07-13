

@extends('layouts.plantilla')
@section('contenido')
<?php 
  $user = Auth::user();
 ?>
<input type="hidden" name="usuarioId" id="usuarioId" value="{{$user->id}}">
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header border">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <h4 class="m-0 text-dark">Detalle de Relevamiento</h4>
          </div><!-- /.col -->
          <div class="col-lg-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/relevamientos">Relevamientos</a></li>
              <li class="breadcrumb-item active">Detalle de Relevamiento</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <div class="row">
          <div class="col-lg-4 text-center">
            <h5 class="m-0">{{$relevamiento_por_salas->RelevamientoFecha}}</h5>
          </div>
          <div class="col-lg-4 text-center">
            <h5 class="m-0">{{$relevamiento_por_salas->SalaPseudonimo}}</h5>
          </div>
          <div class="col-lg-4 text-center">
            <h5 class="m-0">{{$relevamiento_por_salas->RelevamientoTurno}}</h5>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    {{-- Detalles de relevamiento --}}
    @include('detallesrelevamiento.principal')
  </div>
  <!-- /.content-wrapper -->


@endsection
