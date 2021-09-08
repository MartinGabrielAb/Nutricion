@extends('layouts.plantilla')
@section('contenido')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Nutrientes : {{$alimento->AlimentoNombre}}</h1>
          <input type="hidden" id="alimentoId" value="{{$alimento->AlimentoId}}">
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/alimentos">Alimentos</a></li>
            <li class="breadcrumb-item active">Nutrientes</li>
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
                    <button type="button" class="btn btn-sm btn-outline-primary" id="btnAgregar"  data-toggle="modal"  data-target="#modal">
                      Agregar nutrientes
                    </button>
                  </p>	
              </div>
            </div>
              <!--------------TABLA PRINCIPAL-------------->
            <div class="row">
              <div class="col">
                <table id="tableNutrientes" class="table table-sm table-striped table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                  <!------Cabecera de la tabla------>
                  <thead>
                    <tr>
                        <th>Nutriente</th>
                        <th>Cantidad</th>
                        <th>Unidad de medida</th>

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
          <span class="modal-title" id="tituloModal">Guardar / editar nutrientes</span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>    
        <div class="modal-body">
          @if($alimento->UnidadMedidaNombre == 'Litro' )
            <small>Los nutrientes son valores por cada 100 cm3 de {{$alimento->AlimentoNombre}}<small>
          @else
            @if($alimento->UnidadMedidaNombre == 'Unidad' )
              <small>Los nutrientes son valores por cada unidad de {{$alimento->AlimentoNombre}}<small>
            @else
              <small>Los nutrientes son valores por cada 100g de {{$alimento->AlimentoNombre}}<small>
            @endif
          @endif
          @if(count($nutrientesPorAlimento) ==0)
            @foreach($nutrientes as $nutriente)
            <div class="input-group input-group-sm mb-2">
              <div class="input-group-prepend">
                <span class="input-group-text" id="$nutriente->NutrienteNombre">{{$nutriente->NutrienteNombre}}</span>
              </div>
              <input type="number" class="form-control" id="{{$nutriente->NutrienteId}}" name="nutrientes[]" required>
              <div class="input-group-append">
                <span class="input-group-text" id="basic-addon2">{{$nutriente->UnidadMedidaNombre}}</span>
              </div>
            </div>
            @endforeach
          @else
            @foreach($nutrientesPorAlimento as $nutriente)
            <div class="input-group input-group-sm mb-2">
              <div class="input-group-prepend">
                <span class="input-group-text" id="$nutriente->NutrienteNombre">{{$nutriente->NutrienteNombre}}</span>
              </div>
              <input type="number" class="form-control" id="{{$nutriente->NutrienteId}}" value="{{$nutriente->NutrientePorAlimentoValor}}" name="nutrientes[]" required>
              <div class="input-group-append">
                <span class="input-group-text" id="basic-addon2">{{$nutriente->UnidadMedidaNombre}}</span>
              </div>
            </div>
            @endforeach
          @endif
        </div>
        <div class="modal-footer">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col">
                <button type="submit" id="btnGuardar" class="btn btn-sm btn-primary w-100"><i class="fas fa-check"></i><span>Guardar </span></button>
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
<script type="text/javascript" src="{{asset('js/nutrientesporalimento/principal.js')}}"></script>

@endpush

@endsection

