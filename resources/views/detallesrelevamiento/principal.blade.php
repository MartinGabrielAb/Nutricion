<!-- Main content -->
<div class="container-fluid">
    <input type="hidden" id="relevamientoId" value="{{$relevamiento->RelevamientoId}}">
    <div class="row">
    <div class="col-lg-12">
        <div class="card">
        <div class="card-body">
            <div class="row">
                
            </div>
            <div class="row ">
                <div class="col border d-flex justify-content-center">
                    <label class="m-3">Piezas: </label>
                    @foreach ($piezas as $pieza)
                        <button type="button" id="btnPiezaid{{$pieza->PiezaId}}" class="btn btn-sm btn-default clsPiezas m-2 pl-3 pr-3" onclick="getcamas({{$pieza->PiezaId}})">
                            {{$pieza->PiezaPseudonimo}}
                        </button>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div id="divCamas" class="col border d-none justify-content-center">
                    <label class="m-3">Camas: </label>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div id="divMensaje" class="alert text-center p-0">
                        <!-- Mensaje de exito/error -->
                    </div>
                </div>
            </div>
            <div id="divDetalleRelevamiento" class="row d-none">

            </div>
            <!--------------TABLA PRINCIPAL-------------->
            {{-- <div class="row">
                <div class="col">
                    <table id="tableDetallesRelevamiento" class="table table-sm table-striped table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                    <!------Cabecera de la tabla------>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Paciente</th>
                            <th scope="col">Menú</th>
                            <th scope="col">Regímen</th>
                            <th scope="col">Acompañante</th>
                            <th scope="col">VD</th>
                            <th scope="col">P/C</th>
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
            </div> --}}
        </div>
        </div>
    </div>
    <!-- /.col-md-6 -->
    </div>
</div><!-- /.container-fluid -->


