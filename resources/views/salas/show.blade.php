
@extends('layouts.plantilla')
@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Administracion de Piezas : {{$sala->SalaNombre}}</h1>
            <input type="hidden" name="salaId" id="salaId" value="{{$sala->SalaId}}">
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/salas">Salas</a></li>
              <li class="breadcrumb-item active">Piezas</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
      <div class="container-fluid">
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
                      <input type="hidden" name="salaId" id="salaId" value="{{$sala->SalaId}}">
                      <button type="button" class="btn btn-sm btn-default" id="btnAgregarPieza" data-toggle="modal" data-target="#modalAgregar">
                        Agregar Pieza
                      </button>
              			</p>	
              		</div>
              	</div>
                @include('salas.modal.agregarPieza')	
              	<!--------------TABLA PRINCIPAL-------------->
                <div class="row">
                  <div class="col-lg-12">
                    <table id="tablePiezas" class="table table-sm table-striped table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                    <!------Cabecera de la tabla------>
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Pieza</th>
                        <th>Camas</th>
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
@push('custom-scripts')
<script type="text/javascript" src="{{asset('js/salas/piezas.js')}}"></script>
<!-- <script type="text/javascript" src="{{asset('js/salas/createPiezas.js')}}"></script>
 -->
@endpush

@endsection
