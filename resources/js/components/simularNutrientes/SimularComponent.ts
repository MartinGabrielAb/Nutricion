import axios from "axios";

export default {
    props : ["id"],
    data:function(){ 
        return {
            comidas : null,
            nutrientes: null,
            listComidasToSimulate : [],
            listNutrientes: [],
        }
    },
    mounted () {
       
        axios.get('/nutrientes').then(response =>{
                this.nutrientes = response.data;
            }).catch(error => { console.log("errorr");
        });
        
        
    },

    
    
    methods :{
        fillComidas(){
            this.comidas = [];  
            axios.get('/comidaportipopaciente/'+this.id).then(response =>{
                this.comidas = response.data; 
            }).catch(error => { console.log("errorr"); });
        },

        addComida(id){
            let index = this.listComidasToSimulate.indexOf(id);
            if (index!=-1){
                this.listComidasToSimulate.pop(index);

                return;
            } 
            this.listComidasToSimulate.push(id);

            return;
        },
        simularNutrientes(){
            $('#modalElegir').modal('hide');
            this.listNutrientes =[];
            axios.get('/comidaportipopaciente/'+this.id+"/edit",{params:{comidas:this.listComidasToSimulate}}).then(response =>{
                this.listNutrientes = response.data;
                console.log(this.listNutrientes);
            }).catch(error => { console.log("errorr");});
        }



    }
}