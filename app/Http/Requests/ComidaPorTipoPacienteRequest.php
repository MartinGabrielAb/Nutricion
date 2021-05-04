<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComidaPorTipoPacienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    { 
        
            return [
            'detalleMenuTipoPacienteId' => ['required','exists:detallemenutipopaciente,DetalleMenuTipoPacienteId'],
            'comida' => ['required',Rule::unique('comidaportipopaciente','ComidaId')
            ->where(function ($query) use ($request) { 
                return $query->where('DetalleMenuTipoPacienteId',$request->detalleMenuTipoPacienteId);
                })
                ]      
            ];
        
    }

    public function messages()
    {
        return [
            'comida.required' => 'Debe seleccionar una comida.',
            'comida.unique' => 'Ya existe esta comida en este menú.',
        ];
    }
}
