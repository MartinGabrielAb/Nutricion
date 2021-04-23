<?php

namespace App\Http\Requests;
use App\Persona;
use App\Paciente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PersonaRequest extends FormRequest
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
                    'min:4',
                    'max:64',
                ],
                'nombre' => [
                    'required',
                    'min:4',
                    'max:64',
                ],
                'dni' => [
                    'required',
                    'numeric',
                    'digits_between:7,15',
                    Rule::unique('persona as pe','pe.PersonaCuil')->where(function ($query) use ($request) {
                        $persona = Persona::where('PersonaCuil',$request->dni)->first();
                        if($persona){
                            $paciente = Paciente::where('PersonaId',$persona->PersonaId)->first();
                            if($paciente){
                                return $query->where('pe.PersonaEstado',1)->where('pe.PersonaId','!=',$persona->PersonaId);
                            }
                        }
                        return $query->where('pe.PersonaEstado', 1);
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
            ];
        //validacion para el update
        }
        if ($metodo == "PUT" || $metodo == "PATCH") {
            $paciente = Paciente::findOrFail($request->id);
            $persona = Persona::findOrFail($paciente->PersonaId);
            return  [
                'apellido' => [
                    'required',
                    'min:4',
                    'max:64',
                ],
                'nombre' => [
                    'required',
                    'min:4',
                    'max:64',
                ],
                'dni' => [
                    'required',
                    'numeric',
                    'digits_between:7,15',
                    Rule::unique('persona','PersonaCuil')
                        ->where(function ($query) { 
                            return $query->where('PersonaEstado', 1);
                        })
                        ->where(function ($query) use ($persona) { 
                            return $query->where('PersonaId','!=',$persona->PersonaId);
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
            ];
        }
    }

    public function messages()
    {
        return [
            //apellido
            'apellido.required' => 'Apellido es requerido.',
            'apellido.max' => 'Apellido no debe sobrepasar 64 caracteres.',
            //nombre
            'nombre.required' => 'Nombre es requerido.',
            'nombre.max' => 'Nombre no debe sobrepasar 64 caracteres.',
            //DNI
            'dni.required' => 'DNI es requerido.',
            'dni.numeric' => 'DNI debe contener sólo números sin puntos.',
            'dni.digits_between' => 'DNI debe estar entre los 7 y 15 dígitos.',
            'dni.unique' => 'Ya existe un paciente con ese DNI. Si se da el caso de dos personas con el mismo DNI, use CUIL de la segunda persona.',
            //direccion
            'direccion.max' => 'Dirección no debe sobrepasar 128 caracteres.',
            //email
            'email.email' => 'Email debe tener un formato de email válido (ejemplo@ejemplo).',
            'email.max' => 'Email no debe sobrepasar 64 caracteres.',
            //telefono
            'telefono.required' => 'Teléfono es requerido.',
            'telefono.max' => 'Teléfono no debe sobrepasar 64 caracteres.',
        ];
    }
}
