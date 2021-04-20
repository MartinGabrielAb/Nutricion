<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use App\Pieza;
use App\Sala;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB as FacadesDB;

class PiezaRequest extends FormRequest
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
            'salaId' => 'required | numeric | exists:sala,SalaId',
            'piezaNombre' => [
                'required',
                'min:4',
                'max:64',
                Rule::unique('pieza','PiezaNombre')
                    ->where(function ($query) use ($request) { 
                        return $query->where('SalaId',$request->salaId);
                    })    
                    ->where(function ($query) { 
                        return $query->where('PiezaEstado', 1);
                    })
                    
                ]      
            ];
        //validacion para el update
        }
        if ($metodo == "PUT" || $metodo == "PATCH") {
            return  [
            'piezaNombre' => ['required','min:4','max:64',
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
            ];
        }
        
    }

    public function messages()
    {
        return [
            'salaId.required'  => 'El ID de la sala es requerido.',
            'salaId.exists'  => 'El ID de la sala es debe existir.',
            'salaId.numeric'  => 'El ID de la sala debe ser numérico.',
            'piezaNombre.required' => 'Nombre es requerido.',
            'piezaNombre.min' => 'Nombre debe sobrepasar los 4 caractéres.',
            'piezaNombre.max' => 'Nombre no debe sobrepasar 64 caractéres.',
            'piezaNombre.unique' => 'Ya existe una pieza con ese nombre en esta sala.'
        ];
    }
}
