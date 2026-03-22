<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\Lote;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
class DashboardController extends Controller
{
    public function index()
    {
        $totalProductos = Producto::count();
        $totalClientes = Cliente::count();
        $totalVentas = Venta::count();
        $ventasHoy = Venta::whereDate('created_at', now())->sum('total');
        $promedioVenta = Venta::avg('total');

        $filtro = request('filtro');
        $query = Venta::query();
        if($filtro == 'dia'){
            $query->whereDate('created_at', now());
        } elseif($filtro == 'semana'){
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif($filtro == 'mes'){
            $query->whereMonth('created_at', now()->month);
        } elseif($filtro == 'anio'){
            $query->whereYear('created_at', now()->year);
        }

        $ventasPorDia = $query->select(
            DB::raw('DATE(created_at) as fecha'),
            DB::raw('SUM(total) as total')
        )
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy(DB::raw('DATE(created_at)'))
        ->get();

        $productosVendidos = DB::table('detalle_ventas')
            ->join('productos','detalle_ventas.producto_id','=','productos.id')
            ->select('productos.nombre', DB::raw('SUM(detalle_ventas.cantidad) as total'))
            ->groupBy('productos.nombre')
            ->orderByDesc('total')
            ->take(5)
            ->get();
        $productoTop = $productosVendidos->first();

        $clientesTop = DB::table('ventas')
            ->join('clientes','ventas.cliente_id','=','clientes.id')
            ->select('clientes.nombre', DB::raw('COUNT(ventas.id) as total'))
            ->groupBy('clientes.nombre')
            ->orderByDesc('total')
            ->take(5)
            ->get();
        $clienteTop = $clientesTop->first();

        $stockBajo = Producto::where('stock','<', 5)->get();

        // 🚫 LOTES VENCIDOS
        $lotesVencidos = Lote::with('producto')
            ->where('fecha_vencimiento', '<', now())
            ->where('cantidad', '>', 0)
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();

        // ⏳ LOTES PRÓXIMOS A VENCER (30 días)
        $lotesPorVencer = Lote::with('producto')
            ->whereBetween('fecha_vencimiento', [now(), now()->addDays(30)])
            ->where('cantidad', '>', 0)
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();

        return view('dashboard', compact(
            'totalProductos', 'totalClientes', 'totalVentas',
            'ventasHoy', 'promedioVenta', 'ventasPorDia',
            'productosVendidos', 'productoTop', 'clientesTop',
            'clienteTop', 'stockBajo', 'lotesVencidos', 'lotesPorVencer'
        ));
    }
}