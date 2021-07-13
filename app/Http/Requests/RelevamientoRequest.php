<?php

namespace App\Http\Requests;
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
                // 'salaId' => [
                //     'required'
                // ],
                'fecha' => [
                    'required',
                    'date',
                    Rule::unique('relevamiento','RelevamientoFecha')
                        ->where(function ($query) use($request) {
                        //     return $query->where('SalaId', $request->get('salaId'))
                        //                  ->where('RelevamientoFecha', $request->get('fecha'))
                        //                  ->where('RelevamientoTurno', $request->get('turno'))
                            return $query->where('RelevamientoEstado', 1)
                                         ->where('RelevamientoFecha', $request->get('fecha'))
                                         ->where('RelevamientoTurno', $request->get('turno'));
                        }),
                ],
                'turno' => [
                    'required'
                ],
            ];
        }
        //validacion para el update
        if ($metodo == "PUT" || $metodo == "PATCH") {
            return  [
                // 'salaId' => [
                //     'required'
                // ],
                'fecha' => [
                    'required',
                    'date',
                    Rule::unique('relevamiento','RelevamientoFecha')
                        ->where(function ($query) use($request) {
                            return $query->where('RelevamientoId','!=',$request->id)
                                        //  ->where('SalaId', $request->get('salaId'))
                                         ->where('RelevamientoFecha', $request->get('fecha'))
                                         ->where('RelevamientoTurno', $request->get('turno'))
                                         ->where('RelevamientoEstado', 1);
                        }),
                ],
                'turno' => [
                    'required'
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
            'fecha.unique' => 'Ya existe relevamiento.',
            //turno
            'turno.required' => 'Turno es requerido.',
        ];
    }
}
