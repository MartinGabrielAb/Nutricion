import axios from "axios";

export default {
    props:['id'],
    data:function(){ 
        return {
            historial : null,
            detalles : null,
        }
    },
    mounted(){
        axios.get('/historial/'+this.id,{
            headers: { "Content-Type" : "application/json",
                "X-Requested-With": "XMLHttpRequest" }})
            .then(response =>{
                this.historial = response.data.historial;
                this.historial.total = 0;
                this.historial.porciones = 0;
                this.detalles = response.data.detalles;
                this.detalles.forEach(detalle => {
                    detalle.subtotal = 0;
                    detalle.alimentos.forEach(alimento => {
                        detalle.subtotal += alimento.CostoTotal;
                    });                     
                    this.historial.total += detalle.subtotal;
                    this.historial.porciones += detalle.porciones;
                });
                console.log(this.historial);
                console.log(this.detalles);
            }).catch(error => {console.log("Error historial");})
    }
}