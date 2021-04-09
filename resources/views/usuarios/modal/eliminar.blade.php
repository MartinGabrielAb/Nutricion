<div class="modal fade" id="modalEliminar{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirmar Eliminacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Desea eliminar esta usuario?
        {{$name}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <button type="button" class="btn btn-primary" id="btnEliminar{{$id}}" onclick="eliminarUsuario('{{$id}}')">Confirmar</button>
      </div>
    </div>
  </div>
</div>
