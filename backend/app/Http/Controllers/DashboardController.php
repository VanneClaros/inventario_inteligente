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

        $totalProductos = Producto::count();
        $totalClientes = Cliente::count();
        $totalVentas = Venta::count();

        // ventas por dia
        $ventasPorDia = Venta::select(
            DB::raw('DATE(created_at) as fecha'),
            DB::raw('SUM(total) as total')
        )
        ->groupBy('fecha')
        ->orderBy('fecha')
        ->get();

        // producto mas vendido
        $productoTop = DB::table('detalle_ventas')
        ->join('productos','detalle_ventas.producto_id','=','productos.id')
        ->select('productos.nombre', DB::raw('SUM(detalle_ventas.cantidad) as total'))
        ->groupBy('productos.nombre')
        ->orderByDesc('total')
        ->first();

        // cliente que mas compra
        $clienteTop = DB::table('ventas')
        ->join('clientes','ventas.cliente_id','=','clientes.id')
        ->select('clientes.nombre', DB::raw('COUNT(ventas.id) as total'))
        ->groupBy('clientes.nombre')
        ->orderByDesc('total')
        ->first();

        // productos con poco stock
        $stockBajo = Producto::where('stock','<',5)->get();

        return view('dashboard', compact(
            'totalProductos',
            'totalClientes',
            'totalVentas',
            'ventasPorDia',
            'productoTop',
            'clienteTop',
            'stockBajo'
        ));
    }
}