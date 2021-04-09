@php
    $tiposComida = App\TipoComida::all();
@endphp
<div class="modal fade" id="modalEditar{{$ComidaId}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Editar Comida</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for='nombreComida{{$ComidaId}}' id="labelNombre{{$ComidaId}}">Nombre</label>
          <input class="nombreComida form-control" type="text" id="nombreComida{{$ComidaId}}" data-id="{{$ComidaId}}" value="{{$ComidaNombre}}" name="nombreComida{{$ComidaId}}" required>
          <label for="tipoComida{{$ComidaId}}">Tipo de comida</label>
          <select class="form-control" id="tipoComida{{$ComidaId}}" name="tipoComida{{$ComidaId}}">
            @foreach($tiposComida as $tipoComida)
              <option value="{{$tipoComida->TipoComidaId}}" {{ $tipoComida->TipoComidaId == $TipoComidaId ? 'selected': '' }}>{{$tipoComida->TipoComidaNombre}}  </option>
            @endforeach
          </select>
        </div>
        <div class="modal-footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-7">
                <div id="labelComprobar{{$ComidaId}}" class="alert"></div>
              </div>
              <div class="col-lg-5">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btnGuardar{{$ComidaId}}" onclick="editarComida('{{$ComidaId}}')" class="btn btn-sm btn-primary">Editar Comida</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>