<a href="{{route('pieza.show',$PiezaId)}}" class="btn btn-sm btn-default">Ver</a>
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEditar{{$PiezaId}}">
  Editar
</button>
@include('salas.modal.editarPieza')
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEliminar{{$PiezaId}}">
  Eliminar
</button>
@include('salas.modal.eliminarPieza')