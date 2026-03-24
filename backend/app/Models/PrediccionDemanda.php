<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrediccionDemanda extends Model
{
    protected $table = 'predicciones_demanda';

    protected $fillable = [
        'producto_id', 'modelo_ia_id', 'periodo_inicio', 'periodo_fin',
        'granularidad', 'cantidad_predicha', 'cantidad_minima',
        'cantidad_maxima', 'confianza_pct', 'fuente',
        'datos_entrada', 'cantidad_real', 'error_porcentual',
    ];

    protected $casts = [
        'datos_entrada' => 'array',
        'periodo_inicio'=> 'date',
        'periodo_fin'   => 'date',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
