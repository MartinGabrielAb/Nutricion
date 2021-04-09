<div class="modal fade" id="modalEditar{{$MenuId}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Editar menú</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for='nombreMenu{{$MenuId}}' id="labelNombre{{$MenuId}}">Nombre</label>
        <input class="form-control" type="text" id="menuNombre{{$MenuId}}" name="menuNombre{{$MenuId}}" value="{{$MenuNombre}}" required>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-7">
              <div id="labelComprobar{{$MenuId}}" class="alert"></div>
            </div>
            <div class="col-lg-5">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" id="btnGuardar{{$MenuId}}" onclick="editarMenu('{{$MenuId}}')" class="btn btn-sm btn-primary">Guardar Cambios</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>