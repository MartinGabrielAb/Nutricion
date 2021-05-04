<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlimentoPorComidaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    { 
        return [
        'alimentoId' => ['required',
                Rule::unique('alimentoporcomida','AlimentoId')->where(function ($query) use ($request) { 
                return $query->where('ComidaId', $request->comidaId);
                })
            ],
        'cantidadNeto' => ['required','numeric'], 
    ];
    }

    public function messages()
    {
        return [
            'alimentoId.required' => 'Alimento requerido.',
            'alimentoId.unique' => 'Ya existe ese alimento en esta comida',
            'cantidadNeto.required' => 'Cantidad requerida.',
            'cantidadNeto.numeric' => 'Cantidad debe ser un número positivo.',
        ];
    }
}
