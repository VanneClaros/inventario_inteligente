<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Totales generales
        $totalProductos = Producto::count();
        $totalClientes = Cliente::count();
        $totalVentas = Venta::count();

        // Ventas por día (gráfico de línea)
        $ventasPorDia = Venta::select(
            DB::raw('DATE(created_at) as fecha'),
            DB::raw('SUM(total) as total')
        )
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('fecha', 'asc')
        ->get();

        // Productos más vendidos (gráfico de pastel)
        $productosVendidos = DB::table('detalle_ventas')
            ->join('productos','detalle_ventas.producto_id','=','productos.id')
            ->select('productos.nombre', DB::raw('SUM(detalle_ventas.cantidad) as total'))
            ->groupBy('productos.nombre')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $productoTop = $productosVendidos->first();

        // Clientes con más compras (gráfico de barras)
        $clientesTop = DB::table('ventas')
            ->join('clientes','ventas.cliente_id','=','clientes.id')
            ->select('clientes.nombre', DB::raw('COUNT(ventas.id) as total'))
            ->groupBy('clientes.nombre')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $clienteTop = $clientesTop->first();

        // Productos con poco stock
        $stockBajo = Producto::where('stock','<',5)->get();

        return view('dashboard', compact(
            'totalProductos',
            'totalClientes',
            'totalVentas',
            'ventasPorDia',
            'productosVendidos',
            'productoTop',
            'clientesTop',
            'clienteTop',
            'stockBajo'
        ));
    }
}