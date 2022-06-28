import axios from "axios";

export default {
    props:['id'],
    data:function(){ 
        return {
            comidasRelevadas : null,
            desayuno : {},
            comidasDesayuno : {},
            totalesDesayuno:{},
            almuerzo: {},
            comidasAlmuerzo:{},
            totalesAlmuerzo :{},

        }
    },
    async mounted(){
        await this.getComidasRelevadas();
        await this.getReportes();

    },

    methods : {
        async getComidasRelevadas(){
            this.comidasRelevadas = [];
            await axios.get('/api/getRelevamientoPorSalaYTipoComida/'+this.id).then(response =>{
                this.comidasRelevadas = response.data;
                console.log( this.comidasRelevadas);
            })
            .catch(error => { console.log("Error comidas relevadas");})
        },

        async getReportes(){ 
            let reporteDesayuno = ['Desayuno', 'Merienda']; //Tipos de comida para hacer el reporte
            let reporteAlmuerzo = ['Sopa','Postre', 'Pan','Cena '];
            let desayuno  = {};            
            let comidasDesayuno ={};
            let totalesDesayuno = {};
            let almuerzo = {};
            let comidasAlmuerzo = {};
            let totalesAlmuerzo  = {};            
            this.comidasRelevadas.forEach(sala => {
                desayuno[sala.id] = {'sala' : sala.nombre};
                almuerzo[sala.id] = {'sala' : sala.nombre};
                sala.tipo.forEach(tipo => {
                    if(reporteDesayuno.includes(tipo.nombre)){
                        tipo.comidas.forEach(comida => {
                            comidasDesayuno[comida.id] = comida.nombre;
                            desayuno[sala.id][comida.id] = comida.cantidad;
                            totalesDesayuno[comida.id] ? totalesDesayuno[comida.id] += comida.cantidad : totalesDesayuno[comida.id] = comida.cantidad;

                        });
                    }
                    if(reporteAlmuerzo.includes(tipo.nombre)){
                        tipo.comidas.forEach(comida => {
                            comidasAlmuerzo[comida.id] = comida.nombre;
                            almuerzo[sala.id][comida.id] = comida.cantidad;
                            totalesAlmuerzo[comida.id] ?totalesAlmuerzo[comida.id] += comida.cantidad :  totalesAlmuerzo[comida.id] = comida.cantidad;
                        });
                    }
                });
            });
            this.desayuno = desayuno;
            this.comidasDesayuno =comidasDesayuno;
            this.totalesDesayuno =totalesDesayuno;
            this.almuerzo = almuerzo;
            this.comidasAlmuerzo =comidasAlmuerzo;
            this.totalesAlmuerzo =totalesAlmuerzo;
        }
    }

        
}