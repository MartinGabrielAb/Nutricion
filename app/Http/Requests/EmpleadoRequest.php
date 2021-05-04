<?php

namespace App\Http\Requests;
use App\Empleado;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

class EmpleadoRequest extends FormRequest
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
                    Rule::unique('empleado','EmpleadoCuil')->where(function ($query) {
                        return $query->where('EmpleadoEstado', 1)->orwhere('EmpleadoEstado',0);
                    })
                ],
                'direccion' => [
                    'required',
                    'min:4',
                    'max:128',
                ],
                'email' => [
                    'required',
                    'email',
                    'max:64',
                ],
                'telefono' => [
                    'required',
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
                    Rule::unique('empleado','EmpleadoCuil')
                        ->where(function ($query) { 
                            return $query->where('EmpleadoEstado', 1)->orwhere('EmpleadoEstado',0);
                        })
                        ->where(function ($query) use ($request) { 
                            return $query->where('EmpleadoId','!=',$request->id);
                        })
                ],
                'direccion' => [
                    'required',
                    'min:4',
                    'max:128',
                ],
                'email' => [
                    'required',
                    'email',
                    'max:64',
                ],
                'telefono' => [
                    'required',
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
            'cuil.required' => 'CUIL es requerido.',
            'cuil.numeric' => 'CUIL debe contener sólo números sin puntos.',
            'cuil.digits_between' => 'CUIL debe estar entre los 7 y 15 dígitos.',
            'cuil.unique' => 'Ya existe un paciente con ese CUIL',
            //direccion
            'direccion.required' => 'Direccion es requerido.',
            'direccion.min' => 'Direccion debe sobrepasar 4 caracteres.',
            'direccion.max' => 'Direccion no debe sobrepasar 64 caracteres.',
            //email
            'email.required' => 'Email es requerido.',
            'email.email' => 'Email debe tener un formato de email válido (ejemplo@ejemplo).',
            'email.max' => 'Email no debe sobrepasar 64 caracteres.',
            //telefono
            'telefono.required' => 'Teléfono es requerido.',
            'telefono.min' => 'Teléfono debe sobrepasar 2 caracteres.',
            'telefono.max' => 'Teléfono no debe sobrepasar 64 caracteres.',
            //estado
            'estado.required' => 'Estado es requerido.',

        ];
    }
}
