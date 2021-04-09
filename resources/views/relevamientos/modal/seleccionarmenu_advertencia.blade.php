<div class="modal fade" id="modalSeleccionarMenuAdvertencia{{$RelevamientoId}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tituloModalValidacionDetalleRelevamiento{{$RelevamientoId}}">Confirmar Validación</h5>
          <button type="button" class="close" data-number="2" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modalValidacionDetalleRelevamiento{{$RelevamientoId}}">
            <div class="row">

                <p style="white-space: initial;">Antes de seleccionar menú debe asegurarse de que se haya realizado relevamiento a todos los pacientes.
                    Esta acción no permitirá realizar más relevamientos, únicamente modificar los existentes. Se notificará a Cocina sobre la cantidad de raciones a preparar.</p>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-number="2">Cancelar</button>
          <a href="{{route('historial.elegirMenu',$RelevamientoId)}}" class="btn btn-primary" id="btnValidar">Confirmar</a>
        </div>
      </div>
    </div>
  </div>
  