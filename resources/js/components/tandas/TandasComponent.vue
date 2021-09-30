<template>
    <div class="container-fluid" >
        <!-- Botones ver tandas y agregar -->
        <div class="row">
            <div class="col text-right">
                <button type="button" class="btn btn-sm btn-outline-primary" @click="actualizarComidas()">
                   Actualizar
                </button>
                <button type="button" class="btn btn-sm btn-outline-primary" @click="getTandas()" data-toggle="modal"  data-target="#modalTandasEnviadas">
                    Tandas enviadas
                </button>
            </div>
        </div>
        <!-- Tabla de cantidades -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card" >
                    <div class="card-body">
                        <div class="row text-sm text-center">
                            <div class="col-lg-6 col-md-3 col-sm-3 col-xs-2"> 
                                Comida
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-2">
                                En preparación
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-2">
                                Cantidad del congelador
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-2">
                                Cantidad relevada
                            </div>
                        </div>
                        <hr>
                        <div class="row text-sm  text-center" v-for="comida in comidas" :key="comida.id">
                            <div class="col-lg-6 col-md-3 col-sm-3 col-xs-2">
                                {{comida.nombre}}
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-2">
                                {{comida.cantidadNormal ? comida.cantidadNormal : 0}}
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-2">
                                {{comida.cantidadCongelada ? comida.cantidadCongelada : 0}}
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-2">
                                {{comida.cantidad ? comida.cantidad :0 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Agregar tanda -->
        <div class="row">
            <div class="col">
                <div class="card" >
                    <div class="card-body">
                        <div class="row text-sm mb-3">
                            <div class="col">Nueva tanda</div>
                            <div class="col ">
                                <textarea class="w-100" rows="1"  v-model="observacion" placeholder="Observaciones"></textarea>
                            </div>
                            <div class="col text-right">
                                <button type="button" class="btn btn-sm btn-outline-primary"  @click="getCongelador()" data-toggle="modal"  data-target="#modalCongelador">
                                    Ver congelador
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="row text-sm ">
                            <div class="col input-group ">
                                <select class="w-100" v-model="comidaSelected">
                                    <option v-for="comida in allComidas" :key="comida.ComidaId" :value="comida">
                                        {{ comida.ComidaNombre }}
                                    </option>
                                </select>
                            </div>
                            <div class="col input-group">
                                <input class="mr-3" v-model="cantidadNormal" placeholder="Porciones a preparar" type="number">
                                <input class="mr-3" v-model="cantidadCongelador" placeholder="Porciones del congelador" type="number">
                                <button  type="button" class=" btn btn-sm btn-outline-primary" @click="addComida()">
                                   +
                                </button>
                            </div>                           
                        </div>
                        <hr>
                        <div class="row "  v-if="comidasNuevas.length > 0">
                            <div class="col">Comida</div>
                            <div class="col text-center">Cantidad a preparar</div>
                            <div class="col text-center">Cantidad del congelador</div>
                            <div class="col"></div>
                        </div>
                        <div class="row text-sm" v-for="comidaNueva in comidasNuevas" :key="comidaNueva.id" :value="comidaNueva.id">
                            <div class="col">{{comidaNueva.nombre}}</div>
                            <div class="col text-center">{{comidaNueva.cantidadNormal}}</div>
                            <div class="col text-center">{{comidaNueva.cantidadCongelador}}</div>
                            <div class="col text-center">
                                <button type="button btn-sm" class="btn btn-sm btn-outline-danger" @click="removeComida(comidaNueva.id)">
                                   x
                                </button>
                            </div> 
                        </div>
                        <div class="row text-center" v-if="comidasNuevas.length > 0">
                            <div class="col">
                                <button type="button btn-sm" class="btn btn-sm btn-outline-primary" @click="sendTanda()">
                                  Enviar tanda
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button btn-sm" class="btn btn-sm btn-outline-primary" @click="finalizar()">
                        Finalizar relevamiento
                    </button>
                </div>
            </div>
        </div>
        <div class="card" v-if="listErrores">
                <h5 class="text-danger">Errores:</h5>
                <ul v-for="error in listErrores" :key="error.id">
                    <li class="text-danger">No posee {{error.cantidadNormal}} porciones de {{error.nombre}}</li>
                </ul>
        </div>
        <!-- Modal para ver las tandas enviadas -->
        <div class="modal fade" id="modalTandasEnviadas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <span class="modal-title" id="tituloModal">Tandas enviadas</span>
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>    
                    <div class="modal-body">
                        <template v-for="tanda in tandas">
                            <div class="row" :key="tanda.numero">
                                <div class="col"><span>Tanda:{{tanda.numero}}</span></div>
                            </div>
                            <div class="row" :key="tanda.observacion">
                                <div class="col">Observaciones: {{tanda.observaciones}}</div>
                                <div class="col">Hora:{{tanda.hora}}</div>
                            </div>
                            <div class="row">
                                <div class="col">Comida</div>
                                <div class="col">Cantidad normal</div>
                                <div class="col">Cantidad congelada</div>
                            </div>
                            <div class="row" v-for="comida in tanda.comidas" :key="comida.id">
                                <div class="col">{{comida.nombre}}</div>
                                <div class="col">{{comida.cantidadNormal}}</div>
                                <div class="col">{{comida.cantidadCongelada}}</div>
                            </div>
                            <hr>
                        </template>
                        <div class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal" >
                                            Cerrar 
                            </button>                   
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para ver el congelador -->
        <div class="modal fade" id="modalCongelador" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <span class="modal-title" id="tituloModal">Congelador</span>
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>    
                    <div class="modal-body">
                        <table>
                            <tbody >
                                <tr v-for="comida in congelador" :key="comida.id">
                                    <td>{{comida.ComidaNombre}}</td>
                                    <td>{{comida.Porciones}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
    
<script type="text/javascript" src="./TandasComponent.ts"></script>