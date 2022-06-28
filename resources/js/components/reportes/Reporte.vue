<template>
<div>
  <table id="tableAlmuerzo" class="table-sm table-bordered text-sm-center">
    <thead>
      <tr>
        <th><small  class="font-weight-bold">Almuerzo</small></th>
        <th v-for="(comida,id) in comidasAlmuerzo" :key="id"><small>{{comida}}</small></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(sala, id) in almuerzo" :key="id">
        <td scope="col"><small>{{sala.sala}}</small></td>
        <td v-for="(comida,index) in comidasAlmuerzo" :key="index">
          <small>{{sala[index]?sala[index] : 0}}</small>
        </td>
      </tr>
      <tr>
        <th><small  class="font-weight-bold">Totales</small></th>
        <td v-for="(comida,index) in comidasAlmuerzo" :key="index">
          <small>{{totalesAlmuerzo[index]?totalesAlmuerzo[index] : 0}}</small>
        </td>
      </tr>
    </tbody>
  </table>
<hr>
  <table id="tableDesayuno" class="table-sm table-bordered text-sm-center">
    <thead>
      <tr>
        <th><small  class="font-weight-bold">Desayuno</small></th>
        <th v-for="(comida,id) in comidasDesayuno" :key="id"><small>{{comida}}</small></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(sala, id) in desayuno" :key="id">
        <td scope="col"><small>{{sala.sala}}</small></td>
        <td v-for="(comida,index) in comidasDesayuno" :key="index">
          <small>{{sala[index]?sala[index] : 0}}</small>
        </td>
      </tr>
      <tr>
        <th><small  class="font-weight-bold">Totales</small></th>
        <td v-for="(comida,index) in comidasDesayuno" :key="index">
          <small>{{totalesDesayuno[index]?totalesDesayuno[index] : 0}}</small>
        </td>
      </tr>
    </tbody>
  </table>
</div>
</template>

<script type="text/javascript" src="./Reporte.ts"></script>