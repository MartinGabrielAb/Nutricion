

@extends('layouts.plantilla')
@section('contenido')
@php
    $historialFechaActualMañana = App\Historial::where('HistorialEstado',1)->where('HistorialFecha',$relevamiento->RelevamientoFecha)->where('HistorialTurno','Mañana')->first();
@endphp
<div class="content-wrapper">
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card w-100 mt-2">
                <div class="card-header">
                  <div class="row">
                    <div class="col text-left">
                      {{ __('Seleccionar menú') }}: Relevamiento {{$relevamiento->RelevamientoId}}
                    </div>
                    <div style="display: none" id="relevamientoId">{{$relevamiento->RelevamientoId}}</div>
                    <div class="col alert-sm text-sm" id="divMensaje" name="divMensaje">
                      
                    </div>
                    <div class="col text-right" >
                      <!-- <button class="btn btn-sm btn-default" id="btnAgregar" data-toggle="modal" data-target="#modalAgregar">Seleccionar menú</button> -->
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-4">
                      {{ __('Menu general') }}
                    </div>
                    <div class="col-lg-8">
                      @if (!$historialFechaActualMañana)
                        <select class="form-control" id="selectGeneral" name="selectGeneral" style="width:40%">
                          <option></option>
                          @foreach ($menuesGenerales as $menuGeneral)
                              <option value="{{$menuGeneral->MenuId}}">{{$menuGeneral->MenuNombre}}</option>
                          @endforeach
                        </select>
                      @else
                        @push('custom-scripts')
                          <script>
                            $("#selectGeneral").prop("disabled", true); 
                          </script>
                        @endpush
                        <select class="form-control d-inline" id="selectGeneral" name="selectGeneral" style="width:40%">
                          <option></option>
                          @foreach ($menuesGenerales as $menuGeneral)
                              <option value="{{$menuGeneral->MenuId}}" {{ $menuGeneral->MenuNombre == $historialFechaActualMañana->MenuNombre ? "selected":"" }}>{{$menuGeneral->MenuNombre}}</option>
                          @endforeach
                        </select>
                        <div id="advertenciaId" class="d-inline text-sm text-warning">
                          El menú se selecciona por la mañana.
                        </div>
                      @endif
                      
                    </div>
                  </div>

                  <input type="hidden" id="fecha" name="fecha" value="{{$relevamiento->RelevamientoFecha}}">
                  <input type="hidden" id="turno" name="turno" value="{{$relevamiento->RelevamientoTurno}}">
                  <input type="hidden" id="cantParticulares" name="cantParticulares" value="{{count($detallesParticulares)}}">
                  @foreach($detallesParticulares as $detalleParticular)
                  <hr>
                  <div class="row">
                    <div class="col-lg-4">
                      {{ __('Menu particular') }} : {{$detalleParticular->PersonaApellido}}, {{$detalleParticular->PersonaNombre}}
                    </div>
                    <div class="col-lg-8">
                      <select class="form-control selectParticulares" id="selectParticular{{$detalleParticular->DetalleRelevamientoId}}" data-id="{{$detalleParticular->PacienteId}}" name="selectParticular{{$detalleParticular->DetalleRelevamientoId}}" style="width:40%">
                        <option></option>
                        @foreach ($menuesParticulares as $menuParticular)
                            <option value="{{$menuParticular->MenuId}}">{{$menuParticular->MenuNombre}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  @endforeach
                  <hr>
                  <div class="row">
                    <div class="col-lg-6">

                    </div>
                    <div class="col-lg-6">
                      <button type="button" class="btn btn-default" id="btnSeleccionar">Seleccionar</button>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@push('custom-scripts')
<script type="text/javascript" src="{{asset('js/historial/create.js')}}"></script>

@endpush

@endsection
