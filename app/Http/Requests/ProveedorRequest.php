<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
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
                'nombre' => [
                    'required',
                    'min:4',
                    'max:64',
                ],
                'cuit' => [
                    'required',
                    'numeric',
                    'digits_between:7,15',
                    Rule::unique('proveedor','ProveedorCuit')->where(function ($query) {
                        return $query->where('ProveedorEstado', 1)->orwhere('ProveedorEstado',0);
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
                'nombre' => [
                    'required',
                    'min:2',
                    'max:64',
                ],
                'cuit' => [
                    'required',
                    'numeric',
                    'digits_between:7,15',
                    Rule::unique('proveedor','ProveedorCuit')
                        ->where(function ($query) { 
                            return $query->where('ProveedorEstado', 1)->orwhere('ProveedorEstado', 0);
                        })
                        ->where(function ($query) use ($request) { 
                            return $query->where('ProveedorId','!=',$request->id);
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

            //nombre
            'nombre.required' => 'Nombre es requerido.',
            'nombre.min' => 'Nombre debe sobrepasar 2 caracteres.',
            'nombre.max' => 'Nombre no debe sobrepasar 64 caracteres.',
            //DNI
            'cuit.required' => 'Cuit es requerido.',
            'cuit.numeric' => 'Cuit debe contener sólo números sin puntos.',
            'cuit.digits_between' => 'Cuit debe estar entre los 7 y 15 dígitos.',
            'cuit.unique' => 'Ya existe un paciente con ese cuit',
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
