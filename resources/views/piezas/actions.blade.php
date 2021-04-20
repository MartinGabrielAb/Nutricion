
<a href="{{route('piezas.show',$PiezaId)}}" class="btn btn-sm btn-default"><i class="far fa-eye"></i></a>
<button type="button" class="btn btn-sm btn-default"  data-toggle="modal"  data-target="#modal" >
  <i class="fas fa-edit"></i>
</button>
<button class="btn btn-sm btn-default" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-trash"></i>
</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <button class="dropdown-item" onClick ="eliminar({{$PiezaId}})" ><i class="fas fa-exclamation-circle"></i>Confirmar eliminación</button>
</div>
