
@extends('layouts.plantilla')
@section('contenido')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{$comida->ComidaNombre}} : Alimentos</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/comidas">Comidas</a></li>
            <li class="breadcrumb-item active">Alimentos por comida</li>
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
              <div class="col">
                  <div id="divMensaje" class="alert text-center p-0">
                    <!-- Mensaje de exito/error -->
                  </div> 
              </div>
              <div class="col">
                  <p class="text-right">
                    <button type="button" class="btn btn-sm btn-default" id="btnAgregar" onClick="agregar()" data-toggle="modal"  data-target="#modal">
                      Agregar alimento
                    </button>
                  </p>	
              </div>
            </div>
              <!--------------TABLA PRINCIPAL-------------->
            <div class="row">
              <div class="col">
                <table id="tableAlimentosPorComida" class="table table-sm table-striped table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                  <!------Cabecera de la tabla------>
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>Alimento</th>
                        <th>Cantidad Neta</th>
                        <th>Cantidad Bruta</th>
                        {{-- <th>Unidad de Medida</th> --}}
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
  
  <div class="container-fluid" >
      <button type="button" class="btn btn-sm btn-default" id="btnNutrientes" onClick="llenarNutrientes({{$comida->ComidaId}})" >
        Mostrar nutrientes
      </button>
    <div class="row">
      <div class="col-lg-12">
        <div class="card" id = "divNutrientes">
          <div class="card-body">
            <table id="tableNutrientes" class="table table-sm table-striped table-bordered table-hover" style="width:100%" cellspacing="0">
              <thead>
                <tr>
                  <th class="text-xs text-center"><small>Alimento</small></th>
                  <th class="text-xs text-center"><small>Cantidad</small></th>
                  @foreach($nutrientes as $nutriente)
                  <th class="text-xs text-center"><small>{{$nutriente->NutrienteNombre}}</small></th>
                  @endforeach
                </tr>
              </thead>
              <tbody id="bodyNutrientes">
              </tbody>
            </table>
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
            <input type="hidden" id="comidaId" name="comidaId" value="{{$comida->ComidaId}}">
            <input type="hidden" id="id" name="id" value="">

            <label for="alimento">Alimentos</label>
            <select class="form-control" style="width: 100%" id="alimento" name="alimento" required>
              <option value="-1"></option>
                @foreach($alimentos as $alimento)
                  <option value="{{$alimento->AlimentoId}}" >{{$alimento->AlimentoNombre}}</option>
                @endforeach
            </select>
            <label for="cantidad">Cantidad neto</label> <small class="un_medida"></small>
            <input type="number" id ="cantidad" name="cantidad" class="form-control" required step="0.01">
            <input type="hidden" value="Gramo" id="unidadMedida" name="unidadMedida">
            <label for="cantidad_bruta">Cantidad bruta <small class="un_medida"></small></label>
            <input type="number" id ="cantidad_bruta" name="cantidad_bruta"   class="form-control" required step="0.01">
            <input type="hidden" value="" id="un_medida_bruta_id" name="un_medida_bruta_id" >
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
<script type="text/javascript" src="{{asset('js/alimentosporcomida/principal.js')}}"></script>
<script type="text/javascript" src="{{asset('js/alimentosporcomida/nutrientes.js')}}"></script>

@endpush

@endsection


