@php
    $alimentos = App\Alimento::where('AlimentoEstado',1)->get();
    $unidadesMedida = App\UnidadMedida::all();
@endphp
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Agregar Alimento a Comida</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="comidaId" name="comidaId" value="{{$comida->ComidaId}}">
          
          <label for="alimentoId">Alimentos</label>
          <select class="form-control" id="alimentosPorComida" name="alimentoId" style="width: 100%">
            <option></option>
            @foreach($alimentos as $alimento)
              <option value="{{$alimento->AlimentoId}}">{{$alimento->AlimentoNombre}}</option>
            @endforeach
          </select>
          <input type="text" id ="cantidadNeto" name="cantidadNeto" class="form-control" placeholder="Cantidad Neto" aria-label="Recipient's username" aria-describedby="basic-addon2">
          <input type="hidden" value="Gramo" name="unidadMedida">
        </div>
        <div class="modal-footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-7">
                <div id="labelComprobar" class="alert"></div>
              </div>
              <div class="col-lg-5">
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="button" id="btnGuardar" class="btn btn-sm btn-primary">Guardar Alimento</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>