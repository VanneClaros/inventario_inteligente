<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertaInventario extends Model
{
    protected $table = 'alertas_inventario';

    protected $fillable = [
        'tipo_alerta', 'nivel', 'entidad_tipo', 'entidad_id',
        'lote_id', 'producto_id', 'score_id',
        'mensaje', 'sugerencia', 'datos_extra',
        'leida', 'resuelta', 'leida_en', 'resuelta_en', 'resuelta_por',
    ];

    protected $casts = [
        'datos_extra' => 'array',
        'leida'       => 'boolean',
        'resuelta'    => 'boolean',
        'leida_en'    => 'datetime',
        'resuelta_en' => 'datetime',
    ];

    public function lote()    { return $this->belongsTo(Lote::class); }
    public function producto(){ return $this->belongsTo(Producto::class); }
    public function score()   { return $this->belongsTo(ScoreRiesgoLote::class, 'score_id'); }

    public function scopeNoResueltas($query)
    {
        return $query->where('resuelta', false);
    }

    public function scopeCriticas($query)
    {
        return $query->where('nivel', 'critico');
    }
}
