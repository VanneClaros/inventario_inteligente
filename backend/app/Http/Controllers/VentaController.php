<?php

namespace App\Http\Controllers;

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

        return view('Venta.create',compact('clientes','productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'productos' => 'required|array|min:1',
            'cantidades' => 'required|array|min:1',
        ]);

        $total = 0;

        // Validar stock y lotes antes de crear la venta
        foreach ($request->productos as $index => $producto_id) {
            $producto = Producto::find($producto_id);
            $cantidad = $request->cantidades[$index];

            if (!$producto) {
                return back()->with('error', 'Producto no encontrado');
            }
            if ($cantidad <= 0) {
                return back()->with('error', 'Cantidad inválida');
            }
            // Validar stock general
            if ($producto->stock < $cantidad) {
                return back()->with('error', 'Stock insuficiente para ' . $producto->nombre .
                    '. Stock disponible: ' . $producto->stock);
            }
            // Validar lotes no vencidos
            $lotes_validos = Lote::where('producto_id', $producto_id)
                ->where('fecha_vencimiento', '>=', now()) // solo lotes vigentes
                ->where('cantidad', '>', 0)
                ->orderBy('fecha_vencimiento', 'asc')
                ->get();

            $totalDisponible = $lotes_validos->sum('cantidad');

            if ($totalDisponible < $cantidad) {
                return back()->with('error', 'Producto vencido: ' . $producto->nombre);
            }
        }

        // Crear la venta
        $venta = Venta::create([
            'cliente_id' => $request->cliente_id,
            'fecha' => $request->fecha,
            'total' => 0
        ]);

        // Registrar detalles y descontar stock/lotes
        foreach ($request->productos as $index => $producto_id) {
            $producto = Producto::find($producto_id);
            $cantidad = $request->cantidades[$index];
            $precio = $producto->precio;
            $subtotal = $precio * $cantidad;

            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $producto_id,
                'cantidad' => $cantidad,
                'precio' => $precio,
                'subtotal' => $subtotal
            ]);

            // Descontar de lotes (FIFO)
            $cantidadRestante = $cantidad;
            $lotes = Lote::where('producto_id', $producto_id)
                ->where('fecha_vencimiento', '>=', now())
                ->where('cantidad', '>', 0)
                ->orderBy('fecha_vencimiento', 'asc')
                ->get();

            foreach ($lotes as $lote) {
                if ($cantidadRestante <= 0) break;

                if ($lote->cantidad >= $cantidadRestante) {
                    $lote->cantidad -= $cantidadRestante;
                    $lote->save();
                    $cantidadRestante = 0;
                } else {
                    $cantidadRestante -= $lote->cantidad;
                    $lote->cantidad = 0;
                    $lote->save();
                }
            }

            // Descontar stock general
            $producto->stock -= $cantidad;
            $producto->save();

            $total += $subtotal;
        }

        $venta->total = $total;
        $venta->save();

        return redirect('/ventas')->with('success', 'Venta registrada correctamente');
    }

    public function show($id)
    {
        $venta = Venta::with('cliente')->findOrFail($id);
        $detalles = DetalleVenta::with('producto')
        ->where('venta_id',$id)
        ->get();
        return view('Venta.show',compact('venta','detalles'));
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
        'cliente_id'=>$request->cliente_id
        ]);
        return redirect('/ventas');
    }

    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);

        $detalles = DetalleVenta::where('venta_id',$id)->get();

        foreach($detalles as $detalle){

            $producto = Producto::find($detalle->producto_id);

            $cantidadRestaurar = $detalle->cantidad;

            //DEVOLVER A LOTES (orden inverso FIFO)
            $lotes = Lote::where('producto_id',$detalle->producto_id)
            ->orderBy('fecha_vencimiento','desc') // inverso
            ->get();

            foreach($lotes as $lote){

                if($cantidadRestaurar <= 0){
                    break;
                }

                $lote->cantidad += $cantidadRestaurar;
                $lote->save();

                $cantidadRestaurar = 0;
            }

            //DEVOLVER STOCK GENERAL
            $producto->stock += $detalle->cantidad;
            $producto->save();
        }

        DetalleVenta::where('venta_id',$id)->delete();
        $venta->delete();

        return redirect('/ventas')->with('success','Venta eliminada correctamente');
    }

    public function dashboard()
    {
        $ventas_hoy = Venta::whereDate('created_at', today())->sum('total');
        $ventas_mes = Venta::whereMonth('created_at', date('m'))->sum('total');
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