<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form onSubmit="guardar(event)" style="width: 100%">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="tituloModal"></span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modal-body-comidas" class="moda-body d-none"></div>
                <div id="modal-body" class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="camaId" name="camaId">
                    <div class="row">
                        <div class="col-6">
                            <label for="pacienteId">Paciente</label>
                        </div>
                        <div class="col-6">
                            <label id="respuestaUltimoRelevamiento"></label>
                        </div>
                    </div>
                    <div class="form-inline pb-2 border-bottom">
                        <select class="form-control" id="pacienteId" name="pacienteId" style="width: 83%" required>
                            @foreach ($pacientes as $paciente)
                                <option value="{{$paciente->PacienteCuil}}">{{$paciente->PacienteApellido}}, {{$paciente->PacienteNombre}} - {{$paciente->PacienteCuil}}</option>
                            @endforeach
                        </select>
                        <button type="button" id="ultimoRelevamientoId" onclick="getUltimoDetRelevamientoPaciente()" class="btn btn-sm btn-default ml-3" style="width: 10%"><i title="Último relevamiento del paciente" class="fas fa-undo-alt"></i></button>
                    </div>
                    <div class="form-inline m-0 pb-2 border-bottom">
                        <label for="diagnosticoId">Diagnóstico</label>
                        <textarea class="form-control" id="diagnosticoId" rows="2" style="width: 100%"></textarea>
                    </div>  
                    <div class="form-inline m-0 pb-2">
                        <label for="observacionesId">Observaciones</label>
                        <textarea class="form-control" id="observacionesId" rows="2" style="width: 100%"></textarea>
                    </div> 
                    <div class="form-inline border-top">
                        <label for="tipoPacienteId">Regímen</label>
                        <select class="form-control" id="tipoPacienteId" name="tipoPacienteId" style="width: 100%" required>
                            @foreach ($tiposPaciente as $tipoPaciente)
                                <option value="{{$tipoPaciente->TipoPacienteId}}">{{$tipoPaciente->TipoPacienteNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="menus" class="form-inline pb-2">
                        <label for="menu">Menú</label>
                        <select class="form-control" id="menu" name="menu" style="width: 100%" required>
                            @foreach ($menus as $menu)
                                <option value="{{$menu->MenuId}}">{{$menu->MenuNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="comidas" class="form-check mt-3 pl-0 border-bottom pb-2 d-none">
                        <div class="row border pb-2">
                            <div class="col">
                                <div class="row">
                                    <div class="col text-center">
                                        <p class="font-weight-bold m-0">Precargar menú</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 form-inline">
                                        <label for="precargarTipoPaciente">Regímen</label>
                                        <select class="form-control" id="precargarTipoPaciente" style="width: 100%">
                                            @foreach ($tiposPaciente as $tipoPaciente)
                                                <option value="{{$tipoPaciente->TipoPacienteId}}">{{$tipoPaciente->TipoPacienteNombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-5 form-inline">
                                        <label for="precargarMenu">Menú</label>
                                        <select class="form-control" id="precargarMenu" name="precargarMenu" style="width: 100%">
                                            @foreach ($menus as $menu)
                                                <option value="{{$menu->MenuId}}">{{$menu->MenuNombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-1 align-self-end form-inline p-0">
                                        <button type="button" id="btnPrecargarComidas" class="btn btn-sm btn-success p-2 ml-auto mr-auto"><i class="fas fa-check"></i></button>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                        
                        @if ($relevamiento->RelevamientoTurno == 'Mañana')
                            @foreach ($tiposcomida as $tipocomida)
                                @if ($tipocomida->TipoComidaNombre == 'Merienda' || $tipocomida->TipoComidaNombre == 'Cena' || $tipocomida->TipoComidaNombre == 'Sopa Cena' || $tipocomida->TipoComidaNombre == 'Postre Cena')
                                    <div class="form-inline">
                                        <label for="comidaid{{$tipocomida->TipoComidaId}}">{{$tipocomida->TipoComidaNombre}}</label>
                                        <select class="form-control clsComidas" id="comidaid{{$tipocomida->TipoComidaId}}" name="comidas[]"  style="width: 100%">
                                            @foreach ($tipocomida->comidas as $comida)
                                            <option value="{{$comida->ComidaId}}">{{$comida->ComidaNombre}}</option>
                                            @endforeach
                                        </select> 
                                    </div>
                                @endif
                            @endforeach    
                        @elseif(($relevamiento->RelevamientoTurno == 'Tarde'))
                            @foreach ($tiposcomida as $tipocomida)
                                @if ($tipocomida->TipoComidaNombre == 'Desayuno' || $tipocomida->TipoComidaNombre == 'Almuerzo' || $tipocomida->TipoComidaNombre == 'Sopa Almuerzo' || $tipocomida->TipoComidaNombre == 'Postre Almuerzo')
                                    <div class="form-inline">
                                        <label for="comidaid{{$tipocomida->TipoComidaId}}">{{$tipocomida->TipoComidaNombre}}</label>
                                        <select class="form-control clsComidas" id="comidaid{{$tipocomida->TipoComidaId}}" name="comidas[]"  style="width: 100%">
                                            @foreach ($tipocomida->comidas as $comida)
                                                <option value="{{$comida->ComidaId}}">{{$comida->ComidaNombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif 
                            @endforeach
                        @endif
                    </div>
                    <div class="form-inline border-bottom border-top pb-2">
                        <label for="colacion">Colación</label>
                        <select class="form-control" id="colacion" name="colacion" style="width: 100%">
                            @foreach ($colaciones as $colacion)
                                <option value="{{$colacion->ComidaId}}">{{$colacion->ComidaNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="1" id="acompanianteId" name="acompanianteId">
                        <label class="form-check-label" for="acompanianteId">
                            Acompañante
                        </label>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="1" id="vajilladescartable" name="vajilladescartable">
                        <label class="form-check-label" for="vajilladescartable">
                            Vajilla Descartable
                        </label>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="1" id="agregado" name="agregado">
                        <label class="form-check-label" for="agregado">
                            Agregado
                        </label>
                    </div>
                </div>
                <div id="modal-footer-comidas" class="modal-footer d-none">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-sm btn-secondary w-100" data-dismiss="modal"><i class="fas fa-times"></i> Salir</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="modal-footer" class="modal-footer">
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
<!-- Scripts actuales -->
<script type="text/javascript" src="{{asset('js/detallesrelevamiento/principal.js')}}"></script>
@endpush
