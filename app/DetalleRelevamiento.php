<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleRelevamiento extends Model
{
  protected $table = 'detallerelevamiento';
  protected $primaryKey = 'DetalleRelevamientoId';
  protected $filliable=[
    'PacienteId',
    'RelevamientoPorSalaId',
    'created_at',
    'updated_at',
    'UserId',
    'TipoPacienteId',
    'DetalleRelevamientoEstado',
    'CamaId',
    'DetalleRelevamientoObservaciones',
    'DetalleRelevamientoDiagnostico',
    'MenuId',
    'DetalleRelevamientoAcompaniante',
    'DetalleRelevamientoVajillaDescartable',
    'DetalleRelevamientoAgregado',
    'DetalleRelevamientoColacion',
  ];

}