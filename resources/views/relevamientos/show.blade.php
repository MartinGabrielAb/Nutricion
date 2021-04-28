

@extends('layouts.plantilla')
@section('contenido')
<?php 
  $user = Auth::user();
 ?>
<input type="hidden" name="usuarioId" id="usuarioId" value="{{$user->id}}">
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <h2 class="m-0 text-dark">Detalle de Relevamiento:</h2>
          </div><!-- /.col -->
          <div class="col-lg-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/relevamientos">Relevamientos</a></li>
              <li class="breadcrumb-item active">Detalle de Relevamiento</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <div class="row">
            <div class="col-lg-6">
              <h5>Relevamiento: {{$relevamiento->RelevamientoId}}</h5>
            </div>
            <div class="col-lg-6">
              <h5>Fecha: {{$relevamiento->RelevamientoFecha}}</h5>
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

@push('custom-scripts')
<!-- Scripts actuales -->
{{-- <script type="text/javascript" src="{{asset('js/detallesrelevamiento/principal.js')}}"></script>
<script type="text/javascript" src="{{asset('js/detallesrelevamiento/create.js')}}"></script>
<script type="text/javascript" src="{{asset('js/detallesrelevamiento/eliminar.js')}}"></script>
<script type="text/javascript" src="{{asset('js/detallesrelevamiento/editar.js')}}"></script> --}}

@endpush
