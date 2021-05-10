<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ComidaPorTipoPacienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    { 
        Validator::extend('comida_principal_unique', function () use ($request) {
            //si es una variante entonces la acepta
            if($request->get('principal') == 0){
                return 1;
            }
            //sino comprueba si ya existe una comida principal en este menu y tipo de paciente
            $query = DB::table('comidaportipopaciente')->join('comida', function ($join) use ($request) {
                $join->on('comidaportipopaciente.ComidaId', 'comida.ComidaId')
                    ->where('comida.TipoComidaId', $request->get('tipocomida'));
            })->where('comidaportipopaciente.DetalleMenuTipoPacienteId', $request->get('detalleMenuTipoPacienteId'))
              ->where('comidaportipopaciente.ComidaPorTipoPacientePrincipal', 1);
    
            // True means pass, false means fail validation.
            // If count is 0, that means the unique constraint passes.
            return !$query->count();
        });
        
        return [
            'detalleMenuTipoPacienteId' => ['required','exists:detallemenutipopaciente,DetalleMenuTipoPacienteId'],
            'comida' => [
                'required',                
                Rule::unique('comidaportipopaciente','ComidaId')
                    ->where(function ($query) use($request) {
                        return $query->where('DetalleMenuTipoPacienteId', $request->get('detalleMenuTipoPacienteId'));
                    }),
                'comida_principal_unique',
            ],
            'principal' => ['required'],
        ];
        
    }

    public function messages()
    {
        return [
            'comida.required' => 'Debe seleccionar una comida.',
            'comida.unique' => 'Ya existe esta comida en este menú.',
            'comida.comida_principal_unique' => 'Ya existe una comida principal para este tipo de comida.',            
            'principal.required' => 'Debe seleccionar si es principal o variante.',
        ];
    }
}
