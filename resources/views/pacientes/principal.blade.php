@extends('layouts.plantilla')
{{-- Realizar la consulta ajax para la tabla principal de pacientes. --}}
@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pacientes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Pacientes</li>
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
              	<div class="row">	
              		<div class="col" >
                    <div id="divMensaje" class="alert text-center p-0">
                      <!-- Mensaje de exito/error -->
                    </div> 
                  </div>
                  <div class="col">
                      <p class="text-right">
                        <button type="button" class="btn btn-sm btn-default" id="btnAgregar" onClick="agregar()" data-toggle="modal"  data-target="#modal">
                          Agregar paciente
                        </button>
                      </p>	
                  </div>
              	</div>	
              	<!--------------TABLA PRINCIPAL-------------->
              	<div class="row">
                  <div class="col">
                    <table id="tablePacientes" class="table table-sm table-striped table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                      <!------Cabecera de la tabla------>
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Paciente</th>
                          <th scope="col">DNI</th>
                          <th scope="col">Direccion</th>
                          <th scope="col">Email</th>
                          <th scope="col">Teléfono</th>
                          <th scope="col">Estado</th>
                          <th scope="col" width="5%">Acciones</th>
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
          <!-- /.col-md-6 -->
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Modal para agregar y editar  -->

  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form onSubmit="guardar(event)">
        <div class="modal-content">
          <div class="modal-header">
            <span class="modal-title" id="tituloModal"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>    
          <div class="modal-body">
            <input type="hidden" id="id" name="id">
            <label for='apellido' id="labelApellido">Apellido</label>
            <input class="form-control" type="text" id="apellido" name="apellido" required minlength="4" maxlength="64">
            <label for='nombre' id="labelNombre">Nombre</label>
            <input class="form-control" type="text" id="nombre" name="nombre" required minlength="4" maxlength="64">
            <label for='dni' id="labelDni">DNI</label>
            <input class="form-control" type="number" id="dni" name="dni" required minlength="7" maxlength="15">
            <label for='direccion' id="labelDireccion">Dirección</label>
            <input class="form-control" type="text" id="direccion" name="direccion" minlength="4" maxlength="128">
            <label for='email' id="labelEmail">Email</label>
            <input class="form-control" type="text" id="email" name="email" minlength="4" maxlength="64">
            <label for='telefono' id="labelTelefono">Teléfono</label>
            <input class="form-control" type="text" id="telefono" name="telefono" minlength="4" maxlength="64">
            <label for='estado' id="labelEstado">Estado</label>
            <select class="form-control" id="estado" name="estado">
              <option value="1" class="text-success">Activo</option>
              <option value="0" class="text-danger">Inactivo</option>
            </select>
          </div>
          <div class="modal-footer">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col">
                  <button type="submit" id="btnGuardar" class="btn btn-sm btn-primary w-100"><i class="fas fa-check"></i><span> </span></button>
                </div>
              </div>
              <div class="row">
                <div class="col">
                <button type="button" class="btn btn-sm btn-secondary w-100" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                </div>
              </div>
              <div class="row">
                <div class="col text-danger" id="divComprobar">
                    <!-- Lista de errores -->
                    <ul id = "listaErrores"></ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@push('custom-scripts')
  <script type="text/javascript" src="{{asset('js/pacientes/principal.js')}}"></script>
@endpush
@endsection