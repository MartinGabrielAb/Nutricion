<div class="modal fade" id="modalAgregarParticular" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Agregar menú particular</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for='particularMenu' id="labelParticular">Nombre menú particular</label>
        <input class="form-control" type="text" id="particularNombre" name="particularNombre" required>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-7">
              <div id="labelComprobarParticular" class="alert"></div>
            </div>
            <div class="col-lg-5">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" id="btnGuardarParticular" class="btn btn-sm btn-primary">Guardar Menú</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>