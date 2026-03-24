<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionAlertaIa extends Model
{
    protected $table = 'configuracion_alertas_ia';

    protected $fillable = [
        'producto_id', 'dias_aviso_vencimiento',
        'umbral_score_critico', 'umbral_score_preventivo',
        'dias_sin_rotacion_alerta', 'activo', 'notas',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
