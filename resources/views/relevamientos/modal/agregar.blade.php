<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Iniciar Relevamiento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for='relevamientoFechaId' id="labelNombre">Fecha</label>
          <input class="form-control" type="date" id="relevamientoFechaId" name="relevamientoFechaId" required>
          <label for="relevamientoTurnoId">Turno</label>
          <select class="form-control" id="relevamientoTurnoId" name="relevamientoTurnoId" style="width: 100%">
            <option></option>
            <option value="Mañana">Mañana</option>
            <option value="Tarde">Tarde</option>
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
                <button type="button" id="btnGuardar" class="btn btn-sm btn-primary">Guardar Relevamiento</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>