<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Confirmar Eliminacion</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Una vez que elimine el historial deberá seleccionar menú para el relevamiento asociado nuevamente. <br>
        ¿Desea eliminar este historial?
        <strong><span id="nombreProveedor"></span></strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <button type="button" class="btn btn-primary" id="btnConfirmarEliminar" >Confirmar</button>
      </div>
    </div>
  </div>
</div>
