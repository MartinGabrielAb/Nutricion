@php
    $pacientes = App\Paciente::select('paciente.PersonaId','paciente.PacienteId','persona.PersonaApellido','persona.PersonaNombre','persona.PersonaCuil')
                ->join('persona', 'persona.PersonaId', '=', 'paciente.PersonaId')
                ->get();
    $salasPiezasCamas = App\Sala::join('pieza','pieza.SalaId','sala.SalaId')
                              ->join('cama','cama.PiezaId','pieza.PiezaId')
                              ->orderby('SalaNombre','desc')
                              ->orderby('pieza.PiezaNombre','asc')
                              ->orderby('cama.CamaNumero','asc')
                              ->get();
    $tiposPaciente = App\TipoPaciente::all();

    $paciente = App\Paciente::FindOrFail($PacienteId);
    $persona = App\Persona::FindOrFail($paciente->PersonaId);
@endphp

<div class="modal fade" id="modalEditarDetalleRelevamiento{{$DetalleRelevamientoId}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Iniciar Relevamiento a Paciente</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-6">
              <label for="pacienteId{{$DetalleRelevamientoId}}">Paciente</label>
            </div>
            <div class="col-6">
              <label id="respuestaUltimoRelevamiento{{$DetalleRelevamientoId}}"></label>
            </div>
          </div>
          <div class="form-inline">
              <select class="pacienteId form-control" id="pacienteId{{$DetalleRelevamientoId}}" name="pacienteId{{$DetalleRelevamientoId}}" style="width: 70%">
                <option></option>
                @foreach ($pacientes as $paciente)
                    <option value="{{$paciente->PersonaCuil}}" {{ $paciente->PersonaCuil == $persona->PersonaCuil ? 'selected': '' }}>{{$paciente->PersonaApellido}}, {{$paciente->PersonaNombre}} - {{$paciente->PersonaCuil}}</option>
                @endforeach
              </select>
              <button type="button" id="ultimoRelevamientoId{{$DetalleRelevamientoId}}" class="btn btn-sm btn-default ml-2">Últ. relevamiento</button>
          </div>
          <label for="camaId{{$DetalleRelevamientoId}}">Sala/Pieza/Cama</label>
          <div class="form-inline">
            <select class="form-control" name="camaId{{$DetalleRelevamientoId}}" id="camaId{{$DetalleRelevamientoId}}" style="width: 70%">
              <option></option>
              @foreach ($salasPiezasCamas as $salaPiezaCama)
                  <option value="{{$salaPiezaCama->CamaId}}" {{ $salaPiezaCama->CamaId == $CamaId ? 'selected': '' }}>{{$salaPiezaCama->SalaNombre}}/{{$salaPiezaCama->PiezaNombre}}/{{$salaPiezaCama->CamaNumero}}</option>
              @endforeach
            </select>
          </div> 
          <div class="form-group">
            <label for="diagnosticoId{{$DetalleRelevamientoId}}">Diagnóstico</label>
            <textarea class="form-control" id="diagnosticoId{{$DetalleRelevamientoId}}" rows="2">{{$DetalleRelevamientoDiagnostico}}</textarea>
          </div>  
          <div class="form-group">
            <label for="observacionesId{{$DetalleRelevamientoId}}">Observaciones</label>
            <textarea class="form-control" id="observacionesId{{$DetalleRelevamientoId}}" rows="2">{{$DetalleRelevamientoObservaciones}}</textarea>
          </div> 
          <label for="tipoPacienteId{{$DetalleRelevamientoId}}">Tipo de Paciente</label>
          <div class="form-inline">
              <select class="form-control" id="tipoPacienteId{{$DetalleRelevamientoId}}" name="tipoPacienteId{{$DetalleRelevamientoId}}" style="width: 70%">
                <option></option>
                @foreach ($tiposPaciente as $tipoPaciente)
                    <option value="{{$tipoPaciente->TipoPacienteId}}" {{ $tipoPaciente->TipoPacienteId == $TipoPacienteId ? 'selected': '' }}>{{$tipoPaciente->TipoPacienteNombre}}</option>
                @endforeach
              </select>
          </div>
          <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" value="1" id="acompanianteId{{$DetalleRelevamientoId}}" name="acompanianteId{{$DetalleRelevamientoId}}" {{ $DetalleRelevamientoAcompaniante == 1 ? 'checked': '' }}>
            <label class="form-check-label" for="acompanianteId{{$DetalleRelevamientoId}}">
              Acompañante
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-7">
                <div id="labelComprobar{{$DetalleRelevamientoId}}" class="alert"></div>
              </div>
              <div class="col-lg-5">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btnGuardar{{$DetalleRelevamientoId}}" onclick="editarDetalleRelevamiento('{{$DetalleRelevamientoId}}')" class="btn btn-sm btn-primary">Guardar</button>
                @include('relevamientos.modal.editarValidaciones')	
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
