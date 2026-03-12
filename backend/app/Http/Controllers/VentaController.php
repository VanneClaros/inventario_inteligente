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
        'cliente_id'=>$request->cliente_id,
        'total'=>0
    ]);

    $producto = Producto::find($request->producto_id);

    $total = $producto->precio * $request->cantidad;

    DetalleVenta::create([
        'venta_id'=>$venta->id,
        'producto_id'=>$producto->id,
        'cantidad'=>$request->cantidad,
        'precio'=>$producto->precio
    ]);

    // DESCONTAR STOCK
    $producto->decrement('stock', $request->cantidad);

    $venta->total = $total;
    $venta->save();

    return redirect('/ventas');
}

public function show($id)
{

$venta = Venta::with('cliente','detalles.producto')->findOrFail($id);

return view('ventas.show', compact('venta'));

}

public function edit($id)
{

$venta = Venta::findOrFail($id);
$clientes = Cliente::all();

return view('ventas.edit', compact('venta','clientes'));

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

$venta->delete();

return redirect('/ventas');

}

}