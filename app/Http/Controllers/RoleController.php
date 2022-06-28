<?php

namespace App\Http\Controllers;

use App\Rol;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RoleRequest;


class RoleController extends Controller
{
    public function index(Request $request)
    {

        if($request->ajax()){
            try{
                $roles = DB::table('roles')->get();
                return DataTables::of($roles)
                            ->addColumn('btn','roles/actions')
                            ->rawColumns(['btn'])
                            ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        return view('roles.principal');
    }


    public function create()
    {  }


    public function store(RoleRequest $data)
    {
        
        $rol = new Rol();
        $rol->name = $data['nombre'];
        $rol->guard_name = 'web';
        $rol->save();
        return response()->json(['success' => 'true']);
    }

    // Utilizo el show para ver los permisos
    public function show($id,Request $request)
    { 

        if($request->ajax()){
            try{
                $permisosPorRol = DB::table('role_has_permissions as r')
                        ->where('role_id',$id)
                        ->join('permissions as p','p.id','r.permission_id')
                        ->get();
                return DataTables::of($permisosPorRol)
                            ->addColumn('btn','permisos/actions')
                            ->rawColumns(['btn'])
                            ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        
        $rol = Rol::findOrFail($id);
        $permisos = DB::table('permissions')
                        ->orderBy('name','asc')                
                        ->get();
        return view('permisos.principal',compact('rol','permisos'));

    }

    public function edit($id)
    {   }

    public function update(RoleRequest $data, $id)
    {
        $rol = Rol::FindOrFail($id);
        $rol->name = $data['nombre'];
        $resultado = $rol->update();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
  
        
    }

    public function destroy($id)
    {
        $rol = Rol::FindOrFail($id);
        DB::table('role_has_permissions')
                ->where('role_id',$id)->delete();
        DB::table('model_has_roles')
                ->where('role_id',$id)->delete();
        $resultado = $rol->delete();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
