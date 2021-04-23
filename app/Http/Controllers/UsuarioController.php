<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Rol;
use App\Http\Requests\UsuarioRequest;
use DB;
use Illuminate\Support\Facades\Hash;
USE App\RolesUsuario;
use Yajra\DataTables\DataTables;

class UsuarioController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            try{
                $usuarios = DB::table('users')->get();
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
                    'error' => 'Internal server error.'
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
        
        $usuario = new User();
        $usuario->name = $data['nombre'];
        $usuario->email =  $data['email'];
        $usuario->password = bcrypt($data['password']);
        $usuario->save();
        foreach ($data['roles'] as $rol){
            DB::table('model_has_roles')->insert(
                [
                    'role_id' => $rol,
                    'model_type' => 'App\User',
                    'model_id' =>$usuario->id,    
                ]
            );
        }
        return response()->json(['success' => 'true']);
    }

    public function show($id)
    {  }

    public function edit($id)
    {    }

    public function update(UsuarioRequest $data, $id)
    {
        $usuario = User::FindOrFail($id);
        $usuario->name = $data['nombre'];
        $usuario->email =  $data['email'];
        try{
            DB::table('model_has_roles')
                ->where('model_id',$id)->delete();
            foreach ($data['roles'] as $rol){
                DB::table('model_has_roles')->insert(
                    [
                        'role_id' => $rol,
                        'model_type' => 'App\User',
                        'model_id' =>$id,    
                    ]
                );
            }
            $resultado = $usuario->update();
            if ($resultado) {
                return response()->json(['success'=>'true']);
            }else{
                return response()->json(['success'=>'false']);
            }
        }catch(Exception $ex){
            return response()->json(['success'=>'false']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
