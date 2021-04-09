@extends('layouts.plantilla')

@section('contenido')
<div class="content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-8" style="height: 5px">
        <div id="divMensaje" class="alert"> 
        </div> 
      </div>
      <div class="col-lg-4">
        <p class="text-right mt-1 mb-1 pt-1">
          <button class="d-inline btn btn-sm btn-default">Editar</button>
          <button class="d-inline btn btn-sm btn-default" data-toggle="modal" data-target="#modalEliminar" id="btnAgregar">Eliminar</button>
        </p>	
      </div>
    </div>
    <input type="hidden" id="historialId" value="{{$historial->HistorialId}}">
    @include('historial.modal.eliminar')
    <div class="row">
      <div class="card w-100 mt-1">
        <div class="card-body ">
          <div class="row">
          <div class="col">
            <p class="text-secondary text-left text-xs">Fecha: {{$historial->HistorialFecha}}</p>
          </div>
          <div class="col">
            <p class="text-secondary text-center text-xs">Total de pacientes: {{$historial->HistorialCantidadPacientes}}</p>
          </div>
          <div class="col">
            <p class="text-secondary text-right text-xs font-weight-bold">Costo total: ${{$historial->HistorialCostoTotal}}</p>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-------------- Header de generales---------- -->
  @foreach($historialTipoPaciente as $tipoPaciente)
    @if($tipoPaciente->TipoPacienteNombre != 'Particular')
      <div class="content-header" style="height: 45px">
        <div class="row w-100" >
          <div class="col">
            <p class="text-secondary text-left text-xs ml-2 font-weight-bold">Tipo de paciente: {{$tipoPaciente->TipoPacienteNombre}}</p>
          </div>
          <div class="col">
          <p class="text-secondary text-center text-xs ml-3">Cantidad de Pacientes: {{$tipoPaciente->HistorialTipoPacienteCantidad}}</p>
          </div>
          <div class="col">
            <p class="text-secondary text-right text-xs mr-0 font-weight-bold">Costo Total: ${{$tipoPaciente->HistorialTipoPacienteCostoTotal * $tipoPaciente->HistorialTipoPacienteCantidad}}</p>
          </div>
        </div>
      </div>
      <!-------------- Tabla de generales---------- -->
      <div class="container-fluid">
        <div class="row">
          <div class="card w-100 mt-1">
            <div class="card-body"> 
              <div class="col-lg-12">
                <div class="table-responsive-sm">
                  <table class="table table-sm">
                    <thead>
                      <tr>
                        <th scope="col"><p class="text-xs">Tipo de Comida</p></th>
                        <th scope="col"><p class="text-xs">Alimento</p></th>
                        <th scope="col"><p class="text-xs">Cantidad</p></th>
                        <th scope="col"><p class="text-xs">Costo Por alimento</p></th>
                        <th scope="col"><p class="text-xs">Costo Total</p></th>
                        </tr>
                    </thead>    
                    <tbody>
                      <?php
                      $comidasPorTipoPaciente = App\HistorialComidaPorTipoPaciente::where('HistorialTipoPacienteId',$tipoPaciente->HistorialTipoPacienteId)->get();
                      ?>
                      @foreach($comidasPorTipoPaciente as $comidaPorTipoPaciente)
                        <?php 
                          $alimentos = App\HistorialAlimentoPorComida::where('HistorialComidaPorTipoPacienteId',$comidaPorTipoPaciente->HistorialComidaPorTipoPacienteId)->get();
                          $cantidadAlimentos = count($alimentos);
                          $cont = 0
                        ?>
                        @foreach($alimentos as $alimento)   
                          <tr>  
                          @if($cont==0)
                            <td class="align-middle" rowspan="{{$cantidadAlimentos}}"><p class="text-xs">{{$comidaPorTipoPaciente->TipoComidaNombre}}</p></td>
                          @endif
                            <td class="align-middle"><p class="text-xs">{{$alimento->AlimentoNombre}}</p></td>
                            <td class="align-middle"><p class="text-xs">{{$alimento->AlimentoCantidad}} {{$alimento->AlimentoUnidadMedida}}</p></td>
                            <td class="align-middle"><p class="text-xs">${{($alimento->AlimentoCostoTotal * $alimento->AlimentoCantidad) / 100}}</p></td>
                            @if($cont==0)
                            <td class="align-middle" rowspan="{{$cantidadAlimentos}}"><p class="text-xs font-weight-bold">${{$comidaPorTipoPaciente->ComidaCostoTotal}}</p></td>
                            @endif
                            <?php $cont = $cont+1 ?>
                          </tr>
                        @endforeach
                      @endforeach
                          <tr>
                            <td class="align-middle"><p class="text-xs">Total</p></td>
                            <td class="align-middle"><p class="text-xs"></p></td>
                            <td class="align-middle"><p class="text-xs"></p></td>
                            <td class="align-middle"><p class="text-xs"></p></td>
                            <td class="align-middle"><p class="text-xs font-weight-bold">${{$tipoPaciente->HistorialTipoPacienteCostoTotal * $tipoPaciente->HistorialTipoPacienteCantidad}}</p></td>
                          </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div> 
      </div>
    @endif
  @endforeach
