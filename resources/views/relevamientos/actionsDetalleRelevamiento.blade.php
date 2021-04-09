<button type="button" class="btn btn-sm btn-default " data-toggle="modal" onclick="cargarSelect2({{$DetalleRelevamientoId}})" data-target="#modalEditarDetalleRelevamiento{{$DetalleRelevamientoId}}">
  Editar
</button>
@include('relevamientos.modal.editarDetalleRelevamiento')
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEliminarDetalleRelevamiento{{$DetalleRelevamientoId}}">
  Eliminar
</button>
@include('relevamientos.modal.eliminarDetalleRelevamiento')
