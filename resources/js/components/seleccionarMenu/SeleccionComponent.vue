<template>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col">
                Seleccion de menú
            </div>
            <div class="col">
                Seleccione el relevamiento anterior:
                <select v-if="relevamientos.length>0" class="w-100" v-model="relevamientoAnteriorId" @change="getRelevamiento()">
                    <option v-for="relevamiento in relevamientos" :key="relevamiento.RelevamientoId" :value="relevamiento.RelevamientoId">
                        {{ relevamiento.RelevamientoFecha}}({{relevamiento.RelevamientoTurno}})
                    </option>
                </select>
            </div>
        </div>
    </div> 
    <div class="card-body">
        <template v-if="relevamientos.length==0">
            <span class="text-center">No hay relevamientos pendientes.</span>
        </template>
        <template v-else-if="relevamientoAnteriorId==null">
            <span class="text-center">Debe seleccionar un relevamiento.</span>
        </template>
        <template v-else>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col font-weight-bold">Tipo de paciente:</div>
                        <div class="col text-center">Cantidad</div>
                    </div>
                    <div v-for="detalle in relevamientoAnterior" class="row border" :key="detalle.id">
                        <div class="col">
                            {{detalle.nombre}}
                        </div>
                        <div class="col text-center">
                            {{detalle.cantidad}}
                            <!-- <input type="number" value="" id="cantidades[]">                              -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row font-weight-bold">
                        <div class="col">Selección de menú</div>
                    </div>
                    <div class="row">
                        <div class="col">Seleccione el nuevo relevamiento para asignar el menú  </div>
                        <div class="col">
                            <select class="w-100" v-model="relevamientoSelected">
                                <option v-for="rel in relevamientosSinMenu" :key="rel.RelevamientoId" :value="rel.RelevamientoId">
                                    {{ rel.RelevamientoFecha }} - {{rel.RelevamientoTurno}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <template  v-if="relevamientoSelected>0">
                        <div class="row mt-4">
                            <div class="col">
                                Seleccione el menú
                            </div>
                            <div class="col">
                                <select class="w-100" v-model="menuSelected">
                                    <option v-for="menu in menues" :key="menu.MenuId" :value="menu.MenuId">
                                        {{ menu.MenuNombre }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <template v-if="menuSelected>0">
                            <div class="row">

                            </div>
                            <div class="row text-center">
                                <div class="col">
                                    <button type="button"  @click="finalizar()" class="btn btn-primary mt-3">Finalizar selección</button>

                                </div>
                            </div>
                        </template>
                    </template>
                   
                </div>
            </div>
            <div class="card" v-if="listErrores">
                <h5 class="text-danger">Errores:</h5>
                <ul v-for="error in listErrores" :key="error.ComidaId">
                    <li class="text-danger">No posee {{error[1]}} porciones de {{error[0].ComidaNombre}}</li>
                </ul>
            </div>
        </template>  
    </div>
</div>
   
</template>
<script type="text/javascript" src="./SeleccionComponent.ts"></script>




