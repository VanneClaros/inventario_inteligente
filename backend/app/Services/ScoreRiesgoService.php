<?php

namespace App\Services;

use App\Models\Lote;
use App\Models\ScoreRiesgoLote;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ScoreRiesgoService
{
    /**
     * Calcula el score de riesgo para TODOS los lotes activos.
     * Lo llama el cron cada noche.
     */
    public function calcularTodos(): void
    {
        // Solo lotes con stock > 0 y que aún no han vencido
        $lotes = Lote::with('producto')
            ->where('cantidad', '>', 0)
            ->where('fecha_vencimiento', '>=', Carbon::today())
            ->get();

        foreach ($lotes as $lote) {
            $this->calcularParaLote($lote);
        }
    }

    /**
     * Calcula el score para UN lote específico.
     * Retorna el score creado.
     */
    public function calcularParaLote(Lote $lote): ScoreRiesgoLote
    {
        $hoy = Carbon::today();
        $fechaVence = Carbon::parse($lote->fecha_vencimiento);
        $fechaIngreso = Carbon::parse($lote->fecha_ingreso);

        // ── 1. Días para vencer ──────────────────────────────────────
        $diasParaVencer = $hoy->diffInDays($fechaVence, false);
        // false = negativo si ya venció (aunque filtramos eso arriba)

        // ── 2. Tasa de rotación diaria ───────────────────────────────
        // Suma de unidades vendidas de este producto en los últimos 30 días
        // usando tu tabla detalle_ventas existente
        $unidadesVendidas30d = DB::table('detalle_ventas')
            ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->where('detalle_ventas.producto_id', $lote->producto_id)
            ->where('ventas.fecha', '>=', $hoy->copy()->subDays(30))
            ->sum('detalle_ventas.cantidad');

        $rotacionDiaria = $unidadesVendidas30d > 0
            ? round($unidadesVendidas30d / 30, 2)
            : 0;

        // ── 3. Proyección de ventas antes de vencer ──────────────────
        $unidadesProyectadasVender = round($rotacionDiaria * $diasParaVencer, 2);

        // ── 4. Unidades en riesgo ────────────────────────────────────
        $unidadesEnRiesgo = max(0, $lote->cantidad - $unidadesProyectadasVender);

        // ── 5. Valor económico en riesgo ─────────────────────────────
        $valorEnRiesgo = round(
            $unidadesEnRiesgo * ($lote->producto->precio ?? 0),
            2
        );

        // ── 6. Score principal (0.00 a 1.00) ─────────────────────────
        // Lógica: qué porcentaje del stock NO se venderá antes de vencer
        $score = $lote->cantidad > 0
            ? round(min(1, $unidadesEnRiesgo / $lote->cantidad), 3)
            : 0;

        // Penalizar score si quedan muy pocos días (urgencia temporal)
        if ($diasParaVencer <= 3)  $score = min(1, $score + 0.3);
        elseif ($diasParaVencer <= 7)  $score = min(1, $score + 0.15);
        elseif ($diasParaVencer <= 15) $score = min(1, $score + 0.05);

        // ── 7. Nivel de riesgo ───────────────────────────────────────
        $nivel = match(true) {
            $score >= 0.8 => 'critico',
            $score >= 0.6 => 'alto',
            $score >= 0.3 => 'moderado',
            default       => 'bajo',
        };

        // ── 8. Sugerencia automática ─────────────────────────────────
        $sugerencia = $this->generarSugerencia(
            $nivel, $diasParaVencer, $unidadesEnRiesgo, $valorEnRiesgo
        );

        // ── 9. Guardar score ─────────────────────────────────────────
        return ScoreRiesgoLote::create([
            'lote_id'                     => $lote->id,
            'score_vencimiento'           => $score,
            'nivel_riesgo'                => $nivel,
            'dias_para_vencer'            => $diasParaVencer,
            'unidades_restantes'          => $lote->cantidad,
            'tasa_rotacion_diaria'        => $rotacionDiaria,
            'unidades_proyectadas_vender' => $unidadesProyectadasVender,
            'unidades_en_riesgo'          => $unidadesEnRiesgo,
            'valor_en_riesgo'             => $valorEnRiesgo,
            'sugerencia_accion'           => $sugerencia,
        ]);
    }

    /**
     * Genera sugerencia de texto según el nivel de riesgo.
     */
    private function generarSugerencia(
        string $nivel,
        int $dias,
        float $unidades,
        float $valor
    ): string {
        return match($nivel) {
            'critico' => "URGENTE: {$unidades} uds en riesgo (Bs. {$valor}). " .
                         "Aplicar descuento del 30-40% o retirar del stock en {$dias} días.",
            'alto'    => "{$unidades} uds podrían vencer en {$dias} días (Bs. {$valor}). " .
                         "Considerar promoción o traslado a punto de mayor venta.",
            'moderado'=> "Monitorear rotación. {$unidades} uds con riesgo moderado en {$dias} días.",
            default   => "Lote con rotación saludable. Sin acción requerida.",
        };
    }
}
