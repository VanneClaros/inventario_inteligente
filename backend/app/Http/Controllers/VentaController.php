<?php
namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Http\Controllers\Controller;

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
    $venta = Venta::create([
        'cliente_id' => $request->cliente_id,
        'total' => 0
    ]);

    $total = 0;

    foreach ($request->productos as $index => $producto_id) {
        $producto = Producto::find($producto_id);
        $cantidad = $request->cantidades[$index];
        $precio = $request->precios[$index];
        $subtotal = $precio * $cantidad;

        DetalleVenta::create([
            'venta_id' => $venta->id,
            'producto_id' => $producto->id,
            'cantidad' => $cantidad,
            'precio' => $precio
        ]);

        // Descontar stock
        $producto->decrement('stock', $cantidad);
        $total += $subtotal;
    }

    $venta->total = $total;
    $venta->save();

    return redirect()->route('ventas.index');
}

    public function show($id)
    {
        $venta = Venta::with('cliente')->findOrFail($id);
        $detalles = DetalleVenta::with('producto')->where('venta_id',$id)->get();
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
        $producto->stock = $producto->stock + $detalle->cantidad;
        $producto->save();
    }

    DetalleVenta::where('venta_id',$id)->delete();
    $venta->delete();
    return redirect('/ventas');
    }

}