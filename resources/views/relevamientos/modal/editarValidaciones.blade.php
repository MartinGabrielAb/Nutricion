<div class="modal fade" id="modalPrueba{{$DetalleRelevamientoId}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tituloModalValidacionDetalleRelevamiento{{$DetalleRelevamientoId}}">Confirmar Validación</h5>
          <button type="button" class="close cerrarModalEditarValidaciones" data-id="{{$DetalleRelevamientoId}}" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modalValidacionDetalleRelevamiento{{$DetalleRelevamientoId}}">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cerrarModalEditarValidaciones">Cancelar</button>
          <button type="button" class="btn btn-primary btnValidar" data-id="{{$DetalleRelevamientoId}}" id="btnValidar{{$DetalleRelevamientoId}}">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
  