<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class AlimentoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    { 
        return [
        'nombre' => ['required','min:2','max:64',
            Rule::unique('alimento','AlimentoNombre')->where(function ($query) { 
                return $query->where('AlimentoEstado', 1);
                })
            ],
        'unidad' => ['required','exists:unidadmedida,UnidadMedidaId'], 
    ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Nombre es requerido.',
            'nombre.min' => 'Nombre debe pasar los 4 caractéres.',
            'nombre.max' => 'Nombre no debe sobrepasar 64 caractéres.',
            'nombre.unique' => 'Ya existe un alimento con ese nombre.',
            'unidad.required' => 'Unidad de medida requerida.',
            'nombre.exists' => 'Unidad de medida inexistente.',
        ];
    }
}
