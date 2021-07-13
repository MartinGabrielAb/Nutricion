window.Vue = require('vue');

Vue.component('simular-component', require('./components/simularNutrientes/SimularComponent.vue').default);
Vue.component('seleccion-component',require('./components/seleccionarMenu/SeleccionComponent.vue').default);
Vue.component('historial-component',require('./components/historial/HistorialComponent.vue').default);

const app = new Vue({
    el: '#app',
});


