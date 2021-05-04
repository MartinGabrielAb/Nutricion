<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class AlimentoPorProveedorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    { 
        return [
            'alimentoId' => ['required','exists:alimento,AlimentoId'],
            'costo' => ['required','numeric'],
            'cantidad' => ['required','numeric'],
            'vencimiento' => ['required','date'],
            ];        
    }

    public function messages()
    {
        return [
            'alimentoId.required' => 'El ID del alimento es requerido.',
            'alimentoId.exists' => 'El alimento no existe',
            'costo.required' => 'El costo es requerido.',
            'costo.numeric' => 'El costo debe ser numérico.',
            'cantidad.required' => 'La cantidad es requerida.',
            'cantidad.numeric' => 'La cantidad debe ser numérica',
            'vencimiento.required' => 'El vencimiento es requerido.',
            'vencimiento.date' => 'El vencimiento debe ser una fecha.'
        ];
    }
}
