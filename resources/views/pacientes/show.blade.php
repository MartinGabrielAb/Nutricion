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
            <h1 class="m-0 text-dark">Historial de Paciente</h1>
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
                  <div class="col">
                    <input hidden type="text" id="pacienteId" value="{{$paciente->PacienteId}}">
                    <dl class="row">
                      <dt class="col-sm-3 col-md-3 col-lg-3 col-xl-2">Paciente</dt>
                      <dd class="col-sm-9 col-md-9 col-lg-9 col-xl-10 ">{{$paciente->PacienteApellido}}, {{$paciente->PacienteNombre}}</dd>
                      <dt class="col-sm-3 col-md-3 col-lg-3 col-xl-2">Dirección</dt>
                      <dd class="col-sm-9 col-md-9 col-lg-9 col-xl-10 ">{{$paciente->PacienteDireccion}}</dd>
                      <dt class="col-sm-3 col-md-3 col-lg-3 col-xl-2">Email</dt>
                      <dd class="col-sm-9 col-md-9 col-lg-9 col-xl-10 ">{{$paciente->PacienteEmail}}</dd>
                      <dt class="col-sm-3 col-md-3 col-lg-3 col-xl-2">Teléfono</dt>
                      <dd class="col-sm-9 col-md-9 col-lg-9 col-xl-10 ">{{$paciente->PacienteTelefono}}</dd>
                      <dt class="col-sm-3 col-md-3 col-lg-3 col-xl-2">DNI</dt>
                      <dd class="col-sm-9 col-md-9 col-lg-9 col-xl-10 ">{{$paciente->PacienteCuil}}</dd>
                    </dl>
                  </div>
                </div>
                <div class="row">
                  <div id="divMensaje" class="alert text-center p-0 w-100">
                      <!-- Mensaje de exito/error -->
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <!--------------TABLA PRINCIPAL-------------->
                    <table id="tableHistorialPaciente" class="table table-sm table-striped table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                      <!------Cabecera de la tabla------>
                      <thead>
                        <tr role="row">
                          <th scope="col">#</th>
                          <th scope="col">Fecha</th>
                          <th scope="col">Turno</th>
                          <th scope="col">Paciente</th>
                          <th scope="col">Menú</th>
                          <th scope="col">Regímen</th>
                          <th scope="col">Acompañante</th>
                          <th scope="col">VD</th>
                          <th scope="col">S/P/C</th>
                          <th scope="col">Diagnóstico</th>
                          <th scope="col">Obs.</th>
                          <th scope="col">Hora</th>
                          <th scope="col">Estado</th>
                          <th scope="col">Relevador</th>
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
@push('custom-scripts')
  <script type="text/javascript" src="{{asset('js/pacientes/principal.js')}}"></script>
@endpush
@endsection