{{ Form::open(['method' => 'DELETE', 'route' => ['pacientes.destroy', $paciente->PacienteId]]) }}
{{Form::token()}}         
<div class="modal fade" id="eliminar{{$paciente->PacienteId}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Desea eliminar el siguiente paciente?
          {{$paciente->PersonaNombre}}, {{$paciente->PersonaApellido}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-sm btn-default">Eliminar</button> 
    </div>
  </div>
</div>
</div>
{{ Form::close() }}