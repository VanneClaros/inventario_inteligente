<?php

namespace App\Services;

use App\Models\Lote;
use App\Models\Producto;
use App\Models\AlertaInventario;
use App\Models\ScoreRiesgoLote;
use App\Models\ConfiguracionAlertaIa;
use Carbon\Carbon;

class AlertaInventarioService
{
    /**
     * Genera alertas a partir de los scores calculados.
     * Lo llama el cron DESPUÉS de ScoreRiesgoService.
     */
    public function generarDesdeScores(): void
    {
        $config = $this->getConfig();

        // Tomar el score más reciente de cada lote
        $scores = ScoreRiesgoLote::with(['lote.producto'])
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                      ->from('scores_riesgo_lote')
                      ->groupBy('lote_id');
            })
            ->where('score_vencimiento', '>=', $config->umbral_score_preventivo)
            ->get();

        foreach ($scores as $score) {
            $this->crearAlertaVencimiento($score, $config);
        }
    }

    /**
     * Verifica stock mínimo después de una venta.
     * Lo llama VentaController@store().
     */
    public function verificarStockMinimo($detalles): void
    {
        foreach ($detalles as $detalle) {
            $producto = Producto::find($detalle->producto_id);
            if (!$producto) continue;

            if ($producto->stock <= 0) {
                $this->crearOActualizar([
                    'tipo_alerta'  => 'stock_agotado',
                    'nivel'        => 'critico',
                    'entidad_tipo' => 'producto',
                    'entidad_id'   => $producto->id,
                    'producto_id'  => $producto->id,
                    'mensaje'      => "STOCK AGOTADO: {$producto->nombre} sin unidades disponibles.",
                    'sugerencia'   => 'Realizar pedido de reabastecimiento urgente.',
                    'datos_extra'  => json_encode(['stock_actual' => 0]),
                ]);
            } elseif ($producto->stock <= $producto->stock_minimo) {
                $this->crearOActualizar([
                    'tipo_alerta'  => 'stock_minimo',
                    'nivel'        => 'preventivo',
                    'entidad_tipo' => 'producto',
                    'entidad_id'   => $producto->id,
                    'producto_id'  => $producto->id,
                    'mensaje'      => "Stock bajo en {$producto->nombre}: " .
                                     "{$producto->stock} uds (mínimo: {$producto->stock_minimo}).",
                    'sugerencia'   => 'Considerar reabastecimiento pronto.',
                    'datos_extra'  => json_encode([
                        'stock_actual'  => $producto->stock,
                        'stock_minimo'  => $producto->stock_minimo,
                    ]),
                ]);
            }
        }
    }

    /**
     * Crea alerta de vencimiento desde un score.
     */
    private function crearAlertaVencimiento(
        ScoreRiesgoLote $score,
        ConfiguracionAlertaIa $config
    ): void {
        $lote    = $score->lote;
        $producto = $lote->producto;
        $nivel   = $score->score_vencimiento >= $config->umbral_score_critico
            ? 'critico' : 'preventivo';

        $numeroLote = $lote->numero_lote ?? "Lote #{$lote->id}";

        $mensaje = "{$numeroLote} de {$producto->nombre} vence en " .
                   "{$score->dias_para_vencer} días con " .
                   "{$score->unidades_en_riesgo} uds en riesgo " .
                   "(Bs. {$score->valor_en_riesgo}).";

        $this->crearOActualizar([
            'tipo_alerta'  => 'vencimiento_proximo',
            'nivel'        => $nivel,
            'entidad_tipo' => 'lote',
            'entidad_id'   => $lote->id,
            'lote_id'      => $lote->id,
            'producto_id'  => $producto->id,
            'score_id'     => $score->id,
            'mensaje'      => $mensaje,
            'sugerencia'   => $score->sugerencia_accion,
            'datos_extra'  => json_encode([
                'score'            => $score->score_vencimiento,
                'dias_para_vencer' => $score->dias_para_vencer,
                'unidades_riesgo'  => $score->unidades_en_riesgo,
                'valor_en_riesgo'  => $score->valor_en_riesgo,
            ]),
        ]);
    }

    /**
     * Crea alerta nueva o reactiva una resuelta anterior.
     * Evita duplicados de alertas activas del mismo lote+tipo.
     */
    private function crearOActualizar(array $datos): void
    {
        $existente = AlertaInventario::where('tipo_alerta', $datos['tipo_alerta'])
            ->where('entidad_tipo', $datos['entidad_tipo'])
            ->where('entidad_id', $datos['entidad_id'])
            ->where('resuelta', false)
            ->first();

        if ($existente) {
            // Actualiza mensaje y sugerencia con datos frescos
            $existente->update([
                'mensaje'    => $datos['mensaje'],
                'sugerencia' => $datos['sugerencia'],
                'nivel'      => $datos['nivel'],
                'datos_extra'=> $datos['datos_extra'] ?? null,
            ]);
        } else {
            AlertaInventario::create($datos);
        }
    }

    /**
     * Obtiene configuración global (o crea una por defecto si no existe).
     */
    private function getConfig(): ConfiguracionAlertaIa
    {
        return ConfiguracionAlertaIa::firstOrCreate(
            ['producto_id' => null],
            [
                'dias_aviso_vencimiento'   => 30,
                'umbral_score_critico'     => 0.700,
                'umbral_score_preventivo'  => 0.400,
                'dias_sin_rotacion_alerta' => 15,
                'activo'                   => true,
            ]
        );
    }
}
