<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Lote;
use Illuminate\Http\Request;


class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('cliente')->get();
        return view('Venta.index', compact('ventas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();

        return view('Venta.create', compact('clientes','productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'productos' => 'required|array|min:1',
            'cantidades' => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request) {
        $total = 0;

            // Crear la venta
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'fecha' => $request->fecha,
                'total' => 0
            ]);

            foreach ($request->productos as $index => $producto_id) {
                $producto = Producto::findOrFail($producto_id);
                $cantidad = $request->cantidades[$index];

                if ($cantidad <= 0) {
                    throw new \Exception("Cantidad inválida para {$producto->nombre}");
                }

                if ($producto->stock < $cantidad) {
                    throw new \Exception("Stock insuficiente para {$producto->nombre}. Disponible: {$producto->stock}");
                }

                // Validar lotes vigentes
                $lotes = Lote::where('producto_id', $producto_id)
                    ->where('fecha_vencimiento', '>=', now())
                    ->where('cantidad', '>', 0)
                    ->orderBy('fecha_vencimiento', 'asc')
                    ->get();

                $totalDisponible = $lotes->sum('cantidad');
                if ($totalDisponible < $cantidad) {
                    throw new \Exception("No hay suficiente stock en lotes vigentes para {$producto->nombre}");
                }

                $precio = $producto->precio;
                $subtotal = $precio * $cantidad;

                $detalle = DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto_id,
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                    'subtotal' => $subtotal
                ]);

                // Descontar de lotes (FIFO)
                $cantidadRestante = $cantidad;
                foreach ($lotes as $lote) {
                    if ($cantidadRestante <= 0) break;

                    $descuento = min($lote->cantidad, $cantidadRestante);
                    $lote->cantidad -= $descuento;
                    $lote->save();

                    $cantidadRestante -= $descuento;
                }

                // Descontar stock general
                $producto->stock -= $cantidad;
                $producto->save();

                $total += $subtotal;
            }

            $venta->update(['total' => $total]);
        });

        return redirect('/ventas')->with('success', 'Venta registrada correctamente');
    }

    public function show($id)
    {
        $venta = Venta::with('cliente')->findOrFail($id);
        $detalles = DetalleVenta::with('producto')
            ->where('venta_id', $id)
            ->get();
        return view('Venta.show', compact('venta','detalles'));
    }

    public function edit($id)
    {
        $venta = Venta::findOrFail($id);
        $clientes = Cliente::all();
        return view('Venta.edit', compact('venta','clientes'));
    }

    public function update(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);
        $venta->update([
            'cliente_id' => $request->cliente_id
        ]);
        return redirect('/ventas');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $venta = Venta::findOrFail($id);
            $detalles = DetalleVenta::where('venta_id', $id)->get();

            foreach ($detalles as $detalle) {
                $producto = Producto::findOrFail($detalle->producto_id);
                $cantidadRestaurar = $detalle->cantidad;

                // Devolver stock general
                $producto->stock += $cantidadRestaurar;
                $producto->save();

                // Devolver a lotes (orden inverso FIFO)
                $lotes = Lote::where('producto_id', $detalle->producto_id)
                    ->orderBy('fecha_vencimiento', 'desc')
                    ->get();

                foreach ($lotes as $lote) {
                    if ($cantidadRestaurar <= 0) break;

                    $lote->cantidad += $cantidadRestaurar;
                    $lote->save();
                    $cantidadRestaurar = 0;
                }
            }

            DetalleVenta::where('venta_id', $id)->delete();
            $venta->delete();
        });

        return redirect('/ventas')->with('success', 'Venta eliminada correctamente');
    }

    public function dashboard()
    {
        // Usamos el campo 'fecha' en lugar de 'created_at'
        $ventas_hoy = Venta::whereDate('fecha', today())->sum('total');
        $ventas_mes = Venta::whereMonth('fecha', date('m'))->whereYear('fecha', date('Y'))->sum('total');

        $total_productos = Producto::count();
        $total_clientes = Cliente::count();
        $total_ventas = Venta::count();

        return view('dashboard', compact(
            'ventas_hoy',
            'ventas_mes',
            'total_productos',
            'total_clientes',
            'total_ventas'
        ));
    }
}