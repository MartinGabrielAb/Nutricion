
@extends('layouts.plantilla')
@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Administracion de Camas : {{$pieza->PiezaNombre}}</h1>
            <input type="hidden" name="piezaId" id="piezaId" value="{{$pieza->PiezaId}}">
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/salas/{{$pieza->SalaId}}">Piezas</a></li>
              <li class="breadcrumb-item active">Camas</li>
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
                      <button type="button" class="btn btn-sm btn-default" id="btnAgregar" data-toggle="modal" data-target="#modalAgregar">
                        Agregar Cama
                      </button>
              			</p>	
              		</div>
              	</div>
                @include('salas.modal.agregarCama')	
              	<!--------------TABLA PRINCIPAL-------------->
                <div class="row">
                  <div class="col-lg-12">
                    <table id="tableCamas" class="table table-sm table-striped table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                    <!------Cabecera de la tabla------>
                    <thead>
                      <tr>
                        <th>Número de cama</th>
                        <th>Estado</th>
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
<script type="text/javascript" src="{{asset('js/salas/camas.js')}}"></script>
<!-- <script type="text/javascript" src="{{asset('js/salas/createPiezas.js')}}"></script>
 -->
@endpush

@endsection
