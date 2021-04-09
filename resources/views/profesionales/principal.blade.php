@extends('layouts.plantilla')
@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Gestion de Profesionales</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profesionales</li>
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
              				<a href="{{URL::action('ProfesionalController@create')}}" class="btn btn-default">Agregar</a>
              			</p>	
              		</div>
              	</div>	
              	<!--------------TABLA PRINCIPAL-------------->
              	<table id="tableProfesionales" class="table table-sm table-striped table-bordered">
              		<!------Cabecera de la tabla------>
              		<thead>
              			<tr role="row">
              				<th scope="col">#</th>
                      <th scope="col">Profesional</th>
                      <th scope="col">Matricula</th>
                      <th scope="col">Cuil</th>
                      <th scope="col">Direccion</th>
                      <th scope="col">Email</th>
                      <th scope="col">Telefono</th>
                      <th scope="col">Acciones</th>
              			</tr>
              		</thead>
              		<!------Cuerpo de la tabla------>
                  <tbody>
              			@foreach($profesionales as $profesional)
              			<tr role="row">
              				<td>{{$profesional->ProfesionalId}}</td>
              				<td>{{$profesional->PersonaApellido}},{{$profesional->PersonaNombre}}</td>
                      <td>{{$profesional->ProfesionalMatricula}}</td>
                      <td>{{$profesional->PersonaCuil}}</td>
                      <td>{{$profesional->PersonaDireccion}}</td>
                      <td>{{$profesional->PersonaEmail}}</td>
                      <td>{{$profesional->PersonaTelefono}}</td>
                      <td>
                        <a href="{{URL::action('ProfesionalController@edit',$profesional->ProfesionalId)}}" class="btn btn-sm btn-default">Editar</a>
                        <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#eliminar{{$profesional->ProfesionalId}}">Dar Baja</button>
                        @include('profesionales.modal.eliminar')
                      </td>
                    </tr>
              			@endforeach
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
<script>
$(document).ready( function () {
    $('#tableProfesionaless').DataTable({
         "language": {
          "url": '{{asset('JSON/Spanish_dataTables.json')}}',
          },
          responsive:true,
          columnsDef: [
            {responsivePriority:1,targets:0},
            {responsivePriority:2,targets:1},
            {responsivePriority:3,targets:3},

          ]
    });
    } );
</script>
@endpush
@endsection