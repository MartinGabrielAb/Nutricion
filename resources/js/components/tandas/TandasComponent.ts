import axios from "axios";

export default {
    props : ['id'],
    data:function(){ 
        return {
            listErrores :[],
            comidasRelevadas:[],
            comidasEnProgreso:[],
            comidasAux:[],
            comidas:[],
            allComidas:[],
            congelador:[],
            cantidadNormal:null,
            cantidadCongelador:null,
            comidaSelected:null,
            comidasNuevas:[],
            observacion:null,
            tandaNueva:[],
            tandas : [],
            relevamiento:null,
            enviar :false,
        }
    },
    mounted () {
        this.getAllComidas();
        this.actualizarComidas();

    },   
    methods :{

        async sendTanda(){
            var res = confirm("¿Esta seguro/a de enviar esta tanda?");
            if (res){
                await axios.post('/api/saveTanda/'+this.id,{
                    params:{
                        observacion: this.observacion,
                        comidas : this.comidasNuevas,
                    }
                }).then(response =>{
                    if(response.data.error){
                        this.listErrores = response.data.error;
                    }
                    else{
                        this.actualizarComidas();
                        this.comidasNuevas = [];
                        alert('Tanda agregada correctamente');
                    }
                })
                .catch(error => { console.log("Error comidas relevadas");})
            }
        },
        async getTandas(){
            await axios.get('/api/getTandasRelevamiento/'+this.id).then(response =>{
                this.tandas = response.data;
            })
            .catch(error => { console.log("Error finalizar");})
        },
        async getCongelador(){
            await axios.get('/api/getCongelador').then(response =>{
                this.congelador = response.data;
            })
            .catch(error => { console.log("Error getCongelador");})
        },
        async actualizarComidas(){
            await this.getComidasEnProgreso();
            await this.getComidasRelevadas();
            this.juntarComidas();
        },
  
        juntarComidas(){
            this.comidas = [];
            this.comidasEnProgreso.forEach(a => {
                this.comidas.push({
                    id : a.id,
                    nombre:a.nombre,
                    cantidadNormal : a.cantidadNormal,
                    cantidadCongelada : a.cantidadCongelada,
                })
            });
            this.comidasRelevadas.forEach(b => {
                let index = this.comidas.findIndex( comida => comida.id == b.id);
                if(index>-1){
                    this.comidas[index].cantidad = b.cantidad;
                }else{
                    this.comidas.push({
                        id : b.id,
                        nombre:b.nombre,
                        cantidad : b.cantidad,
                    })
                }
            });
        },
        async getComidasRelevadas(){
            this.comidasRelevadas = [];
            await axios.get('/api/getComidasDeRelevamiento/'+this.id).then(response =>{
                this.comidasRelevadas = response.data;
            })
            .catch(error => { console.log("Error comidas relevadas");})
        },
        async getComidasEnProgreso(){
            this.comidasEnProgreso = [];
            await axios.get('/api/getComidasEnProgreso/'+this.id).then(response =>{
                this.comidasEnProgreso = response.data;
            }).catch(error => { console.log("Error comidas en progreso");})
        },
        async getAllComidas(){
            this.allComidas = [];
            await axios.get('/api/getComidas').then(response =>{
                this.allComidas = response.data;
            }).catch(error => { console.log("Error comidas en progreso");})
        },

        async finalizar(){
            var res = confirm("¿Esta seguro/a desea finalizar el relevamiento?");
            if (res){
                await axios.post('/api/finalizar/'+this.id).then(response =>{
                    window.location.href = "/historial/" + response.data;
            })
            .catch(error => { console.log("Error getFinalizar");})      
            }
        },
            
        addComida(){
            const index = this.comidasNuevas.findIndex(comida => comida.id == this.comidaSelected.ComidaId);
            if(index >= 0){
                alert("La comida ya se encuentra en la lista");
                return;
            }
            if(this.cantidadNormal<0 || this.cantidadCongelador<0){
                alert("Las cantidades son incorrectas");return ;
            }
            if(this.cantidadNormal ==0 && this.cantidadCongelador==0){
                alert("Debe ingresar alguna de las cantidades");return ;
            }
            if(this.cantidadNormal ==null && this.cantidadCongelador==null){
                alert("Debe ingresar alguna de las cantidades");return ;
            }
            if(this.cantidadNormal == null) this.cantidadNormal = 0;
            if(this.cantidadCongelador == null) this.cantidadCongelador = 0;
            this.comidasNuevas.push(
                {
                    id : this.comidaSelected.ComidaId,
                    nombre : this.comidaSelected.ComidaNombre,
                    cantidadNormal : this.cantidadNormal,
                    cantidadCongelador :this.cantidadCongelador
                }
            );
        },
        removeComida(id){
            const index = this.comidasNuevas.findIndex(comida => comida.id == id);
            this.comidasNuevas.splice(index,1);

        }
    }
}