@extends('layouts.plantilla')
@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Empleados</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL::action('EmpleadoController@index')}}">Empleados</a></li>
              <li class="breadcrumb-item active">Editar</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                @endif
                  {!!Form::open(['route' => ['empleados.update',$empleado->EmpleadoId],'method' => 'put','id' => 'formulario'])!!}
                    {{Form::token()}}
                    <div class="form-row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="nombre">Nombre/s</label>
                          <input type="text" id="nombre" class="form-control" name="nombre" placeholder="Nombre" value="{{$empleado->PersonaNombre}}" required="required">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="apellido">Apellido/s</label>
                          <input type="text" class="form-control" name="apellido" placeholder="Apellido" value="{{$empleado->PersonaApellido}}" required="required">
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="cuil" id="labelCuil">Cuil</label>
                          <input type="hidden" name="cuilViejo" id="cuilViejo" value="{{$empleado->PersonaCuil}}">
                          <input type="numeric" class="form-control" id="cuil" name="cuil" placeholder="Cuil" value="{{$empleado->PersonaCuil}}" required="required" >
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="direccion">Dirección</label>
                          <input type="text" class="form-control" name="direccion" placeholder="Dirección" value="{{$empleado->PersonaDireccion}}" required="required">
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" name="email" placeholder="ejemplo@ejemplo.com" value="{{$empleado->PersonaEmail}}" required="required">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="telefono">Teléfono</label>
                          <input type="text" class="form-control" name="telefono" placeholder="Teléfono" value="{{$empleado->PersonaTelefono}}" required="required">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Sexo</label>
                          <select class="form-control" name="sexo" required="required">
                            @if($empleado->PersonaSexo == 'M')
                              <option value="M" selected>Masculino</option>
                              <option value="F">Femenino</option>
                            @else
                              <option value="M">Masculino</option>
                              <option value="F" selected>Femenino</option>
                            @endif
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <p class="text-left"><label id="labelComprobar"></label></p>
                          <p class="text-right"><button type="submit" id="btnGuardar" class="btn btn-default">Guardar Cambios</button></p>
                        </div>
                      </div>
                    </div>
                  {{Form::close()}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@push('custom-scripts')
<script type="text/javascript" src="{{asset('js/empleados/edit.js')}}"></script>
@endpush
@endsection