<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Agregar nutrientes: {{$alimento->AlimentoNombre}}</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small>Los nutrientes son valores por cada 100g de {{$alimento->AlimentoNombre}}<small>
        @foreach($nutrientes as $nutriente)
        <div class="input-group input-group-sm mb-2">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm">{{$nutriente->NutrienteNombre}}</span>
          </div>
          <input type="number" class="form-control" id="{{$nutriente->NutrienteId}}" name="nutrientes[]" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
          <div class="input-group-append">
            <span class="input-group-text" id="basic-addon2">{{$nutriente->UnidadMedidaNombre}}</span>
          </div>
        </div>
        @endforeach
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-7">
              <div id="labelComprobar" class="alert"></div>
            </div>
            <div class="col-lg-5">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" id="btnGuardar" class="btn btn-sm btn-primary">Registrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>