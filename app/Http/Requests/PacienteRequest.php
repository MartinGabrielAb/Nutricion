<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PacienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {
        $metodo = $this->getMethod();
        if ( $metodo == 'POST') {
            return [
                'apellido' => [
                    'required',
                    'min:2',
                    'max:64',
                ],
                'nombre' => [
                    'required',
                    'min:2',
                    'max:64',
                ],
                'cuil' => [
                    'required',
                    'numeric',
                    'digits_between:7,15',
                    Rule::unique('paciente','PacienteCuil')->where(function ($query) {
                        return $query->where('PacienteEstado', 1)->orwhere('PacienteEstado',0);
                    })
                ],
                'direccion' => [
                    'nullable',
                    'min:4',
                    'max:128',
                ],
                'email' => [
                    'nullable',
                    'email',
                    'max:64',
                ],
                'telefono' => [
                    'nullable',
                    'min:4',
                    'max:64',
                ],
                'estado' => [
                    'required',
                    'numeric'
                ],
            ];
        //validacion para el update
        }
        if ($metodo == "PUT" || $metodo == "PATCH") {
            return  [
                'apellido' => [
                    'required',
                    'min:2',
                    'max:64',
                ],
                'nombre' => [
                    'required',
                    'min:2',
                    'max:64',
                ],
                'cuil' => [
                    'required',
                    'numeric',
                    'digits_between:7,15',
                    Rule::unique('paciente','PacienteCuil')
                        ->where(function ($query) { 
                            return $query->where('PacienteEstado', 1)->orwhere('PacienteEstado',0);
                        })
                        ->where(function ($query) use ($request) { 
                            return $query->where('PacienteId','!=',$request->id);
                        })
                ],
                'direccion' => [
                    'nullable',
                    'min:4',
                    'max:128',
                ],
                'email' => [
                    'nullable',
                    'email',
                    'max:64',
                ],
                'telefono' => [
                    'nullable',
                    'min:4',
                    'max:64',
                ],
                'estado' => [
                    'required',
                    'numeric'
                ],
            ];
        }
    }

    public function messages()
    {
        return [
            //apellido
            'apellido.required' => 'Apellido es requerido.',
            'apellido.min' => 'Apellido debe sobrepasar 2 caracteres.',
            'apellido.max' => 'Apellido no debe sobrepasar 64 caracteres.',
            //nombre
            'nombre.required' => 'Nombre es requerido.',
            'nombre.min' => 'Nombre debe sobrepasar 2 caracteres.',
            'nombre.max' => 'Nombre no debe sobrepasar 64 caracteres.',
            //DNI
            'cuil.numeric' => 'CUIL debe contener s??lo n??meros sin puntos.',
            'cuil.digits_between' => 'CUIL debe estar entre los 7 y 15 d??gitos.',
            'cuil.unique' => 'Ya existe un paciente con ese CUIL',
            //direccion
            'direccion.required' => 'Direccion es requerido.',
            'direccion.min' => 'Direccion debe sobrepasar 4 caracteres.',
            'direccion.max' => 'Direccion no debe sobrepasar 64 caracteres.',
            //email
            'email.email' => 'Email debe tener un formato de email v??lido (ejemplo@ejemplo).',
            'email.max' => 'Email no debe sobrepasar 64 caracteres.',
            //telefono
            'telefono.min' => 'Tel??fono debe sobrepasar 2 caracteres.',
            'telefono.max' => 'Tel??fono no debe sobrepasar 64 caracteres.',
            //estado
            'estado.required' => 'Estado es requerido.',

        ];
    }
}
