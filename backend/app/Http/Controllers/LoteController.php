<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;
use App\Models\Producto;

class LoteController extends Controller
{

public function index()
{

$lotes = Lote::with('producto')->get();

return view('Lote.index',compact('lotes'));

}

public function create()
{

$productos = Producto::all();

return view('Lote.create',compact('productos'));

}

public function store(Request $request)
{

$lote = Lote::create([

'producto_id'=>$request->producto_id,
'cantidad'=>$request->cantidad,
'fecha_ingreso'=>$request->fecha_ingreso,
'fecha_vencimiento'=>$request->fecha_vencimiento

]);

// actualizar stock del producto

$producto = Producto::find($request->producto_id);

$producto->stock += $request->cantidad;

$producto->save();

return redirect()->route('lotes.index');

}

public function edit($id)
{

$lote = Lote::find($id);
$productos = Producto::all();

return view('lotes.edit',compact('lote','productos'));

}

public function update(Request $request,$id)
{

$lote = Lote::find($id);

$lote->update([

'producto_id'=>$request->producto_id,
'cantidad'=>$request->cantidad,
'fecha_ingreso'=>$request->fecha_ingreso,
'fecha_vencimiento'=>$request->fecha_vencimiento

]);

return redirect()->route('lotes.index');

}

public function destroy($id)
{

$lote = Lote::find($id);

$lote->delete();

return redirect()->route('lotes.index');

}

}