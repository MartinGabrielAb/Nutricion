<a href="{{route('comidas.show',$ComidaId)}}" class="btn btn-sm btn-default">Alimentos</a>
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEditar{{$ComidaId}}">
  Editar
</button>
@include('comidas.modal.editar')
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEliminar{{$ComidaId}}">
  Eliminar
</button>
@include('comidas.modal.eliminar')