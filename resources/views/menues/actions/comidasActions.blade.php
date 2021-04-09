
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEditar{{$ComidaPorTipoPacienteId}}">
  Seleccionar comida
</button>
@include('menues.modal.editarComida')
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEliminar{{$ComidaPorTipoPacienteId}}">
  Eliminar
</button>
@include('menues.modal.eliminarComida')