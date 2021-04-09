@php
  $proveedores = App\Proveedor::where('ProveedorEstado',1)->get();    
@endphp
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEditarPorProveedor{{$AlimentoPorProveedorId}}">
  Editar
</button>
@include('alimentos.modal.editarPorProveedor')
<button type="button" class="btn btn-sm btn-default " data-toggle="modal" data-target="#modalEliminarPorProveedor{{$AlimentoPorProveedorId}}">
  Eliminar
</button>
@include('alimentos.modal.eliminarPorProveedor')