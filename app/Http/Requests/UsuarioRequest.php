<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use App\Usuario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use DB;

class UsuarioRequest extends FormRequest
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
            'nombre' => ['required','min:4','max:64'],
            'email' => ['required','email', Rule::unique('users','email')],
            'password' => ['required','min:4','max:32'],
            'confirmacion' => ['required','same:password'],
            'roles'  =>   ['required']    
            ];
        //validacion para el update
        }
        if ($metodo == "PUT" || $metodo == "PATCH") {
            return  [
                'nombre' => ['required','min:4','max:64'],
                'email' => ['required','email', 
                            Rule::unique('users','email')
                                ->where(function ($query) use ($request) { 
                                return $query->where('id','!=',$request->id);
                                })
                            ],
                'roles'  =>   ['required']  
            ];
        }
        
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Nombre es requerido.',
            'nombre.min' => 'Nombre debe pasar los 4 caractéres.',
            'nombre.max' => 'Nombre no debe sobrepasar 64 caractéres',
            'email.unique' => 'Ese mail ya existe.',
            'email.required' => 'El email es requerido.',
            'email.email' => 'El email debe ser de la forma ejemplo@ejemplo.com.',
            'password.required' => 'El password es requerido.',
            'password.min' => 'El password debe ser de más de 4 caractéres.',
            'password.max' => 'El password no debe pasar los 32 caractéres.',
            'password.password' => 'El password es invalido.',
            'confirmacion.required' => 'Debe confirmar el password.',
            'confirmacion.same' => 'Los password deben coincidir.',
            'roles.required' => 'Debe seleccionar por lo menos un rol.'

        ];
    }
}
