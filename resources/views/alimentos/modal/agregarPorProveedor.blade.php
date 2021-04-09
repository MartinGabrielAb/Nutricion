<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Agregar Alimento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="alimentoId" id="alimentoId" value="{{$alimento->AlimentoId}}">
          <div class="form-group">
            <label for="proveedor">Proveedor</label>
            <select class="js-example-basic-single" name="proveedor">
              @foreach($proveedores as $proveedor)
                <option value="{{$proveedor->ProveedorId}}">{{$proveedor->ProveedorNombre}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="peso">Cantidad</label>
            <input type="text" id="inputCantidad" class="form-control" name="cantidad" id="cantidad">
            <?php 
            $medida = App\UnidadMedida::findOrFail($alimento->UnidadMedidaId);
            ?>
            <small class="form-text text-muted">Cantidad en: {{$medida->UnidadMedidaNombre}}</small>
          </div>
          <div class="form-group">
          <label for="cantidad">Costo por {{$medida->UnidadMedidaNombre}}</label>
            <input type="text" id="inputCosto" class="form-control" name="precio">
          </div>
          <div class="form-group">
            <label for="cantidad">Vencimiento</label>
            <input id="inputFecha" type="date" class="form-control" name="vencimiento">
          </div>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-7">
              <div id="labelComprobar" class="alert"></div>
            </div>
            <div class="col-lg-5">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" id="btnGuardar" class="btn btn-sm btn-primary">Guardar Alimento</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>