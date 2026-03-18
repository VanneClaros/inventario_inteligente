<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function ventas(Request $request)
    {
        // =========================
        // CONSULTA VENTAS + CLIENTE
        // =========================
        $query = DB::table('ventas')
            ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->select(
                'ventas.id',
                'ventas.created_at',
                'ventas.total',
                'clientes.nombre as cliente'
            );

        // FILTRO POR FECHA
        if ($request->fecha_inicio && $request->fecha_fin) {
            $query->whereBetween('ventas.created_at', [
                $request->fecha_inicio,
                $request->fecha_fin
            ]);
        }

        $ventas = $query->get();

        // TOTAL
        $total = $ventas->sum('total');

        // =========================
        // PRODUCTOS MÁS VENDIDOS 🔥 (CON FILTRO)
        // =========================
        $masVendidosQuery = DB::table('detalle_ventas')
            ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->select(
                'productos.nombre as producto',
                DB::raw('SUM(detalle_ventas.cantidad) as total_vendido')
            );

        if ($request->fecha_inicio && $request->fecha_fin) {
            $masVendidosQuery->whereBetween('ventas.created_at', [
                $request->fecha_inicio,
                $request->fecha_fin
            ]);
        }

        $masVendidos = $masVendidosQuery
            ->groupBy('productos.nombre')
            ->orderByDesc('total_vendido')
            ->take(5)
            ->get();

        // =========================
        // VENTAS POR DÍA 🔥 (CON FILTRO)
        // =========================
        $ventasPorDiaQuery = DB::table('ventas')
            ->select(
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('SUM(total) as total')
            );

        if ($request->fecha_inicio && $request->fecha_fin) {
            $ventasPorDiaQuery->whereBetween('created_at', [
                $request->fecha_inicio,
                $request->fecha_fin
            ]);
        }

        $ventasPorDia = $ventasPorDiaQuery
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->get();

        // =========================
        // RETORNAR VISTA
        // =========================
        return view('Reporte.ventas', compact(
            'ventas',
            'total',
            'masVendidos',
            'ventasPorDia'
        ));
    }

    // =========================
    // EXPORTAR PDF 🔥 COMPLETO
    // =========================
    public function exportarPDF(Request $request)
    {
        // VENTAS + CLIENTE
        $query = DB::table('ventas')
            ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->select(
                'ventas.id',
                'ventas.created_at',
                'ventas.total',
                'clientes.nombre as cliente'
            );

        if ($request->fecha_inicio && $request->fecha_fin) {
            $query->whereBetween('ventas.created_at', [
                $request->fecha_inicio,
                $request->fecha_fin
            ]);
        }

        $ventas = $query->get();
        $total = $ventas->sum('total');

        // =========================
        // PRODUCTOS MÁS VENDIDOS 🔥 (CON FILTRO TAMBIÉN EN PDF)
        // =========================
        $masVendidos = DB::table('detalle_ventas')
            ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->select(
                'productos.nombre as producto',
                DB::raw('SUM(detalle_ventas.cantidad) as total_vendido')
            )
            ->when($request->fecha_inicio && $request->fecha_fin, function ($query) use ($request) {
                $query->whereBetween('ventas.created_at', [
                    $request->fecha_inicio,
                    $request->fecha_fin
                ]);
            })
            ->groupBy('productos.nombre')
            ->orderByDesc('total_vendido')
            ->take(5)
            ->get();

        // PDF
        $pdf = Pdf::loadView('PDF.reporte', compact(
            'ventas',
            'total',
            'masVendidos'
        ));

        return $pdf->download('reporte_ventas_pro.pdf');
    }
}