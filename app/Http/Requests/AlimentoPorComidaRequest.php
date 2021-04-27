<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use App\AlimentoPorComida;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use DB;

class AlimentoPorComidaRequest extends FormRequest
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
