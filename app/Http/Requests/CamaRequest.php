<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CamaRequest extends FormRequest
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
            'piezaId' => 'required | numeric | exists:pieza,PiezaId',
            'camaNumero' => ['required','numeric',
                Rule::unique('cama','CamaNumero')
                    ->where(function ($query) use ($request) { 
                        return $query->where('PiezaId',$request->piezaId);
                    })                       
                ]      
            ];
        }
    }

    public function messages()
    {
        return [
            'piezaId.required'  => 'El ID de la pieza es requerido.',
            'piezaId.exists'  => 'El ID de la pieza es debe existir.',
            'piezaId.numeric'  => 'El ID de la pieza debe ser numérico.',
            'camaNumero.required' => 'Número es requerido.',
            'camaNumero.numeric' => 'El campo número debe ser un numero del 1 al 99',
            'camaNumero.unique' => 'Ya existe una cama con ese número en esta pieza.'
        ];
    }
}