<!-------------- Header de Particular---------- -->
@foreach($historialTipoPaciente as $tipoPaciente)
  @if($tipoPaciente->TipoPacienteNombre == 'Particular')
    <div class="content-header" style="height: 45px">
          <?php 
            $paciente = App\Paciente::findOrFail($tipoPaciente->PacienteId);
            $persona = App\Persona::findOrFail($paciente->PersonaId);
          ?>
        <div class="row w-100">
          <div class="col">
            <p class="text-secondary text-left text-xs ml-2 font-weight-bold">Paciente: {{$persona->PersonaNombre}},{{$persona->PersonaApellido}}</p>
          </div>
          <div class="col">
            <p class="text-secondary text-center text-xs ml-3">Particular</p>
          </div>
          <div class="col">
            <p class="text-secondary text-right text-xs mr-0 font-weight-bold">Costo Total: ${{$tipoPaciente->HistorialTipoPacienteCostoTotal}}</p>
          </div>
        </div>
      </div>
  <!-------------- Tabla de  particular---------- -->
    <div class="container-fluid">
      <div class="row">
        <div class="card w-100 mt-1">
          <div class="card-body">
            <div class="col-lg-12">
              <div class="table-responsive-sm">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th scope="col"><p class="text-xs">Tipo de Comida</p></th>
                      <th scope="col"><p class="text-xs">Alimento</p></th>
                      <th scope="col"><p class="text-xs">Cantidad</p></th>
                      <th scope="col"><p class="text-xs">Costo Por alimento</p></th>
                      <th scope="col"><p class="text-xs">Costo Total</p></th>
                      </tr>
                  </thead>    
                  <tbody>
                        <?php
                          $comidasPorTipoPaciente = App\HistorialComidaPorTipoPaciente::where('HistorialTipoPacienteId',$tipoPaciente->HistorialTipoPacienteId)->get();
                        ?>
                        @foreach($comidasPorTipoPaciente as $comidaPorTipoPaciente)
                          <?php 
                            $alimentos = App\HistorialAlimentoPorComida::where('HistorialComidaPorTipoPacienteId',$comidaPorTipoPaciente->HistorialComidaPorTipoPacienteId)->get();
                            $cantidadAlimentos = count($alimentos);
                            $cont = 0 ?>
                        @foreach($alimentos as $alimento)  
                        <tr>  
                            @if($cont==0)
                            <td class="align-middle" rowspan="{{$cantidadAlimentos}}"><p class="text-xs">{{$comidaPorTipoPaciente->TipoComidaNombre}}</p></td>
                            @endif
                              <td class="align-middle"><p class="text-xs">{{$alimento->AlimentoNombre}}</p></td>
                              <td class="align-middle"><p class="text-xs">{{$alimento->AlimentoCantidad}} {{$alimento->AlimentoUnidadMedida}}</p></td>
                              <td class="align-middle"><p class="text-xs">${{$alimento->AlimentoCostoTotal * $alimento->AlimentoCantidad}}</p></td>
                              @if($cont==0)
                              <td class="align-middle" rowspan="{{$cantidadAlimentos}}"><p class="text-xs font-weight-bold">${{$comidaPorTipoPaciente->ComidaCostoTotal}}</p></td>
                              @endif
                              <?php $cont = $cont+1 ?>
                        </tr>
                        @endforeach
                        @endforeach
                        <tr>
                          <td><p class="text-xs">Total</p></td>
                          <td><p class="text-xs"></p></td>
                          <td><p class="text-xs"></p></td>
                          <td><p class="text-xs"></p></td>
                          <td><p class="text-xs font-weight-bold">${{$tipoPaciente->HistorialTipoPacienteCostoTotal }}</p></td>
                        </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
@endforeach
</div>
@push('custom-scripts')
<script type="text/javascript" src="{{asset('js/historial/eliminar.js')}}"></script>
@endpush
@endsection