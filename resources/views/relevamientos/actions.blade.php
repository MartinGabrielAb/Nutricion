@php
  $historial = App\Historial::where('HistorialEstado',1)->where('HistorialFecha',$RelevamientoFecha)->where('HistorialTurno',$RelevamientoTurno)->first();
@endphp
@if (!$historial || $historial->HistorialEstado == 0)
  <a href="{{route('historial.elegirMenu',$RelevamientoId)}}" class="btn btn-sm btn btn-warning">Elegir menú</a>
@else
  {{-- @if ($historial->HistorialEstado == 0)
    <a onclick="seleccionarmenu_advertencia()" class="btn btn-sm btn btn-warning">Elegir menú</a>
  @else    
  @endif --}}
  <a href="{{route('historial.show',$historial->HistorialId)}}" class="btn btn-sm btn btn-success">Ver menú</a>
@endif
<a href="{{route('relevamientos.show',$RelevamientoId)}}" class="btn btn-sm btn-default">Detalles</a>
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEliminar{{$RelevamientoId}}">
  Eliminar
</button>
@include('relevamientos.modal.eliminar')
@include('relevamientos.modal.seleccionarmenu_advertencia')