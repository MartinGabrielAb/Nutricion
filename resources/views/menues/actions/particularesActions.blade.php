<a href="{{route('menu.show',$MenuId)}}" class="btn btn-sm btn-default">Ver</a>
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEliminar{{$MenuId}}">
  Eliminar
</button>
@include('menues.modal.eliminar')