
<a href="{{route('alimentos.show',$AlimentoId)}}" class="btn btn-sm btn-default ml-1 mr-1 pl-3 pr-3">Detalles</a>
<a href="{{route('nutrientesporalimento.show',$AlimentoId)}}" class="btn btn-sm btn-default ml-1 mr-1 pl-3 pr-3">Nutrientes</a>
<button class="btn btn-sm btn-default ml-1 mr-1 pl-3 pr-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-trash"></i>
</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <button class="dropdown-item" onClick ="eliminar({{$AlimentoId}})" ><i class="fas fa-exclamation-circle mr-1"></i>Confirmar eliminación</button>
</div>
