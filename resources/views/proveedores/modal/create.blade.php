<div class="modal fade" id="modal-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="tituloModal"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="idFormProveedores">
        <input type="hidden" name="id" id="id" value="">
        <label for='nombre' id="labelNombre">Nombre</label>
        <input class="form-control" type="text" id="nombre" name="nombre" value="" required>
        <label for='email' id="labelEmail">E-mail</label>
        <input class="form-control" type="text" id="email" name="email" value="" required>
        <label for='cuit' id="labelCuit">Cuit</label>
        <input class="form-control" type="text" id="cuit" name="cuit" value="" required>
        <label for='direccion' id="labelDireccion">Direccion</label>
        <input class="form-control" type="text" id="direccion" name="direccion" value="" required>
        <label for='telefono' id="labelTelefono">Telefono</label>
        <input class="form-control" type="text" id="telefono" name="telefono" value="" required>
        <div class="alert" id="divErrores">
          <ul>
            
          </ul>
        </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-7">
              <div id="labelComprobar" class="alert"></div>
            </div>
            <div class="col-lg-5">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" id="btnGuardar" class="btn btn-sm btn-primary"></button>
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
</div>

