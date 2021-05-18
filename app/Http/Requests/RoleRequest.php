<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    { 
        
        $metodo = $this->getMethod();
        if ( $metodo == 'POST') {
            return [
                'nombre' => [
                    'required',
                    'max:64',
                    Rule::unique('roles','name'),
               
                ],
            ];
        //validacion para el update
        }
        if ($metodo == "PUT" || $metodo == "PATCH") {
            return  [
                'nombre' => [
                    'required',
                    'max:64',
                    Rule::unique('roles','name')
                        ->where(function ($query) use ($request) { 
                            return $query->where('id','!=',$request->id);
                        })
                ],
               
            ];
        }
        
    }

    public function messages()
    {
        return [
            //nombre
            'nombre.required' => 'Nombre es requerido.',
            'nombre.max' => 'Nombre no debe sobrepasar 64 caracteres.',
            'nombre.unique' => 'Ya existe un rol con ese nombre.',

        ];
    }
}
