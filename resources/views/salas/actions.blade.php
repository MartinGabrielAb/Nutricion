
<a href="{{route('salas.show',$SalaId)}}" class="btn btn-sm btn-default">Ver</a>
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEditar{{$SalaId}}">
  Editar
</button>
@include('salas.modal.editar')
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEliminar{{$SalaId}}">
  Eliminar
</button>
@include('salas.modal.eliminar')
