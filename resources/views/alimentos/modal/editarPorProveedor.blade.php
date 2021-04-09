<div class="modal fade" id="modalEditarPorProveedor{{$AlimentoPorProveedorId}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Editar Alimento por Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="alimentoId{{$AlimentoPorProveedorId}}" id="alimentoId{{$AlimentoPorProveedorId}}" value="{{$AlimentoPorProveedorId}}">
          <div class="form-group">
            <label for="proveedor{{$AlimentoPorProveedorId}}">Proveedor</label>
            <select class="js-example-basic-single" name="proveedor{{$AlimentoPorProveedorId}}" id="proveedor{{$AlimentoPorProveedorId}}">
              @foreach($proveedores as $proveedor)
                <option value="{{$proveedor->ProveedorId}}" {{ $proveedor->ProveedorId == $ProveedorId ? 'selected':'' }}>{{$proveedor->ProveedorNombre}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="cantidad{{$AlimentoPorProveedorId}}">Cantidad</label>
            <input type="text" id="cantidad{{$AlimentoPorProveedorId}}" class="cantidad form-control" data-id="{{$AlimentoPorProveedorId}}" name="cantidad{{$AlimentoPorProveedorId}}" value="{{$AlimentoPorProveedorCantidad}}">
            <?php 
            $medida = App\UnidadMedida::findOrFail($UnidadMedidaId);
            ?>
            <small class="form-text text-muted">Cantidad en: {{$medida->UnidadMedidaNombre}}</small>
          </div>
          <div class="form-group">
          <label for="precio{{$AlimentoPorProveedorId}}">Costo por {{$medida->UnidadMedidaNombre}}</label>
            <input type="text" id="precio{{$AlimentoPorProveedorId}}" class="precio form-control" data-id="{{$AlimentoPorProveedorId}}" name="precio{{$AlimentoPorProveedorId}}" value="{{$AlimentoPorProveedorCosto}}">
          </div>
          <div class="form-group">
            <label for="vencimiento{{$AlimentoPorProveedorId}}">Vencimiento</label>
            <input type="date" class="fecha form-control" name="vencimiento{{$AlimentoPorProveedorId}}" data-id="{{$AlimentoPorProveedorId}}" id="vencimiento{{$AlimentoPorProveedorId}}" value="{{$AlimentoPorProveedorVencimiento}}">
          </div>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-7">
              <div id="labelComprobar{{$AlimentoPorProveedorId}}" class="alert"></div>
            </div>
            <div class="col-lg-5">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" id="btnGuardar{{$AlimentoPorProveedorId}}" onclick="editarAlimentoPorProveedor('{{$AlimentoPorProveedorId}}')" class="btn btn-sm btn-primary">Editar Alimento por Proveedor</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>