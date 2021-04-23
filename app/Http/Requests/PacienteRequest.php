<?php

namespace App\Http\Requests;
use App\Persona;
use App\Paciente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PacienteRequest extends FormRequest
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
        $metodo = $this->getMethod();
        if ( $metodo == 'POST') {
            return [
                'estado' => [
                    'required',
                    'numeric',
                    'digits_between:0,1',
                ],
                'personaId' => [
                    'required',
                    'numeric',
                    Rule::unique('paciente','PersonaId')->where(function ($query) { 
                        return $query->where('PacienteEstado',1)->orwhere('PacienteEstado',0);
                    })
                ],
            ];
        //validacion para el update
        }
        if ($metodo == "PUT" || $metodo == "PATCH") {
            return  [
                'estado' => [
                    'required',
                    'numeric',
                    'digits_between:0,1',
                ],
                'personaId' => [
                    'required',
                    'numeric',
                    Rule::unique('paciente','PersonaId')
                        ->where(function ($query) { 
                            return $query->where('PacienteEstado',1)->orwhere('PacienteEstado',0);
                        })
                        ->where(function ($query) use ($request) { 
                            return $query->where('PersonaId','!=',$request->personaId);
                        })
                ],
            ];
        }
    }

    public function messages()
    {
        return [
            //estado
            'estado.required' => 'Estado es requerido.',
            'estado.numeric' => 'Estado debe ser activo o inactivo.',
            'dni.digits_between' => 'Estado debe estar entre los 0 y 1 dígitos.',
            //personaId
            'personaId.required' => 'PersonaId es requerido. Por favor contacte al soporte técnico.',
            'personaId.max' => 'PersonaId debe ser numérico. Por favor contacte al soporte técnico.',
            'personaId.unique' => 'Es paciente que está queriendo agregar ya existe.',
        ];
    }
}
