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
        return view('Lote.index', compact('lotes'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('Lote.create', compact('productos'));
    }

    public function store(Request $request)
{
    $request->validate([
        'producto_id'       => 'required|exists:productos,id',
        'cantidad'          => 'required|integer|min:1',
        'fecha_ingreso'     => 'required|date',
        'fecha_vencimiento' => 'required|date|after:fecha_ingreso',
    ], [
        'fecha_vencimiento.after' => 'La fecha de vencimiento debe ser posterior a la fecha de ingreso.',
        'cantidad.min'            => 'La cantidad debe ser al menos 1.',
    ]);

    // Generar número de lote automático: LOT-2026-001
    $anio    = date('Y');
    $ultimo  = Lote::whereYear('created_at', $anio)->count();
    $numero  = str_pad($ultimo + 1, 3, '0', STR_PAD_LEFT); // 001, 002, 003...
    $numeroLote = "LOT-{$anio}-{$numero}";

    Lote::create([
        'producto_id'       => $request->producto_id,
        'numero_lote'       => $numeroLote,
        'cantidad_inicial'  => $request->cantidad,
        'cantidad'          => $request->cantidad,
        'fecha_ingreso'     => $request->fecha_ingreso,
        'fecha_vencimiento' => $request->fecha_vencimiento,
    ]);

    // Actualizar stock del producto
    $producto = Producto::find($request->producto_id);
    $producto->stock += $request->cantidad;
    $producto->save();

    return redirect()->route('lotes.index')->with('success', 'Lote registrado correctamente.');
}

    public function edit($id)
    {
        $lote      = Lote::find($id);
        $productos = Producto::all();
        return view('Lote.edit', compact('lote', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'producto_id'       => 'required|exists:productos,id',
            'numero_lote'       => 'nullable|string|max:100',
            'cantidad'          => 'required|integer|min:0',
            'fecha_ingreso'     => 'required|date',
            'fecha_vencimiento' => 'required|date|after:fecha_ingreso',
        ], [
            'fecha_vencimiento.after' => 'La fecha de vencimiento debe ser posterior a la fecha de ingreso.',
        ]);

        $lote = Lote::find($id);
        $lote->producto_id       = $request->producto_id;
        $lote->numero_lote       = $request->numero_lote;
        $lote->cantidad          = $request->cantidad;
        $lote->fecha_ingreso     = $request->fecha_ingreso;
        $lote->fecha_vencimiento = $request->fecha_vencimiento;
        $lote->save();

        return redirect()->route('lotes.index')->with('success', 'Lote actualizado correctamente.');
    }

    public function destroy($id)
    {
        $lote = Lote::find($id);
        $lote->delete();
        return redirect()->route('lotes.index')->with('success', 'Lote eliminado correctamente.');
    }
}