{{-- @php
  $historial = App\Historial::where('HistorialEstado',1)->where('HistorialFecha',$RelevamientoFecha)->where('HistorialTurno',$RelevamientoTurno)->first();
@endphp
@if (!$historial || $historial->HistorialEstado == 0)
  <a href="{{route('historial.elegirMenu',$RelevamientoId)}}" class="btn btn-sm btn btn-warning">Elegir menú</a>
@else
  <a href="{{route('historial.show',$historial->HistorialId)}}" class="btn btn-sm btn btn-success">Ver menú</a>
@endif
<a href="{{route('relevamientos.show',$RelevamientoId)}}" class="btn btn-sm btn-default">Detalles</a>
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEliminar{{$RelevamientoId}}">
  Eliminar
</button>
@include('relevamientos.modal.eliminar')
@include('relevamientos.modal.seleccionarmenu_advertencia') --}}




<a href="" class="btn btn-sm btn-default ml-1 mr-1 pl-3 pr-3"><i class="fas fa-play" style="color: green"></i></a>
<a href="{{route('relevamientos.show',$RelevamientoId)}}" class="btn btn-sm btn-default ml-1 mr-1 pl-3 pr-3"><i class="fas fa-clipboard-list" style="color: black"></i></a>
<button type="button" class="btn btn-sm btn-default ml-1 mr-1 pl-3 pr-3" data-toggle="modal"  data-target="#modal" >
  <i class="fas fa-edit"></i>
</button>
<button class="btn btn-sm btn-default ml-1 mr-1 pl-3 pr-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-trash"></i>
</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <button class="dropdown-item" onClick ="eliminar({{$RelevamientoId}})" ><i class="fas fa-exclamation-circle"></i>Confirmar eliminación</button>
</div>
