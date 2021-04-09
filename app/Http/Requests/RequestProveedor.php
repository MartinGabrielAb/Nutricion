<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestProveedor extends FormRequest
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
    public function rules()
    { 
        $metodo = $this->getMethod();
        if ( $metodo == 'POST') {
            return [
            'nombre' => 'required|max:100',
            'cuit' => 'required|max:15|unique:proveedor,ProveedorCuit',        
            'direccion' => 'required|min:5|max:100',        
            'telefono' => 'required|digits_between:5,12',        
            'email' => 'required|email',        
            ];
        //validacion para el update
        }
        if ($metodo == "PUT" || $metodo == "PATCH") {
            return [
            'nombre' => 'required|max:100',
            'cuit' => 'required|max:15|unique:proveedor,ProveedorCuit,'.$this->request->get('id').',ProveedorId',        
            'direccion' => 'required|min:5|max:100',        
            'telefono' => 'required|digits_between:5,12',        
            'email' => 'required|email',        
            ];
        }
        
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Nombre es requerido.',
            'nombre.max' => 'Nombre no debe sobrepasar 100 carac.',
            'cuit.required' => 'Cuit es requerido.',
            'cuit.max' => 'Cuit no debe sobrepasar 15 carac.',
            'cuit.unique' => 'Cuit existente.',
            'direccion.required' => 'Direccion es requerido.',
            'direccion.min' => 'Direccion debe ser de mas de 10 carac.',
            'direccion.max' => 'Direccion no debe sobrepasar los 100 carac.',
            'telefono.required' => 'Telefono es requerido.',
            
            'telefono.digits_between' => 'Telefono debe tener entre 5 y 12 digitos.',
            'email.required' => 'Email es requerido.',
            'email.email' => 'Email debe ser de la forma ejemplo@ejemplo.com.',
        ];
    }
}
