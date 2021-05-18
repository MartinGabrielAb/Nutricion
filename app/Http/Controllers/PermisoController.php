<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Exception;
use Yajra\DataTables\DataTables;
use App\Http\Requests\PiezaRequest;
use App\Permiso;

class PermisoController extends Controller
{
    public function index()
    { }

    public function create()
    { }

    public function store(Request $request)
    {
        $idRol = $request['rol'];
        $permisos = $request['permisos'];
        foreach ($permisos as $permiso ) {
            $existe = DB::table('role_has_permissions')
            ->where('role_id',$idRol)
            ->where('permission_id',$permiso)                
            ->first();
            if(!$existe){
                $resultado = DB::table('role_has_permissions')->insert(
                    [
                        'role_id' => $idRol,
                        'permission_id' => $permiso,
                    ]
                );
            }
        }
        if ($resultado) {
            return response()->json(['success' => 'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show(Request $request,$id)
    {
    }


    public function edit($id)
    { }

    public function update(Request $request, $id)
    {    }

    public function destroy(Request $request, $id)
    {
        $idRol = $request['rol'];
        $resultado = DB::table('role_has_permissions')
            ->where('role_id',$idRol)
            ->where('permission_id',$id)                
            ->delete();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
