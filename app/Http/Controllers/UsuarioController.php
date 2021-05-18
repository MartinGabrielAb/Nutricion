<?php

namespace App\Http\Controllers;

use App\Rol;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UsuarioRequest;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            try{
                $usuarios = DB::table('users');
                return DataTables::of($usuarios)
                    
                            ->addColumn('roles',function($usuario){
                                $roles = DB::table('model_has_roles')
                                                ->where('model_id',$usuario->id)
                                                ->where('model_type','App\User')
                                                ->join('roles','roles.id','model_has_roles.role_id')
                                                ->get();
                                $respuesta = "";
                                foreach ($roles as $rol){
                                    $respuesta = $respuesta.$rol->name.", ";
                                }
                            return (substr($respuesta,0,-2));
                            })
                            ->addColumn('btn','usuarios/actions')
                            ->rawColumns(['roles','btn'])
                            ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        $roles = Rol::All();
        return view('usuarios.principal',compact('roles'));
    }


    public function create()
    {  }


    public function store(UsuarioRequest $data)
    {
        User::create([
            'name' => $data['nombre'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
         ])->assignRole($data['roles']);
        // $usuario = new User();
        // $usuario->name = $data['nombre'];
        // $usuario->email =  $data['email'];
        // $usuario->password = bcrypt($data['password']);
        // $usuario->save();
        // foreach ($data['roles'] as $rol){
        //     DB::table('model_has_roles')->insert(
        //         [
        //             'role_id' => $rol,
        //             'model_type' => 'App\User',
        //             'model_id' =>$usuario->id,    
        //         ]
        //     );
            

        // }
        return response()->json(['success' => 'true']);
    }

    public function show($id)
    {  }

    public function edit($id)
    {   }

    public function update(UsuarioRequest $data, $id)
    {
        // $usuario = User::FindOrFail($id);
        // $usuario->name = $data['nombre'];
        // $usuario->email =  $data['email'];
        try{
            $roles = Rol::All();
            $resultado = User::where('id',$id)
            ->update([
                'name' => $data['nombre'],
                'email' => $data['email'],
             ]);
             foreach ($roles as $rol ) {
                User::where('id',$id)->first()
                ->removeRole($rol->id);
             }
             User::where('id',$id)->first()
             ->assignRole($data['roles']);

            if ($resultado) {
                return response()->json(['success'=>'true']);
            }else{
                return response()->json(['success'=>'false']);
            }
        }catch(Exception $ex){
            return response()->json([
                'error' => $ex->getMessage()
            ], 500);
        }
        
    }

    public function destroy($id)
    {
        $usuario = User::FindOrFail($id);
        DB::table('model_has_roles')
                ->where('model_id',$id)->delete();
        $resultado = $usuario->delete();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
