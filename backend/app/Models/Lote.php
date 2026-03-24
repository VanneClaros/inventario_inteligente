<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// AGREGADO: estos 2 use son necesarios para las relaciones nuevas
use App\Models\ScoreRiesgoLote;
use App\Models\AlertaInventario;

class Lote extends Model
{
    // Tu fillable actual — no se toca nada
    protected $fillable = [
        'producto_id',
        'numero_lote',
        'cantidad_inicial',
        'cantidad',
        'fecha_ingreso',
        'fecha_vencimiento',
    ];

    // Tu relación actual — no se toca nada
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // ──────────────────────────────────────────────────────────
    // RELACIONES NUEVAS PARA LA IA — se agregan abajo
    // ──────────────────────────────────────────────────────────

    /**
     * Todos los scores calculados para este lote.
     * Uso: $lote->scores
     * Ejemplo: $lote->scores->count() → cuántos cálculos tiene
     */
    public function scores()
    {
        return $this->hasMany(ScoreRiesgoLote::class, 'lote_id');
    }

    /**
     * El score MÁS RECIENTE de este lote.
     * Uso: $lote->ultimoScore
     * Ejemplo: $lote->ultimoScore->nivel_riesgo → 'critico'
     */
    public function ultimoScore()
    {
        return $this->hasOne(ScoreRiesgoLote::class, 'lote_id')
                    ->latestOfMany('calculado_en');
    }

    /**
     * Alertas ACTIVAS (no resueltas) de este lote.
     * Uso: $lote->alertas
     * Ejemplo: $lote->alertas->count() → cuántas alertas pendientes
     */
    public function alertas()
    {
        return $this->hasMany(AlertaInventario::class, 'lote_id')
                    ->where('resuelta', false);
    }
}