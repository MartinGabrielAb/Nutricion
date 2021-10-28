import axios from "axios";

export default {
    props:['id'],
    data:function(){ 
        return {
            historial : null,
            detalles : null,
            detallesEmpleados : null,
        }
    },
    mounted(){
        axios.get('/historialPacientes/'+this.id,{
            headers: { "Content-Type" : "application/json",
                "X-Requested-With": "XMLHttpRequest" }})
            .then(response =>{
                this.historial = response.data.historial;
                this.historial.total = 0;
                this.historial.porciones = 0;
                this.historial.totalEmpleados = 0;
                this.historia.porcionesEmpleados = 0;
                this.detalles = response.data.detalles;
                this.detallesEmpleados = response.data.detallesEmpleados;
                this.detalles.forEach(detalle => {
                    detalle.subtotal = 0;
                    detalle.alimentos.forEach(alimento => {
                        detalle.subtotal += alimento.CostoTotal;
                    });                     
                    this.historial.total += detalle.subtotal;
                    this.historial.porciones += detalle.porciones;
                });
                this.detallesEmpleados.forEach(detalle => {
                    detalle.subtotal = 0;
                    detalle.alimentos.forEach(alimento => {
                        detalle.subtotal += alimento.CostoTotal;
                    });                     
                    this.historial.totalEmpleados += detalle.subtotal;
                    this.historial.porcionesEmpleados += detalle.porciones;
                });
            }).catch(error => {console.log("Error historial");})
         }
}