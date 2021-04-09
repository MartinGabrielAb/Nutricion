<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleRelevamiento extends Model
{
  protected $table = 'detallerelevamiento';
  protected $primaryKey = 'DetalleRelevamientoId';
  protected $filliable=['PacienteId','RelevamientoId','DetalleRelevamientoFechora',
  'TipoPacienteId','DetalleRelevamientoEstado','CamaId','DetalleRelevamientoObservaciones','DetalleRelevamientoDiagnostico','MenuId','DetalleRelevamientoAcompaniante','EmpleadoId'];

}