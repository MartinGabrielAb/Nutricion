
@extends('layouts.plantilla')
@section('contenido')
<div class="content-wrapper">
  <div class="container">
      <div class="row justify-content-center">
          <div class="col">
              <div class="card w-100 mt-2">
                  <div class="card-header">
                    <div class="row">
                      <div class="col text-left">
                        {{ __('Administracion de proveedores') }}
                      </div>
                      <div class="col alert-sm text-sm" id="divMensaje" name="divMensaje">
                        
                      </div>
                      <div class="col text-right pr-4" >
          
                        <button type="button" data-toggle="modal" data-target="#modal-id" id="btnAgregar" class="btn btn-sm btn-outline-primary">
                              Proveedor
                              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7.5-3a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"></path>
                      </svg>
                            </button>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row table-responsive">
                      <div class="col-lg-12">
                          <table id="tableProveedores" class="table  table-sm table-striped table-bordered table-hover display nowrap" style="width:100%;" cellspacing="0">
                          <!------Cabecera de la tabla------>
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Proveedor</th>
                              <th>Cuit</th>
                              <th>Direccion</th>
                              <th>Telefono</th>
                              <th>Email</th>
                              <th width="10%">Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                        @include('proveedores.modal.create')
                        @include('proveedores.modal.eliminar')
                      </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@push('custom-scripts')
<script type="text/javascript" src="{{asset('js/proveedores/principal.js')}}"></script>
@endpush
@endsection
