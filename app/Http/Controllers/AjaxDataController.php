<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;;
use DB;
class AjaxDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
	function getPacientes(){
	
		$pacientes = DB::table('paciente as pac')
                    ->join('persona as per','per.PersonaId','=','pac.PersonaId')
                    ->where('PacienteEstado',1)
                    ->get();
        return compact('pacientes');
	}


	function getEmpleados(){
	
		$empleados = DB::table('empleado as e')
                    ->join('persona as per','per.PersonaId','=','e.PersonaId')
                    ->where('EmpleadoEstado',1)
                    ->get();
        return compact('empleados');
	}


	function getProfesionales(){
	
		$profesionales = DB::table('profesional as prof')
                    ->join('empleado as e','e.EmpleadoId','=','prof.EmpleadoId')
                    ->join('persona as per','per.PersonaId','=','e.PersonaId')
                    ->where('EmpleadoEstado',1)
                    ->where('ProfesionalEstado',1)
                    ->get();
        return compact('profesionales');
	}


    function getMenues(){
    
        $menues = DB::table('menu')->where('MenuEstado',1)
                                ->where('MenuParticular',0)
                                ->get();
        return compact('menues');
    }
    function getParticulares(){
    
        $particulares = DB::table('menu')->where('MenuEstado',1)
                                ->where('MenuParticular',1)
                                ->get();
        return compact('particulares');
    }

    function getMenuTipo(Request $request){
    
        $menuId = $request['id'];
        $menues = DB::table('detallemenutipopaciente')->where('MenuId',$menuId)
                                    ->get();
   
        return compact('menues');
    }
     function getComidaPorTipoPaciente(Request $request){
    
        $menuId = $request['id'];
        $tiposComida = DB::table('comidaportipopaciente')
                        ->where('DetalleMenuTipoPacienteId',$menuId)
                        ->get();
   
        return compact('tiposComida');
    }
function getAlimentos(){
    
        $alimentos = DB::table('alimento')
                    ->where('AlimentoEstado',1)
                    ->get();
        return compact('alimentos');
    }

    function getComidas(){
    
        $comidas = DB::table('comida as c')
                    ->where('c.ComidaEstado',1)
                    ->get();
        return compact('comidas');
    }

    function getRelevamientos(){
    
        $relevamientos = DB::table('relevamiento')
                                ->where('RelevamientoEstado',1)
                                ->get();
        return compact('relevamientos');
    }

    function getDetallesRelevamiento($id){
    
        $detallesRelevamiento = DB::table('detallerelevamiento as dr')
                                ->join('cama as c','c.CamaId','dr.CamaId')
                                ->join('pieza as p','p.PiezaId','c.PiezaId')
                                ->join('sala as s','s.SalaId','p.SalaId')
                                ->join('paciente as pa','pa.PacienteId','dr.PacienteId')
                                ->join('persona as pe','pe.PersonaId','pa.PersonaId')
                                ->where('dr.DetalleRelevamientoEstado',1)
                                ->get();
        return compact('detallesRelevamiento');
    }

    function getUsuarios(){
    
        $usuarios = DB::table('users')
                    ->get();
        return compact('usuarios');
    }
    function getNutrientesPorAlimento(){
        $nutrientesPorAlimento = DB::table('nutrienteporalimento')
                                    ->get();
        return compact('nutrientesPorAlimento');
    }
}

