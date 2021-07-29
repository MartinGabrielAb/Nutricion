import axios from "axios";

export default {
    props : ['relevamientoNuevo','relevamientoAnt'],
    data:function(){ 
        return {
            
            comidasAnteriores:null,
            comidasNuevas:null,
            relevamiento:null,
        }
    },
    mounted () {
        console.log("relevamientoss");
        console.log(this.relevamientoNuevo,this.relevamientoAnt);
        // this.getComidasEnProgreso();
    },   
    methods :{
        getComidasAnteriores(){
            axios.get('/api/getComidasDeRelevamiento/'+this.relevamientoAnt).then(response =>{
                this.comidasEnProgreso = response.data;
                console.log(this.comidas);
            })
            .catch(error => { console.log("Error getRelevamiento");})
        },
        getComidasEnProgreso(){
            axios.get('/api/getComidasEnProgreso/'+this.id).then(response =>{
                this.comidasEnProgreso = response.data;
                console.log(this.comidas);
            })
            .catch(error => { console.log("Error getRelevamiento");})
        },
    }
}