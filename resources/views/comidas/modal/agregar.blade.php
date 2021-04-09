@php
    $tiposComida = App\TipoComida::all();
@endphp
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Agregar Comida</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for='nombreComida' id="labelNombre">Nombre</label>
          <input class="form-control" type="text" id="nombreComida" name="nombreComida" required>
          <label for="tipoComida">Tipo de comida</label>
          <select class="form-control" id="tipoComida" name="tipoComida">
            @foreach($tiposComida as $tipoComida)
              <option value="{{$tipoComida->TipoComidaId}}">{{$tipoComida->TipoComidaNombre}}</option>
            @endforeach
          </select>
        </div>
        <div class="modal-footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-7">
                <div id="labelComprobar" class="alert"></div>
              </div>
              <div class="col-lg-5">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btnGuardar" class="btn btn-sm btn-primary">Guardar Comida</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>