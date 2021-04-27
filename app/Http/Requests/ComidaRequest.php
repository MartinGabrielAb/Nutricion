<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use App\Comida;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB as FacadesDB;

class ComidaRequest extends FormRequest
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
            'nombre' => ['required','min:4','max:64',
                Rule::unique('comida','ComidaNombre')->where(function ($query) { 
                    return $query->where('ComidaEstado', 1);
                    })
                ],
            'tipo' => ['required','numeric','exists:tipocomida,TipoComidaId']    
            ];
        //validacion para el update
        }
        if ($metodo == "PUT" || $metodo == "PATCH") {
            return  [
            'nombre' => ['required','min:4','max:64',
                Rule::unique('comida','ComidaNombre')
                    ->where(function ($query) use ($request) { 
                        return $query->where('ComidaId','!=',$request->id);
                        })
                    ->where(function ($query) { 
                        return $query->where('ComidaEstado', 1);
                        })
                    ],
            'tipo' => ['required','numeric','exists:tipocomida,TipoComidaId']       
            ];
        }
        
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Nombre es requerido.',
            'nombre.min' => 'Nombre debe pasar los 4 caractéres.',
            'nombre.max' => 'Nombre no debe sobrepasar 64 caractéres.',
            'nombre.unique' => 'Ya existe una comida con ese nombre.',
            'tipo.required' => 'Tipo de comida es requerido.',
            'tipo.numeric' => 'El tipo de comida debe ser un número.',
            'tipo.exists' => 'El tipo de comida debe existir.',

        ];
    }
}
