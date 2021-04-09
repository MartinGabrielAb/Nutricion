<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Empleado;
// use App\Persona;
// use DB;
// use App\Http\Requests\CrearPersonaRequest;

// class EmpleadoController extends Controller
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
//         $empleados = DB::table('empleado as e')
//                     ->join('persona as p','p.PersonaId','=','e.PersonaId')
//                     ->where('EmpleadoEstado',1)
//                     ->get();
//         return view('empleados.principal',compact('empleados'));

//     }

//     /**
//      * Show the form for creating a new resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function create()
//     {
//         return view('empleados.create');
//     }

//     /**
//      * Store a newly created resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function store(CrearPersonaRequest $request)
//     {
//         $datos = $request->All();
//         $persona = new Persona();
//         $empleado = new Empleado();
//         $persona->PersonaNombre = $datos['nombre'];
//         $persona->PersonaApellido = $datos['apellido'];
//         $persona->PersonaDireccion = $datos['direccion'];
//         $persona->PersonaCuil = $datos['cuil'];
//         $persona->PersonaTelefono = $datos['telefono'];
//         $persona->PersonaSexo = $datos['sexo'];
//         $persona->PersonaEmail = $datos['email'];
//         $persona->PersonaEstado = 1;
//         $persona->save();
//         $empleado->PersonaId = $persona->PersonaId;
//         $empleado->empleadoEstado = 1;
//         $empleado->save();
//         return redirect()->action('EmpleadoController@index');
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
//         $empleado = DB::table('empleado as e')
//                     ->join('persona as per','per.PersonaId','=','e.PersonaId')
//                     ->where('EmpleadoId',$id)
//                     ->first();
//         return view('empleados.edit',compact('empleado'));
//     }

//     /**
//      * Update the specified resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function update(CrearPersonaRequest $request, $id)
//     {
//         $empleado = Empleado::FindOrFail($id);
//         $datos = $request->all();
//         $persona = Persona :: FindOrFail($empleado->PersonaId);
//         $persona->PersonaNombre = $datos ['nombre'];
//         $persona->PersonaApellido = $datos ['apellido'];
//         $persona->PersonaCuil = $datos ['cuil'];
//         $persona->PersonaDireccion = $datos ['direccion'];
//         $persona->PersonaEmail = $datos['email'];
//         $persona->PersonaTelefono = $datos ['telefono'];
//         $persona->PersonaSexo = $datos ['sexo'];
//         $persona->Update();
//         return redirect()->action('EmpleadoController@index');
//     }

//     /**
//      * Remove the specified resource from storage.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function destroy($id)
//     {
//         $empleado = Empleado::FindOrFail($id);
//         $empleado->EmpleadoEstado = 0;
//         $empleado->update();
//         return redirect()->action('EmpleadoController@index');
//     }
// }
