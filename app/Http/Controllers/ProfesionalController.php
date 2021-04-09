<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Paciente;
// use App\Persona;
// use App\Empleado;
// use App\Profesional;

// use DB;
// use App\Http\Requests\CrearProfesionalRequest;


// class ProfesionalController extends Controller
// {
//     public function __construct()
//     {
//         $this->middleware('auth');
//     }
//     /**
//      * Display a listing of the resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function index()
//     {
        
//         $profesionales = DB::table('profesional as prof')
//                     ->join('empleado as e','e.EmpleadoId','=','prof.EmpleadoId')
//                     ->join('persona as per','per.PersonaId','=','e.PersonaId')
//                     ->where('EmpleadoEstado',1)
//                     ->where('ProfesionalEstado',1)
//                     ->get();
//         return view('profesionales.principal',compact('profesionales'));
//     }

//     /**
//      * Show the form for creating a new resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function create()
//     {
//         return view('profesionales.create');
//     }

//     /**
//      * Store a newly created resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function store(CrearProfesionalRequest $request)
//     {
//         $datos = $request->All();
//         $persona = new Persona();
//         $profesional = new Profesional();
//         $persona->PersonaNombre = $datos['nombre'];
//         $persona->PersonaApellido = $datos['apellido'];
//         $persona->PersonaDireccion = $datos['direccion'];
//         $persona->PersonaCuil = $datos['cuil'];
//         $persona->PersonaTelefono = $datos['telefono'];
//         $persona->PersonaSexo = $datos['sexo'];
//         $persona->PersonaEmail = $datos['email'];
//         $persona->PersonaEstado = 1;
//         $persona->save();
//         $empleado = new Empleado();
//         $empleado->PersonaId = $persona->PersonaId;
//         $empleado->EmpleadoEstado = 1;
//         $empleado->save();
//         $profesional->EmpleadoId = $empleado->EmpleadoId;
//         $profesional->ProfesionalMatricula = $datos['matricula'];
//         $profesional->profesionalEstado = 1;
//         $profesional->save();
//         return redirect()->action('ProfesionalController@index');
//     }

//     /**
//      * Display the specified resource.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function show($id)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function edit($id)
//     {
//         $profesional = DB::table('profesional as prof')
//                     ->join('empleado as e','e.EmpleadoId','=','prof.EmpleadoId')
//                     ->join('persona as per','per.PersonaId','=','e.PersonaId')
//                     ->where('ProfesionalId',$id)
//                     ->first();
//         return view('profesionales.edit',compact('profesional'));
//     }

//     /**
//      * Update the specified resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function update(CrearProfesionalRequest $request, $id)
//     {   
//         $profesional = Profesional::FindOrFail($id);
//         $datos = $request->all();
//         $empleado = Empleado :: FindOrFail($profesional->EmpleadoId);
//         $persona = Persona::FindOrFail($empleado->PersonaId);
//         $persona->PersonaNombre = $datos ['nombre'];
//         $persona->PersonaApellido = $datos ['apellido'];
//         $persona->PersonaCuil = $datos ['cuil'];
//         $persona->PersonaDireccion = $datos ['direccion'];
//         $persona->PersonaEmail = $datos['email'];
//         $persona->PersonaTelefono = $datos ['telefono'];
//         $persona->PersonaSexo = $datos ['sexo'];
//         $persona->Update();
//         $profesional->ProfesionalMatricula = $datos['matricula'];
//         $profesional->update();
//         return redirect()->action('ProfesionalController@index');
//     }

//     /**
//      * Remove the specified resource from storage.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function destroy($id)
//     {
//         $profesional = Profesional::FindOrFail($id);
//         $profesional->ProfesionalEstado = 0;
//         $profesional->update();
//         return redirect()->action('ProfesionalController@index');
//     }
// }
