<div class="modal fade" id="modalEditar{{$SalaId}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Editar Sala</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for='nombreSala{{$SalaId}}' id="labelNombre{{$SalaId}}">Nombre</label>
        <input class="form-control" type="text" id="salaNombre{{$SalaId}}" name="salaNombre{{$SalaId}}" value="{{$SalaNombre}}" required>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-7">
              <div id="labelComprobar{{$SalaId}}" class="alert"></div>
            </div>
            <div class="col-lg-5">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" id="btnGuardar{{$SalaId}}" onclick="editarSala('{{$SalaId}}')" class="btn btn-sm btn-primary">Guardar Cambios</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>