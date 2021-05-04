<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuPorTipoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    { 
        
            return [
                'menuId' => ['required','exists:menu,MenuId'],
                'tipoPaciente' => 
                    ['required',
                    Rule::unique('detalleMenuTipoPaciente','TipoPacienteId')
                        ->where(function ($query) use($request) {
                            return $query->where('MenuId', $request->menuId)->where('TipoPacienteId', $request->tipoPaciente);
                        }),
                    ]      
            ];
        
    }

    public function messages()
    {
        return [
            'menuId.required' => 'Menu requerido.',
            'tipoPaciente.required' => 'Debe seleccionar un tipo.',
            'tipoPaciente.unique' => 'Ya existe ese tipo de paciente en este menú.',
        ];
    }
}
