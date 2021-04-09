

@extends('layouts.plantilla')
@section('contenido')
<?php 
  $user = Auth::user();
  $historial = App\Historial::where('HistorialEstado',1)->where('HistorialFecha',$relevamiento->RelevamientoFecha)->where('HistorialTurno',$relevamiento->RelevamientoTurno)->get();
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
            <div class="col-lg-5">
              <h5>Relevamiento: {{$relevamiento->RelevamientoId}}</h5>
            </div>
            <div class="col-lg-5">
              <h5>Fecha: {{$relevamiento->RelevamientoFecha}}</h5>
            </div>
            <div class="col-lg-2">
              <h5>Turno: {{$relevamiento->RelevamientoTurno}}</h5>
            </div>
          </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="container-fluid">
      <input type="hidden" id="relevamientoId" value="{{$relevamiento->RelevamientoId}}">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-8" style="height: 5px">
                  <div id="divMensaje" class="alert">
                  </div>
                </div>
                <div class="col-lg-4">
                    <p class="text-right">
                      <button type="button" class="btn btn-sm btn-default" id="btnAgregar" data-toggle="modal" data-target="#modalAgregarDetalleRelevamiento">
                        Iniciar Relevamiento a Paciente
                      </button>
                    </p>
                    @include('relevamientos.modal.agregarDetalleRelevamiento')
                </div>
              </div>
              <!--------------TABLA PRINCIPAL-------------->
              <div class="row">
                <div class="col-lg-12">
                  <table id="tableDetallesRelevamiento" class="table table-sm table-striped table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                    <!------Cabecera de la tabla------>
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">TipoPaciente</th>
                        <th scope="col">Sala/Pieza/Cama</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Observaciones</th>
                        <th scope="col">Diagnóstico</th>
                        <th scope="col">Acompañante</th>
                        <th scope="col">Relevador</th>
                        <th width="10%">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col-md-6 -->
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-wrapper -->


@endsection

@push('custom-scripts')
<!-- Scripts actuales -->
<script type="text/javascript" src="{{asset('js/detallesrelevamiento/principal.js')}}"></script>
<script type="text/javascript" src="{{asset('js/detallesrelevamiento/create.js')}}"></script>
<script type="text/javascript" src="{{asset('js/detallesrelevamiento/eliminar.js')}}"></script>
<script type="text/javascript" src="{{asset('js/detallesrelevamiento/editar.js')}}"></script>

@endpush
