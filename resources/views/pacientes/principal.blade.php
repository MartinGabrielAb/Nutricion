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
            <h1 class="m-0 text-dark">Gestion de Pacientes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
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
              		<div class="col-lg-12">
              		  <p class="text-right">
              				<a href="{{URL::action('PacienteController@create')}}" class="btn btn-default">Agregar</a>
              			</p>	
              		</div>
              	</div>	
              	<!--------------TABLA PRINCIPAL-------------->
                <h1 class="text-danger border border-warning text-center">Falta agregar funcionalidad a los botones de acción!</h1>
              	<table id="tablePacientes" class="table table-sm table-striped table-bordered">
              		<!------Cabecera de la tabla------>
              		<thead>
              			<tr role="row">
              				<th scope="col">#</th>
                      <th scope="col">Paciente</th>
                      <th scope="col">Cuil</th>
                      <th scope="col">Direccion</th>
                      <th scope="col">Email</th>
                      <th scope="col">Telefono</th>
                      <th scope="col">Acciones</th>
              			</tr>
              		</thead>
                  <tbody>
              		</tbody>	
              	</table>
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
@push('custom-scripts')
  <script type="text/javascript" src="{{asset('js/pacientes/principal.js')}}"></script>
@endpush
@endsection