<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Agregar usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for='nombreUsuario' id="labelNombre">Nombre</label>
        <input class="form-control" type="text" id="nombreUsuario" name="nombreUsuario" required>
        <label for='emailUsuario' id="labelEmail">E-mail</label>
        <input class="form-control" type="text" id="emailUsuario" name="emailUsuario" required>
        <label for='passwordUsuario' id="labelPassword">Password</label>
        <input class="form-control" type="password" id="passwordUsuario" name="passwordUsuario" required>
        <label for='confirmaUsuario' id="labelConfirma">Confirma Password</label>
        <input class="form-control" type="password" id="confirmaUsuario" name="confirmaUsuario" required>
        <div class="row mt-2 ml-1">
            <label for="roles" id="labelRoles">Roles</label>
        </div>
        <div class="row">
          <div class="col">
            <input class="form-check-input ml-2" type="checkbox" name="roles[]" id="rolAdministrador" value="Administrador">
            <label class="form-check-label ml-4" for="rolAdministrador">Administrador</label>
          </div>
          <div class="col">
            <input class="form-check-input ml-2 " type="checkbox" name="roles[]" id="rolCocinero" value="Cocinero">
            <label class="form-check-label ml-4 " for="rolCocinero">Cocinero</label>
          </div>
          <div class="col">
            <input class="form-check-input" type="checkbox" name="roles[]" id="rolDespensa" value="Despensa">
            <label class="form-check-label" for="rolDespensa">Despensa</label> 
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label></label>
          </div>
          <div class="col">
            <input class="form-check-input" type="checkbox" name="roles[]" id="roles[]" value="Relevador">
            <label class="form-check-label" for="rolRelevador">Relevador</label>
          </div>
          <div class="col">
            <input class="form-check-input" type="checkbox" name="roles[]" id="rolNutricionista" value="Nutricionista">
            <label class="form-check-label" for="rolNutricionista">Nutricionista</label>
          </div>
          <div class="col">
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
              <button type="button" id="btnGuardar" class="btn btn-sm btn-primary">Registrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>