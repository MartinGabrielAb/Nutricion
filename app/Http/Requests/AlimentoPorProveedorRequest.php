<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use DB;

class AlimentoPorProveedorRequest extends FormRequest
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
