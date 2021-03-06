<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalaRequest extends FormRequest
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
                'salaNombre' => [
                    'required',
                    'max:64',
                    Rule::unique('sala','SalaNombre')->where(function ($query) { 
                        return $query->where('SalaEstado', 1);
                    })
                ],
                'pseudonimo' => [
                    'required',
                    'max:64',
                    Rule::unique('sala','SalaPseudonimo')->where(function ($query) { 
                        return $query->where('SalaEstado', 1);
                    })
                ],
            ];
        //validacion para el update
        }
        if ($metodo == "PUT" || $metodo == "PATCH") {
            return  [
                'salaNombre' => [
                    'required',
                    'max:64',
                    Rule::unique('sala','SalaNombre')
                        ->where(function ($query) use ($request) { 
                            return $query->where('SalaId','!=',$request->id);
                        })
                        ->where(function ($query) { 
                            return $query->where('SalaEstado', 1);
                        })
                ],
                'pseudonimo' => [
                    'required',
                    'max:64',
                    Rule::unique('sala','SalaPseudonimo')
                        ->where(function ($query) use ($request) { 
                            return $query->where('SalaId','!=',$request->id);
                        })
                        ->where(function ($query) { 
                            return $query->where('SalaEstado', 1);
                        })
                ],  
            ];
        }
        
    }

    public function messages()
    {
        return [
            //nombre
            'salaNombre.required' => 'Nombre es requerido.',
            'salaNombre.max' => 'Nombre no debe sobrepasar 64 caracteres.',
            'salaNombre.unique' => 'Ya existe una sala con ese nombre.',
            //pseudonimo
            'pseudonimo.required' => 'Pseud??nimo es requerido.',
            'pseudonimo.max' => 'Pseud??nimo no debe sobrepasar 64 caracteres.',
            'pseudonimo.unique' => 'Ya existe una sala con ese pseud??nimo.',
        ];
    }
}
