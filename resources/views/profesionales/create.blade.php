@extends('layouts.plantilla')


@section('header')

@section('contenido')

 
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Profesionales</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL::action('ProfesionalController@index')}}">Profesionales</a></li>
              <li class="breadcrumb-item active">Crear</li>
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
                  <form method="POST" action="/profesionales" id="formulario">
                      @csrf
                    <div class="form-row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="nombre">Nombre/s</label>
                          <input type="text" id="nombre" class="form-control" name="nombre" placeholder="Nombre" value="{{old('nombre')}}" required="required">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="apellido">Apellido/s</label>
                          <input type="text" class="form-control" name="apellido" placeholder="Apellido" value="{{old('apellido')}}" required="required">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="matricula"  id='labelMatricula'>Matricula</label>
                          <input type="number" class="form-control" id="matricula" name="matricula" placeholder="Matricula" value="{{old('matricula')}}" required="required">
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="cuil" id='labelCuil'>Cuil</label>
                          <input type="number" class="form-control" id="cuil" name="cuil" placeholder="Cuil" value="{{old('cuil')}}" required="required" >
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="direccion">Dirección</label>
                          <input type="text" class="form-control" name="direccion" placeholder="Dirección" value="{{old('direccion')}}" required="required">
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" name="email" placeholder="ejemplo@ejemplo.com" value="{{old('email')}}" required="required">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="telefono">Teléfono</label>
                          <input type="number" class="form-control" name="telefono" placeholder="Teléfono" value="{{old('telefono')}}" required="required">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Sexo</label>
                          <select class="form-control" name="sexo" required="required">
                            <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <p class="text-left"><label id="labelComprobar"></label></p>
                          <p class="text-right"><button type="submit" id="btnGuardar" class="btn btn-default">Guardar</button></p>
                        </div>
                      </div>
                    </div>
                  </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


@push('custom-scripts')
<script type="text/javascript" src="{{asset('js/profesionales/create.js')}}"></script>
@endpush
@endsection