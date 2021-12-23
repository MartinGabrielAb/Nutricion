<template>
    <div class="card" v-if="historial">
        <div class="card-header text-center">
            <div class="row" >
                <div class="col">Fecha:{{historial.RelevamientoFecha}}</div>
                <div class="col">Turno:{{historial.RelevamientoTurno}}</div>
                <div class="col">Menú:{{historial.MenuNombre}}</div>
            </div>
        </div>
        <div class="card-body text-center">
            <div class="row"><div class="col">Pacientes</div></div>
            <div class="list-group-item list-group-item-action list-group-item-action" >
                <div class="row ">
                    <div class="col">Comida</div>
                    <div class="col">Porciones</div>
                    <div class="col">Costo por porción</div>
                    <div class="col">Subtotal</div>
                </div>
            </div>
            <div class="row" v-for="detalle in detalles" :key="detalle.id">
                <div class="col">
                    <div class="list-group-item list-group-item-action list-group-item-secondary" type="button" data-toggle="collapse" :data-target="'#detalle'+detalle.id">
                        <div class="row">
                            <div class="col">{{detalle.comida}}</div>
                            <div class="col">{{detalle.porciones}}</div>
                            <div class="col">${{(detalle.subtotal/detalle.porciones).toFixed(2)}}</div>
                            <div class="col">${{detalle.subtotal.toFixed(2)}}</div>
                        </div>
                    </div>
                    <div class="collapse" :id="'detalle'+detalle.id">
                        <div class="card card-body">
                            <div class="row ">
                                <div class="col">Alimento</div>
                                <div class="col">Cantidad por porción</div>
                                <div class="col">Costo por porción</div>
                                <div class="col">Subtotales</div>
                            </div>
                            <hr>
                            <div class="row" v-for="alimento in detalle.alimentos" :key="alimento.HistorialDetalleAlimentoId">
                                <div class="col">{{alimento.AlimentoNombre}}</div>
                                <div class="col">{{alimento.Cantidad}} {{alimento.UnidadMedida}}(s)</div>
                                <div class="col">${{(alimento.CostoTotal/detalle.porciones).toFixed(2)}}</div>
                                <div class="col">${{(alimento.CostoTotal).toFixed(2)}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-group-item list-group-item-action list-group-item-success" >
                <div class="row ">
                    <div class="col">Resumen</div>
                    <div class="col">Porciones:{{historial.porciones}}</div>
                    <div class="col">Total: ${{historial.total.toFixed(2)}}</div>
                </div>
            </div>
        </div>
        <div class="card-body text-center">
            <div class="row"><div class="col">Empleados</div></div>
            <div class="list-group-item list-group-item-action list-group-item-action" >
                <div class="row ">
                    <div class="col">Comida</div>
                    <div class="col">Porciones</div>
                    <div class="col">Costo por porción</div>
                    <div class="col">Subtotal</div>
                </div>
            </div>
            <div class="row" v-for="detalle in detallesEmpleados" :key="detalle.id">
                <div class="col">
                    <div class="list-group-item list-group-item-action list-group-item-secondary" type="button" data-toggle="collapse" :data-target="'#detalleEmpleado'+detalle.id">
                        <div class="row">
                            <div class="col">{{detalle.comida}}</div>
                            <div class="col">{{detalle.porciones}}</div>
                            <div class="col">${{(detalle.subtotal/detalle.porciones).toFixed(2)}}</div>
                            <div class="col">${{(detalle.subtotal).toFixed(2)}}</div>
                        </div>
                    </div>
                    <div class="collapse" :id="'detalleEmpleado'+detalle.id">
                        <div class="card card-body">
                            <div class="row ">
                                <div class="col">Alimento</div>
                                <div class="col">Cantidad por porción</div>
                                <div class="col">Costo por porción</div>
                                <div class="col">Subtotales</div>
                            </div>
                            <hr>
                            <div class="row" v-for="alimento in detalle.alimentos" :key="'detalleEmpleado'+alimento.HistorialDetalleAlimentoId">
                                <div class="col">{{alimento.AlimentoNombre}}</div>
                                <div class="col">{{alimento.Cantidad}} {{alimento.UnidadMedida}}(s)</div>
                                <div class="col">${{(alimento.CostoTotal/detalle.porciones).toFixed(2)}}</div>
                                <div class="col">${{alimento.CostoTotal.toFixed(2)}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-group-item list-group-item-action list-group-item-success" >
                <div class="row ">
                    <div class="col">Resumen</div>
                    <div class="col">Porciones:{{historial.porcionesEmpleados}}</div>
                    <div class="col">Total: ${{historial.totalEmpleados.toFixed(2)}}</div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript" src="./HistorialComponent.ts"></script>
