<?php

namespace App\Http\Requests;
use App\Persona;
use App\Paciente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RelevamientoRequest extends FormRequest
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
                'fecha' => [
                    'required',
                    'date',
                    Rule::unique('relevamiento','RelevamientoFecha')
                        ->where(function ($query) {
                            return $query->where('RelevamientoEstado', 1);
                        })
                ],
                'menu' => [
                    'required',
                ],
            ];
        }
        //validacion para el update
        if ($metodo == "PUT" || $metodo == "PATCH") {
            return  [
                'fecha' => [
                    'required',
                    'date',
                    Rule::unique('relevamiento','RelevamientoFecha')
                        ->where(function ($query) {
                            return $query->where('RelevamientoEstado', 1);
                        })
                        ->where(function ($query) use ($request) { 
                            return $query->where('RelevamientoId','!=',$request->id);
                        })
                ],
                'menu' => [
                    'required',
                ],
            ];
        }
    }

    public function messages()
    {
        return [
            //fecha
            'fecha.required' => 'Fecha es requerido.',
            'fecha.date' => 'Fecha debe tener formato de fecha.',
            'fecha.unique' => 'Ya existe un relevamiento con la fecha seleccionada.',
            //Menu
            'menu.required' => 'Menu es requerido.',
        ];
    }
}
