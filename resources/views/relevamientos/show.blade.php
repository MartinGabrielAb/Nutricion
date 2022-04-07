

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
            <h4 class="m-0 text-dark">Relevamiento por salas</h4>
          </div><!-- /.col -->
          <div class="col-lg-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/relevamientos">Relevamientos</a></li>
              <li class="breadcrumb-item active">Relevamiento por salas</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <div class="row">
          <div class="col-lg-6 text-center">
            <h5 class="m-0">{{$relevamiento->RelevamientoFecha}}</h5>
          </div>
          <div class="col-lg-6 text-center">
            <h5 class="m-0">{{$relevamiento->RelevamientoTurno}}</h5>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
  <div class="container-fluid">
    <input type="text" hidden value="{{$relevamiento->RelevamientoId}}" id="relevamiento_id">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col" >
                  <div id="divMensaje" class="alert text-center p-0">
                    <!-- Mensaje de exito/error -->
                  </div> 
              </div>
            </div>
              <!--------------TABLA PRINCIPAL-------------->
            <div class="row">
              <div class="col">
                <table id="salas_por_relevamiento" class="table table-sm table-striped table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                  <!------Cabecera de la tabla------>
                  <thead>
                    <tr>
                      <th scope="col" width="5%">#</th>
                      <th scope="col">Sala</th>
                      <th scope="col" width="5%">Acciones</th>
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
    </div>
  </div>
    
</div>
<!-- /.content-wrapper -->

<!-- Modal para agregar y editar  -->

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form onSubmit="guardar(event)">
      <div class="modal-content">
        <div class="modal-header">
          <span class="modal-title" id="tituloModal"></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>    
        <div class="modal-body">
          <input type="hidden" id="id" name="id">
          <label for="salas">Salas</label>
          <div class="form-inline">
            <select class="form-control" id="salas" name="salas" style="width: 100%" required>
              @foreach ($salas as $sala)
                <option value="{{$sala->SalaId}}">{{$sala->SalaNombre}}</option>
              @endforeach  
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col">
                <button type="submit" id="btnGuardar" class="btn btn-sm btn-primary w-100"><i class="fas fa-check"></i><span> </span></button>
              </div>
            </div>
            <div class="row">
              <div class="col">
               <button type="button" class="btn btn-sm btn-secondary w-100" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
              </div>
            </div>
            <div class="row">
              <div class="col text-danger" id="divComprobar">
                  <!-- Lista de errores -->
                  <ul id = "listaErrores"></ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@push('custom-scripts')
  <script type="text/javascript" src="{{asset('js/relevamientos/show.js')}}"></script>
@endpush

@endsection
