<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEditar{{$id}}">
  Editar
</button>
@include('usuarios.modal.editar')
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEliminar{{$id}}">
  Eliminar
</button>
@include('usuarios.modal.eliminar')
