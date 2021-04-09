@php
    $alimentos = App\Alimento::where('AlimentoEstado',1)->get();
    $unidadesMedida = App\UnidadMedida::all();
@endphp
<div class="modal fade" id="modalEditarAlimentoPorComida{{$AlimentoPorComidaId}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Editar Alimento a Comida</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="comidaId{{$AlimentoPorComidaId}}" name="comidaId{{$AlimentoPorComidaId}}" value="{{$ComidaId}}">
          <label for="alimentoId">Alimentos</label>
          <select class="form-control" id="alimentosPorComida{{$AlimentoPorComidaId}}" name="alimentoId{{$AlimentoPorComidaId}}" style="width: 100%" onchange="editarAlimentoPorComidaUnidadMedida({{$unidadesMedida}},{{$alimentos}},{{$AlimentoPorComidaId}})">
            <option></option>
            @foreach($alimentos as $alimento)
              <option value="{{$alimento->AlimentoId}}" {{ $alimento->AlimentoId == $AlimentoId ? 'selected': '' }}>{{$alimento->AlimentoNombre}}</option>
            @endforeach
          </select>
          <input type="text" id ="cantidadNeto{{$AlimentoPorComidaId}}" name="cantidadNeto{{$AlimentoPorComidaId}}" class="form-control" value="{{$AlimentoPorComidaCantidadNeto}}" placeholder="Cantidad Neto" aria-label="Recipient's username" aria-describedby="basic-addon2">
          <div class="unidadMedida">      
                  <select class="form-control" id="selectUnidadMedida{{$AlimentoPorComidaId}}" name="selectUnidadMedida{{$AlimentoPorComidaId}}">
                          <option id="option1{{$AlimentoPorComidaId}}"></option>
                          <option id="option2{{$AlimentoPorComidaId}}"></option>
                          <option id="option3{{$AlimentoPorComidaId}}"></option>
                  </select>
          </div>
        </div>
        <div class="modal-footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-7">
                <div id="labelComprobar{{$AlimentoPorComidaId}}" class="alert"></div>
              </div>
              <div class="col-lg-5">
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="button" id="btnGuardar{{$AlimentoPorComidaId}}" class="btn btn-sm btn-primary btnEditar" data-id="{{$AlimentoPorComidaId}}">Editar Alimento</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>