<?php

namespace App\Http\Controllers;

use App\Services\AnthropicService;
use App\Models\Producto;
use Illuminate\Http\Request;

class IAController extends Controller
{
    protected $ia;

    public function __construct(AnthropicService $ia)
    {
        $this->ia = $ia;
    }

    public function predecirDemanda($productoId)
    {
        $producto = Producto::with('detalles')->findOrFail($productoId);

        // Historial de ventas real desde detalles
        $historial = $producto->detalles()
            ->selectRaw('DATE(created_at) as fecha, SUM(cantidad) as cantidad')
            ->groupBy('fecha')
            ->orderBy('fecha', 'desc')
            ->limit(90)
            ->get()
            ->toArray();

        $resultado = $this->ia->predecirDemanda($historial, $producto->nombre);

        return response()->json([
            'producto' => $producto->nombre,
            'stock_actual' => $producto->stock,
            'prediccion' => $resultado
        ]);
    }

    public function analizarRiesgo($productoId)
    {
        $producto = Producto::findOrFail($productoId);

        $datos = [
            'producto_id'  => (int) $productoId,
            'nombre'       => $producto->nombre,
            'stock_actual' => $producto->stock ?? 0,
            'stock_minimo' => $producto->stock_minimo ?? 0,
            'precio'       => $producto->precio ?? 0,
            'categoria_id' => $producto->categoria_id ?? null,
        ];

        $resultado = $this->ia->calcularRiesgoInventario($datos);

        return response()->json([
            'producto' => $producto->nombre,
            'datos_analizados' => $datos,
            'riesgo' => $resultado
        ]);
    }

    public function generarAlertas()
    {
        $productos = Producto::select('id', 'nombre', 'stock', 'stock_minimo', 'precio')
            ->get()
            ->toArray();

        $resultado = $this->ia->generarAlertas($productos);

        return response()->json([
            'total_productos' => count($productos),
            'alertas' => $resultado
        ]);
    }
}