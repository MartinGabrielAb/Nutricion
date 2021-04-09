<div class="modal fade" id="modalEditar{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Editar usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for='nombreUsuario{{$id}}' id="labelNombre{{$id}}">Nombre</label>
        <input class="form-control" type="text" id="nombreUsuario{{$id}}" name="nombreUsuario{{$id}}" value="{{$name}}">
        <label for='emailUsuario{{$id}}' id="labelEmail{{$id}}">E-mail</label>
        <input class="form-control" type="text" id="emailUsuario{{$id}}" name="emailUsuario{{$id}}" value="{{$email}}">
        <label for='passwordUsuario{{$id}}' id="labelPassword{{$id}}">Password</label>
        <input class="form-control" type="password" id="passwordUsuario{{$id}}" name="passwordUsuario{{$id}}" required>
        <label for='confirmaUsuario{{$id}}' id="labelConfirma{{$id}}">Confirma Password</label>
        <input class="form-control" type="password" id="confirmaUsuario{{$id}}" name="confirmaUsuario{{$id}}" required>
        <div class="row mt-2 ml-1">
            <label for="roles{{$id}}" id="labelRoles{{$id}}">Roles</label>
        </div>
        <div class="row">
          <div class="col">
            <input class="form-check-input ml-2" type="checkbox" name="roles{{$id}}[]" id="rolAdministrador{{$id}}" value="Administrador">
            <label class="form-check-label ml-4" for="rolAdministrador{{$id}}">Administrador</label>
          </div>
          <div class="col">
            <input class="form-check-input ml-2 " type="checkbox" name="roles{{$id}}[]" id="rolCocinero{{$id}}" value="Cocinero">
            <label class="form-check-label ml-4 " for="rolCocinero{{$id}}">Cocinero</label>
          </div>
          <div class="col">
            <input class="form-check-input" type="checkbox" name="roles{{$id}}[]" id="rolDespensa{{$id}}" value="Despensa">
            <label class="form-check-label" for="rolDespensa{{$id}}">Despensa</label> 
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label></label>
          </div>
          <div class="col">
            <input class="form-check-input" type="checkbox" name="roles{{$id}}[]" id="roles{{$id}}[]" value="Relevador">
            <label class="form-check-label" for="rolRelevador{{$id}}">Relevador</label>
          </div>
          <div class="col">
            <input class="form-check-input" type="checkbox" name="roles{{$id}}[]" id="rolNutricionista{{$id}}" value="Nutricionista">
            <label class="form-check-label" for="rolNutricionista{{$id}}">Nutricionista</label>
          </div>
          <div class="col">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-7">
              <div id="labelComprobar{{$id}}" class="alert"></div>
            </div>
            <div class="col-lg-5">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" id="btnGuardar{{$id}}" onclick="editarUsuario('{{$id}}')" class="btn btn-sm btn-primary">Editar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>