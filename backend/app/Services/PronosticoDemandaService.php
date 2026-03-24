<?php

namespace App\Services;

use App\Models\Producto;
use App\Models\PrediccionDemanda;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PronosticoDemandaService
{
    /**
     * Genera pronósticos semanales para todos los productos.
     * Lo llama el cron cada lunes.
     */
    public function generarSemanal(): void
    {
        $productos = Producto::where('stock', '>', 0)->get();

        foreach ($productos as $producto) {
            try {
                $this->pronosticarProducto($producto);
            } catch (\Exception $e) {
                Log::error("Error pronóstico producto {$producto->id}: " . $e->getMessage());
            }
        }
    }

    /**
     * Genera pronóstico de demanda para UN producto usando Claude API.
     */
    public function pronosticarProducto(Producto $producto): ?PrediccionDemanda
    {
        // ── 1. Recopilar historial de ventas por semana (últimas 12 semanas) ──
        $historial = DB::table('detalle_ventas')
            ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->where('detalle_ventas.producto_id', $producto->id)
            ->where('ventas.fecha', '>=', Carbon::now()->subWeeks(12))
            ->selectRaw("
                YEAR(ventas.fecha) as anio,
                WEEK(ventas.fecha) as semana,
                MIN(ventas.fecha) as fecha_inicio,
                SUM(detalle_ventas.cantidad) as total_vendido
            ")
            ->groupBy('anio', 'semana')
            ->orderBy('fecha_inicio')
            ->get();

        // Si no hay historial suficiente, usar promedio simple
        if ($historial->count() < 2) {
            return $this->pronosticoSimple($producto);
        }

        // ── 2. Preparar datos para enviar a Claude API ──────────────
        $datosHistorial = $historial->map(fn($h) => [
            'semana'       => $h->fecha_inicio,
            'unidades'     => (int) $h->total_vendido,
        ])->toArray();

        $prompt = "Eres un sistema de pronóstico de inventario. " .
                  "Analiza el historial de ventas semanales del producto '{$producto->nombre}' " .
                  "y predice la demanda para la próxima semana. " .
                  "Historial (últimas semanas): " . json_encode($datosHistorial) . ". " .
                  "Stock actual: {$producto->stock} unidades. " .
                  "Responde SOLO con un JSON con esta estructura exacta, sin texto adicional: " .
                  '{"cantidad_predicha": 15, "cantidad_minima": 10, "cantidad_maxima": 20, ' .
                  '"confianza_pct": 75, "razon": "Tendencia estable con ligero aumento"}';

        // ── 3. Llamar a Claude API ───────────────────────────────────
        $respuesta = $this->llamarClaudeAPI($prompt);
        if (!$respuesta) {
            return $this->pronosticoSimple($producto);
        }

        // ── 4. Guardar predicción ────────────────────────────────────
        $periodoInicio = Carbon::now()->startOfWeek()->addWeek();
        $periodoFin    = $periodoInicio->copy()->endOfWeek();

        return PrediccionDemanda::create([
            'producto_id'      => $producto->id,
            'modelo_ia_id'     => null, // null = usa Claude API, no modelo local
            'periodo_inicio'   => $periodoInicio,
            'periodo_fin'      => $periodoFin,
            'granularidad'     => 'semanal',
            'cantidad_predicha'=> $respuesta['cantidad_predicha'] ?? 0,
            'cantidad_minima'  => $respuesta['cantidad_minima'] ?? null,
            'cantidad_maxima'  => $respuesta['cantidad_maxima'] ?? null,
            'confianza_pct'    => $respuesta['confianza_pct'] ?? null,
            'fuente'           => 'claude_api',
            'datos_entrada'    => json_encode([
                'historial_semanas' => count($datosHistorial),
                'stock_actual'      => $producto->stock,
                'razon_ia'          => $respuesta['razon'] ?? '',
            ]),
        ]);
    }

    /**
     * Llama a Claude API y retorna el JSON parseado.
     */
    private function llamarClaudeAPI(string $prompt): ?array
    {
        $apiKey = config('services.anthropic.api_key');
        if (!$apiKey) {
            Log::warning('Claude API key no configurada en services.anthropic.api_key');
            return null;
        }

        $response = Http::withHeaders([
            'x-api-key'         => $apiKey,
            'anthropic-version' => '2023-06-01',
            'content-type'      => 'application/json',
        ])->post('https://api.anthropic.com/v1/messages', [
            'model'      => 'claude-sonnet-4-6',
            'max_tokens' => 300,
            'messages'   => [
                ['role' => 'user', 'content' => $prompt]
            ],
        ]);

        if (!$response->successful()) {
            Log::error('Claude API error: ' . $response->body());
            return null;
        }

        $texto = $response->json('content.0.text', '');

        // Limpiar posibles backticks de markdown
        $texto = preg_replace('/```json|```/', '', $texto);

        try {
            return json_decode(trim($texto), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Exception $e) {
            Log::error('Error parseando respuesta Claude: ' . $texto);
            return null;
        }
    }

    /**
     * Pronóstico simple cuando no hay historial suficiente.
     * Usa promedio de los últimos 30 días.
     */
    private function pronosticoSimple(Producto $producto): PrediccionDemanda
    {
        $vendido30d = DB::table('detalle_ventas')
            ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->where('detalle_ventas.producto_id', $producto->id)
            ->where('ventas.fecha', '>=', Carbon::now()->subDays(30))
            ->sum('detalle_ventas.cantidad');

        $promedioSemanal = round(($vendido30d / 30) * 7, 1);

        $periodoInicio = Carbon::now()->startOfWeek()->addWeek();

        return PrediccionDemanda::create([
            'producto_id'       => $producto->id,
            'modelo_ia_id'      => null,
            'periodo_inicio'    => $periodoInicio,
            'periodo_fin'       => $periodoInicio->copy()->endOfWeek(),
            'granularidad'      => 'semanal',
            'cantidad_predicha' => $promedioSemanal,
            'confianza_pct'     => 50,
            'fuente'            => 'claude_api',
            'datos_entrada'     => json_encode([
                'metodo'      => 'promedio_simple_30d',
                'vendido_30d' => $vendido30d,
            ]),
        ]);
    }
}
