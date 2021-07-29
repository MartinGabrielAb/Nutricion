<template>
<div class="container-fluid" >
    <div class="row">
      <div class="col-lg-12">
        <div class="card" id = "divNutrientes">
          <div class="card-body">
            <button type="button" class="btn btn-sm btn-outline-primary" @click="fillComidas()" data-toggle="modal"  data-target="#modalElegir">
                Simular nutrientes
            </button>
            <table id="tableNutrientes" class="table table-sm table-striped table-bordered table-hover" style="width:100%" cellspacing="0">
              <thead>
                <tr>
                  <th class="text-xs text-center"><small>Tipo</small></th>
                  <th class="text-xs text-center"><small>Comida</small></th>
                  <th class="text-xs text-center"><small>Alimento</small></th>
                  <th class="text-xs text-center"><small>Cantidad</small></th>
                  <th class="text-xs text-center"
                        v-for="nutriente in nutrientes" 
                        :key="nutriente.NutrienteId">
                    <small>{{nutriente.NutrienteNombre}}</small></th>
                </tr>
              </thead>
              <tbody>
                    <template  v-for="comida in listNutrientes.comidas" >
                      <template v-for="(alimento,index) in comida.alimentos">
                        <tr v-if="index == 0" :key="alimento.alimentoId">
                          <td  class="text-xs text-center" :rowspan="comida.alimentos.length"><small>{{comida.tipoComida}}</small></td>
                          <td  class="text-xs text-center" :rowspan="comida.alimentos.length"><small>{{comida.comida}}</small></td>
                          <td  class="text-xs text-center"><small>{{alimento.alimento}}</small></td>
                          <td  class="text-xs text-center"><small>{{alimento.cantidad}}</small></td>
                          <td v-if="alimento.nutrientes.length ==0"  class="text-xs text-center" colspan="19" ><small>Debe asignar los nutrientes</small></td>
                          <td v-else v-for="nutriente in alimento.nutrientes" :key="nutriente.nutriente"  class="text-xs text-center"><small>{{nutriente.nutriente}}</small></td>
                  
                        </tr>
                        <tr v-else :key="alimento.alimentoId">
                            <td  class="text-xs text-center"><small>{{alimento.alimento}}</small></td>
                            <td  class="text-xs text-center"><small>{{alimento.cantidad}}</small></td>
                            <td v-if="alimento.nutrientes.length ==0"  class="text-xs text-center" colspan="19" ><small>Debe asignar los nutrientes</small></td>
                            <td v-else v-for="nutriente in alimento.nutrientes" :key="nutriente.nutriente"  class="text-xs text-center"><small>{{nutriente.nutriente}}</small></td>
                            
                        </tr>
                      </template> 
                    </template>                 
        
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
   <!-- Modal para elegir las comidas para simular -->
    <div class="modal fade" id="modalElegir" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <span class="modal-title" id="tituloModal">Seleccione las comidas para simular</span>
                <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>    
                <div class="modal-body">
                   <div class="row" v-for="comida in comidas" :key="comida.ComidaId" >
                       <div class="col">
                            <input type="checkbox" @click="addComida(comida.ComidaId)" :id="comida.ComidaId" />
                            <label :for="comida.ComidaId">{{comida.ComidaNombre}}</label>
                       </div>
                   </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-primary" @click="simularNutrientes()">
                                        Simular 
                        </button>                   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>
<script type="text/javascript" src="./SimularComponent.ts"></script>
