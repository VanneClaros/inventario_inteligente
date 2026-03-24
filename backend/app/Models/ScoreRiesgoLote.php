<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreRiesgoLote extends Model
{
    protected $table = 'scores_riesgo_lote';

    protected $fillable = [
        'lote_id', 'score_vencimiento', 'nivel_riesgo',
        'dias_para_vencer', 'unidades_restantes',
        'tasa_rotacion_diaria', 'unidades_proyectadas_vender',
        'unidades_en_riesgo', 'valor_en_riesgo',
        'sugerencia_accion', 'calculado_en',
    ];

    protected $casts = [
        'calculado_en' => 'datetime',
    ];

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    // Scope para obtener solo scores críticos
    public function scopeCriticos($query)
    {
        return $query->where('nivel_riesgo', 'critico');
    }

    // Scope para obtener el más reciente de cada lote
    public function scopeUltimos($query)
    {
        return $query->whereIn('id', function ($sub) {
            $sub->selectRaw('MAX(id)')
                ->from('scores_riesgo_lote')
                ->groupBy('lote_id');
        });
    }
}
