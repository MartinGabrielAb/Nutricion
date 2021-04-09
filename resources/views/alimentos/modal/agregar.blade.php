<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Agregar Alimento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for='nombreAlimento' id="labelNombre">Nombre</label>
        <input class="form-control" type="text" id="alimentoNombre" name="alimentoNombre" required>
        <label for="unidadMedidaId">Unidad de Medida:</label>
        <select class="form-control" id="unidadMedida" name="unidadMedidaId">
          @foreach($unidadesMedida as $unidad)
            @if ($unidad->UnidadMedidaNombre != 'U.I' and $unidad->UnidadMedidaNombre != 'Mililitro' and $unidad->UnidadMedidaNombre != 'Miligramo')
              <option value="{{$unidad->UnidadMedidaId}}">{{$unidad->UnidadMedidaNombre}}</option>  
            @endif
          @endforeach
        </select>
        <div id="divEquivalencia" class="d-none">
          <label id="labelUnidadMedida"></label>
          <div class="input-group">
            <input type="text" class="form-control" id="alimentoEquivalencia" aria-label="">
            <div class="input-group-append">
              <span class="input-group-text"><small>gramos</small></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-7">
              <div id="labelComprobar" class="alert"></div>
            </div>
            <div class="col-lg-5">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" id="btnGuardar" class="btn btn-sm btn-primary">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>