<a href="{{route('alimentos.show',$AlimentoId)}}" class="btn btn-sm btn-default">Alimentos por proveedor</a>
<a href="{{route('nutrientesporalimento.show',$AlimentoId)}}" class="btn btn-sm btn-default">Nutrientes</a>
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEliminar{{$AlimentoId}}">
  Eliminar
</button>
@include('alimentos.modal.eliminar')