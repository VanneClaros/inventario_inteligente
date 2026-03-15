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

$total = 0;

foreach ($request->productos as $index => $producto_id)
{

$producto = Producto::find($producto_id);
$cantidad = $request->cantidades[$index];

if(!$producto){
return redirect('/ventas/create')
->with('error','Producto no encontrado');
}

if($cantidad <= 0){
return redirect('/ventas/create')
->with('error','Cantidad inválida');
}

if($producto->stock < $cantidad){

return redirect('/ventas/create')
->with('error','Stock insuficiente para '.$producto->nombre.
'. Stock disponible: '.$producto->stock);

}

}


$venta = Venta::create([
'cliente_id'=>$request->cliente_id,
'fecha'=>$request->fecha,
'total'=>0
]);


foreach ($request->productos as $index => $producto_id)
{

$producto = Producto::find($producto_id);
$cantidad = $request->cantidades[$index];
$precio = $producto->precio;
$subtotal = $precio * $cantidad;


DetalleVenta::create([

'venta_id'=>$venta->id,
'producto_id'=>$producto_id,
'cantidad'=>$cantidad,
'precio'=>$precio,
'subtotal'=>$subtotal

]);


$cantidadRestante = $cantidad;

$lotes = Lote::where('producto_id',$producto_id)
->where('cantidad','>',0)
->orderBy('fecha_vencimiento','asc')
->get();


foreach($lotes as $lote){

if($cantidadRestante <= 0){
break;
}

if($lote->cantidad >= $cantidadRestante){

$lote->cantidad -= $cantidadRestante;
$lote->save();
$cantidadRestante = 0;

}else{

$cantidadRestante -= $lote->cantidad;
$lote->cantidad = 0;
$lote->save();

}

}


$producto->stock -= $cantidad;
$producto->save();


$total += $subtotal;

}


$venta->total = $total;
$venta->save();


return redirect('/ventas')->with('success','Venta registrada correctamente');

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

// devolver stock

$producto->stock += $detalle->cantidad;

$producto->save();

}


DetalleVenta::where('venta_id',$id)->delete();

$venta->delete();

return redirect('/ventas');

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