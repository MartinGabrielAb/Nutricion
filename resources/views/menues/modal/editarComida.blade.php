<div class="modal fade" id="modalEditar{{$ComidaPorTipoPacienteId}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Seleccione la comida</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 
          $comidas = DB::TABLE('comida')
                          ->where('TipoComidaId',$TipoComidaId)
                          ->get();
          $cantidadComidas = count($comidas);
         ?>
        @if($cantidadComidas!=0) 
        <select name="comida{{$ComidaPorTipoPacienteId}}" id="comida{{$ComidaPorTipoPacienteId}}" class="form-control" style="width: 90%">
        @foreach($comidas as $comida)
        <option value="{{$comida->ComidaId}}">{{$comida->ComidaNombre}}</option>
        @endforeach
        </select>
        @else
          <p class="text-danger text-sm"> No hay comidas de este tipo</p>
        @endif
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-4">
              <div id="labelComprobar{{$ComidaPorTipoPacienteId}}" class="alert"></div>
            </div>
            @if($cantidadComidas != 0)
            <div class="col-lg-4">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" id="btnGuardar{{$ComidaPorTipoPacienteId}}" onclick="editarComida('{{$ComidaPorTipoPacienteId}}')" class="btn btn-sm btn-primary">Guardar Cambios</button>
            </div>
            @else
              <div class="col-lg-4">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>