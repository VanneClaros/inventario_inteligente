<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AnthropicService
{
    protected $baseUrl = 'http://127.0.0.1:8001/ia';

    public function predecirDemanda(array $historial, string $nombre): array
    {
        $response = Http::timeout(30)->post("{$this->baseUrl}/predecir", [
            'producto_id' => 1,
            'nombre'      => $nombre,
            'historial'   => $historial,
        ]);

        return $response->json() ?? [];
    }

    public function calcularRiesgoInventario(array $datos): array
    {
        $response = Http::timeout(30)->post("{$this->baseUrl}/riesgo", $datos);

        return $response->json() ?? [];
    }

    public function generarAlertas(array $productos): array
    {
        $response = Http::timeout(30)->post("{$this->baseUrl}/alertas", [
            'productos' => $productos,
        ]);

        return $response->json() ?? [];
    }
}