@extends('layouts.plantilla')
@section('contenido')
<div class="content-wrapper">
    <div class="container-fluid mt-3">
        <div class="row justify-content-center ">
            <div class="col">
                <div class="card ">
                    <div class="card-header">{{ __('Seleccionar menú') }}
                    </div> 
                    <div class="card-body">
                    <script>
                        var detalles = [];            
                    </script>
                        <form onSubmit="finalizar(event)">
                            @foreach($relevamientos as $relevamiento)
                                <div class="row text-center mb-3">
                                    <div class="col">
                                        Fecha: {{$relevamiento['fecha']}}
                                    </div>
                                    <div class="col">
                                        Turno: {{$relevamiento['turno']}}
                                    </div>
                                    <div class="col">
                                        {{$relevamiento['sala']}} - {{$relevamiento['pseudonimo']}}
                                    </div>
                                </div>
                                @foreach($relevamiento['comidas'] as $comida)
                                <script>
                                    detalles.push(<?php echo $comida['detalleRelevamientoId']?>);          
                                </script>

                                    <div class="row mt-2">
                                        <div class="col">
                                            Comida: {{$comida['comida']}}
                                        </div>
                                        <div class="col">
                                            Relevados: {{$comida['cantidad']}}
                                        </div>
                                        <div class="col">
                                        <select id="selectComida{{$comida['detalleRelevamientoId']}}" class="form-control form-control-sm">
                                        @foreach($comida['comidasMismoTipo'] as $com)
                                            @if($com->ComidaId == $comida['comidaId'])
                                                <option value='{{$com->ComidaId}}' selected>{{$com->ComidaNombre}}</option>
                                            @else
                                                <option value='{{$com->ComidaId}}' >{{$com->ComidaNombre}}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                        </div>
                                        <div class="col">
                                            <input class="formControl" type="number"  id="inputRequerida{{$comida['detalleRelevamientoId']}}" placeholder="Porciones requeridas" required/>
                                        </div>
                                        <div class="col">
                                            ¿Stock? <span class="divStock text-danger" id="divStock{{$comida['detalleRelevamientoId']}}"></span>
                                        </div>
                                    </div>
                                @endforeach
                                <hr>
                            @endforeach
                            <div class="row text-center">
                                <div class="col">
                                    <button type="button" data-toggle="modal"  data-target="#modalConfirmar" class="btn btn-sm btn-outline-primary">
                                        Finalizar 
                                    </button>    
                                    <span id="spanError" class="text-danger"></span>                        
                                </div>
                                
                            </div>

                            <!-- Modal -->
                            <!-- Modal para agregar y editar  -->

                            <div class="modal fade" id="modalConfirmar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <span class="modal-title" id="tituloModal">Confirmación</span>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>    
                                        <div class="modal-body">
                                            <p><span>¿Está seguro que desea seleccionar esas cantidades?</span></p>
                                            <p><span>Una vez finalizado no podra deshacer los cambios.</span></p>
                                        </div>
                                        <div class="modal-footer">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <button type="submit" id="btnGuardar" class="btn btn-sm btn-primary w-100"><i class="fas fa-check"></i><span>Confirmar </span></button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <button type="button" class="btn btn-sm btn-secondary w-100" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
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
@push('custom-scripts')
<script type="text/javascript" src="{{asset('js/seleccionarMenu/principal.js')}}"></script>

@endpush
@endsection