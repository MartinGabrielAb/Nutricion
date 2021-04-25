<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use App\Alimento;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use DB;

class AlimentoRequest extends FormRequest
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
        'nombre' => ['required','min:2','max:64',
            Rule::unique('alimento','AlimentoNombre')->where(function ($query) { 
                return $query->where('AlimentoEstado', 1);
                })
            ],
        'unidad' => ['required','exists:unidadmedida,UnidadMedidaId'], 
        'equivalente' => ['bail',Rule::requiredIf(function () use ($request) {
                $unidadMedida = DB::table('unidadmedida')
                ->where('UnidadMedidaId',$request->unidad)                
                ->first();
            if($unidadMedida->UnidadMedidaNombre == "Litro") return true;
            return false;
        })],  
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
            'equivalente.required' => 'Debe ingresar la equivalencia',
        ];
    }
}
