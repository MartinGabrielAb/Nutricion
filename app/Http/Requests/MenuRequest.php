<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
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
            'menuNombre' => [
                'required',
                'min:4',
                'max:64',
                Rule::unique('menu','MenuNombre')->where(function ($query) { 
                    return $query->where('MenuEstado', 1);
                    })
                ]      
            ];
        //validacion para el update
        }
        if ($metodo == "PUT" || $metodo == "PATCH") {
            return  [
            'menuNombre' => [
                'required',
                'min:4',
                'max:64',
                Rule::unique('menu','MenuNombre')
                    ->where(function ($query) use ($request) { 
                        return $query->where('MenuId','!=',$request->id);
                        })
                    ->where(function ($query) { 
                        return $query->where('MenuEstado', 1);
                        })
                ]   
            ];
        }
        
    }

    public function messages()
    {
        return [
            'menuNombre.required' => 'Nombre es requerido.',
            'menuNombre.min' => 'Nombre debe pasar los 4 caractéres.',
            'menuNombre.max' => 'Nombre no debe sobrepasar 64 caractéres.',
            'menuNombre.unique' => 'Ya existe un con  menú ese nombre.'
        ];
    }
}
