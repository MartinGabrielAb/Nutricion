@extends('layouts.plantilla')
@section('contenido')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Comidas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Comidas</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- Main content -->
  <div class="container-fluid">
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
              <div class="col">
                  <p class="text-right">
                    <button type="button"  class="btn btn-sm btn-outline-primary" id="btnAgregar" onClick="agregar()" data-toggle="modal"  data-target="#modal">
                      Agregar comida
                    </button>
                  </p>	
              </div>
            </div>
              <!--------------TABLA PRINCIPAL-------------->
            <div class="row">
              <div class="col">
                <table id="tableComidas" class="table table-sm table-striped table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                  <!------Cabecera de la tabla------>
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>Comida</th>
                        <th>Tipo</th>
                        <th width="10%">Acciones</th>
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
          <label for='nombre' id="labelNombre">Nombre</label>
          <input class="form-control" type="text" id="nombre" name="nombre" required minlength="1" maxlength="64">
          <label for="tipo">Tipo de comida</label>
          <select class="form-control" id="tipo" name="tipo" required>
            @foreach($tiposComida as $tipoComida)
              <option value="{{$tipoComida->TipoComidaId}}">{{$tipoComida->TipoComidaNombre}}</option>
            @endforeach
          </select>
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
<script type="text/javascript" src="{{asset('js/comidas/principal.js')}}"></script>

@endpush

@endsection


