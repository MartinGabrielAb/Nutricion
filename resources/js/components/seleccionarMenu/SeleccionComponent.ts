import axios from "axios";

export default {
    data:function(){ 
        return {
            relevamientoAnteriorId:null,
            relevamientoSelected:null,
            relevamientos:[],
            relevamientoAnterior: null,
            relevamientosSinMenu:[],
            menues : [],
            menuSelected : null,
            listErrores:null,
        }
    },
    mounted () {
        axios.get('/api/getRelevamientosAnteriores',{
            headers: { "Content-Type" : "application/json",
                "X-Requested-With": "XMLHttpRequest" }}).then(response =>{
                this.relevamientos = response.data;
            }).catch(error => {console.log("Error relevamientos pendientes");});
        axios.get('/api/getRelevamientosSinMenuAsignado').then(response =>{
                this.relevamientosSinMenu = response.data    
            }).catch(error => { console.log("Error menues sin asignar");});
        axios.get('/api/getMenues').then(response =>{
                this.menues = response.data    
            }).catch(error => { console.log("Error menues");})
    },
    methods :{
            // inputChange(){
            // let inputValue = (document.getElementById(`detalle${this.relevamientoAnterior[0].id}`) as HTMLInputElement);
            // },

            getRelevamiento(){
                axios.get('/api/getRelevamientoPorMenu/'+this.relevamientoAnteriorId)
                .then(response =>{
                    this.relevamientoAnterior = response.data;
                })
                .catch(error => { console.log("Error getRelevamiento");})
            },
        

            finalizar(){
                // var aux_anterior = {};
                // for (const property in this.relevamientoAnterior) {
                //     console.log(`${property}: ${this.relevamientoAnterior[property].cantidad}`);
                //     let input = document.getElementsByName(`detalle${this.relevamientoAnterior[property].id}`);
                //     console.log();
                //     aux_anterior[`${property}`] = {
                //         id : `${this.relevamientoAnterior[property].id}`,
                //         cantidad : document.getElementById(`detalle${this.relevamientoAnterior[property].id}`),
                //         nombre : `${this.relevamientoAnterior[property].nombre}`
                //     }
                // }
                  
                // console.log(this.relevamientoAnterior);
                // return;
                if(window.confirm("Una vez terminado no podra hacer cambios. ¿Desea finalizar?")){
                axios.post('/api/seleccionarMenu',{params:{
                    relevamientoAnt : this.relevamientoAnterior,
                    relevamientoNuevo: this.relevamientoSelected,
                    menu: this.menuSelected,
                }}).then(response =>{
                        if(response.data.error){
                            this.listErrores = response.data.error;
                        }
                        else{
                            window.location.href = "/seleccionarMenu/" + this.relevamientoSelected;
                        }
                    })
                .catch(error => { console.log("Error finalizar");})
                }
            }
    }
}