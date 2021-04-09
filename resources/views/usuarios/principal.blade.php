

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
                      {{ __('Administracion de usuarios') }}
                    </div>
                    <div class="col alert-sm text-sm" id="divMensaje" name="divMensaje">
                      
                    </div>
                    <div class="col text-right" >
                      <button class="btn btn-sm btn-default" id="btnAgregar" data-toggle="modal" data-target="#modalAgregar">Nuevo usuario</button>
                    </div>
                    @include('usuarios.modal.create') 
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                        <table id="tableUsuarios" class="table table-sm table-striped table-bordered table-hover display nowrap " style="width:100%;" cellspacing="0">
                        <!------Cabecera de la tabla------>
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Persona</th>
                            <th>Usuario</th>
                            <th>Roles</th>
                            <th width="20%">&nbsp;</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@push('custom-scripts')
<script type="text/javascript" src="{{asset('js/usuarios/principal.js')}}"></script>
<script type="text/javascript" src="{{asset('js/usuarios/create.js')}}"></script>

@endpush

@endsection
