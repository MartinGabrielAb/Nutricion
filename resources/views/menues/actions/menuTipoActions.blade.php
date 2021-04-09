<a href="{{route('menuportipopaciente.show',$DetalleMenuTipoPacienteId)}}" class="btn btn-sm btn-default">Ver</a>
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEliminar{{$DetalleMenuTipoPacienteId}}">
  Eliminar
</button>
@include('menues.modal.eliminarMenuTipo')