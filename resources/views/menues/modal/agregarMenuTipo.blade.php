<div class="modal fade" id="modalAgregarMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Agregar menú por tipo de paciente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label id="labelMenu">Seleccione el tipo de menu</label>
        <select name="tipoPaciente" id="tipoPaciente" class="js-example-responsive" style="width: 90%">
        @foreach($tipospaciente as $tipopaciente)
        <option value="{{$tipopaciente->TipoPacienteId}}">{{$tipopaciente->TipoPacienteNombre}}</option>
        @endforeach
        </select>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-7">
              <div id="labelComprobarMenu" class="alert"></div>
            </div>
            <div class="col-lg-5">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" id="btnGuardarMenu" class="btn btn-sm btn-primary">Guardar Menú</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
