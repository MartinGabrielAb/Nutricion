<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use App\Menu;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB as FacadesDB;

class ComidaPorTipoPacienteRequest extends FormRequest
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
