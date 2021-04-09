@php
    $alimentos = App\Alimento::where('AlimentoEstado',1)->get();
    $unidadesMedida = App\UnidadMedida::all();
@endphp
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" onclick="editarAlimentoPorComidaInicio({{$unidadesMedida}},{{$AlimentoPorComidaId}},{{$UnidadMedidaId}})" data-target="#modalEditarAlimentoPorComida{{$AlimentoPorComidaId}}">
  Editar
</button>
@include('comidas.modal.editarAlimentoPorComida')
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEliminarAlimentoPorComida{{$AlimentoPorComidaId}}">
  Eliminar
</button>
@include('comidas.modal.eliminarAlimentoPorComida')