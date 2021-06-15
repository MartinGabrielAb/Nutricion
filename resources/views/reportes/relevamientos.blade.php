
@extends('layouts.plantilla')
@section('contenido')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Reportes de Relevamientos</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Relevamientos</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- Main content -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card w-50 mr-auto ml-auto">
          <div class="card-body">
            <div class="row">
                <div class="col" >
                    <div id="divMensaje" class="alert text-center p-0">
                    <!-- Mensaje de exito/error -->
                    </div> 
                </div>
            </div>
            <div class="row form-group">
                <label for="dni" class="col-xl-2 col-lg-2 col-sm-12 col-md-12 col-form-label text-center">DNI</label>
                <div class="col-auto">
                    <input type="number" class="form-control" id="dni" placeholder="DNI del paciente">
                </div>
            </div>
            <div class="row form-group">
                <label for="fecha_desde" class="col-xl-2 col-lg-2 col-sm-12 col-md-12 col-form-label text-center">Desde</label>
                <div class="col-auto">
                    <input type="date" class="form-control" id="fecha_desde">
                </div>
                <label for="fecha_hasta" class="col-xl-2 col-lg-2 col-sm-12 col-md-12 col-form-label text-center">Hasta</label>
                <div class="col-auto">
                    <input type="date" class="form-control" id="fecha_hasta">
                </div>
            </div>
            <div class="row form-group">
                <label for="sala" class="col-xl-2 col-lg-2 col-sm-12 col-md-12 col-form-label text-center">Sala</label>
                <div class="col-auto">
                    <select class="form-control" id="sala">
                        <option value="-1"></option>
                        @foreach ($salas as $sala)
                            <option value="{{$sala->SalaId}}">{{$sala->SalaNombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row justify-content-md-center mb-0">
                <div class="col-auto mr-auto ml-auto">
                    <button type="submit" onclick="getReportePaciente(event)" class="btn btn-primary">Generar</button>
                </div>
            </div>
            <div class="row">
                <div class="col text-danger" id="divComprobar">
                    <!-- Lista de errores -->
                    <ul id = "listaErrores"></ul>
                </div>
            </div>
              {{-- <!--------------TABLA PRINCIPAL-------------->
            <div class="row">
              <div class="col">
                <table id="tableRelevamientos" class="table table-sm table-striped table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                  <!------Cabecera de la tabla------>
                  <thead>
                    <tr>
                      <th scope="col" width="5%">#</th>
                      <th scope="col">Sala</th>
                      <th scope="col">Fecha</th>
                      <th scope="col">Turno</th>
                      <th scope="col" width="5%">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('custom-scripts')
  <script type="text/javascript" src="{{asset('js/reportes/relevamientos.js')}}"></script>
@endpush

@endsection