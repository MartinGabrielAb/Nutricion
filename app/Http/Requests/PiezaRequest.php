<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PiezaRequest extends FormRequest
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
                'salaId' => 'required | numeric | exists:sala,SalaId',
                'piezaNombre' => [
                    'required',
                    'max:64',
                    Rule::unique('pieza','PiezaNombre')
                        ->where(function ($query) use ($request) { 
                            return $query->where('SalaId',$request->salaId);
                        })    
                        ->where(function ($query) { 
                            return $query->where('PiezaEstado', 1);
                        })
                        
                    ],
                'pseudonimo' => [
                    'required',
                    'max:64',
                    Rule::unique('pieza','PiezaPseudonimo')
                        ->where(function ($query) use ($request) { 
                            return $query->where('SalaId',$request->salaId);
                        }) 
                        ->where(function ($query) {
                            return $query->where('PiezaEstado', 1);
                        })
                ],
            ];
        //validacion para el update
        }
        if ($metodo == "PUT" || $metodo == "PATCH") {
            return  [
                'piezaNombre' => ['required','max:64',
                    Rule::unique('pieza','PiezaNombre')
                        ->where(function ($query) use ($request) { 
                            return $query->where('PiezaId','!=',$request->id);
                        })
                        ->where(function ($query) use ($request) { 
                            return $query->where('SalaId',$request->salaId);
                        })
                        ->where(function ($query) { 
                            return $query->where('PiezaEstado', 1);
                            })
                        ],
                'pseudonimo' => [
                    'required',
                    'max:64',
                    Rule::unique('pieza','PiezaPseudonimo')
                        ->where(function ($query) use ($request) { 
                            return $query->where('PiezaId','!=',$request->id);
                        })
                        ->where(function ($query) use ($request) { 
                            return $query->where('SalaId',$request->salaId);
                        })
                        ->where(function ($query) { 
                            return $query->where('PiezaEstado', 1);
                        })
                ],
            ];
        }
        
    }

    public function messages()
    {
        return [
            //sala
            'salaId.required'  => 'El ID de la sala es requerido.',
            'salaId.exists'  => 'El ID de la sala es debe existir.',
            'salaId.numeric'  => 'El ID de la sala debe ser num??rico.',
            //pieza
            'piezaNombre.required' => 'Nombre es requerido.',
            'piezaNombre.max' => 'Nombre no debe sobrepasar 64 caracteres.',
            'piezaNombre.unique' => 'Ya existe una pieza con ese nombre en esta sala.',
            //pseudonimo
            'pseudonimo.required' => 'Pseud??nimo es requerido.',
            'pseudonimo.max' => 'Pseud??nimo no debe sobrepasar 64 caracteres.',
            'pseudonimo.unique' => 'Ya existe una pieza con ese pseud??nimo.',
        ];
    }
}
