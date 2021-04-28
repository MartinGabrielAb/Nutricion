<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use App\Sala;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB as FacadesDB;

class SalaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
            'pseudonimo.required' => 'Pseudónimo es requerido.',
            'pseudonimo.max' => 'Pseudónimo no debe sobrepasar 64 caracteres.',
            'pseudonimo.unique' => 'Ya existe una sala con ese pseudónimo.',
        ];
    }
}
