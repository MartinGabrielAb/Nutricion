<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Agregar tipo de comida</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label id="labelTipo">Seleccione el tipo de comida a agregar</label>
        <select name="tipoComida" id="tipoComida" class="form-control" style="width: 90%">
        @foreach($tiposcomida as $tipocomida)
        <option value="{{$tipocomida->TipoComidaId}}">{{$tipocomida->TipoComidaNombre}}</option>
        @endforeach
        </select>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-7">
              <div id="labelComprobarTipo" class="alert"></div>
            </div>
            <div class="col-lg-5">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" id="btnGuardarTipo" class="btn btn-sm btn-primary">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
