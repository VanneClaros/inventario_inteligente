<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $categorias = Categoria::all();
    return view('Categoria.index', compact('categorias'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('Categoria.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    Categoria::create($request->all());
    return redirect('/categorias');
}

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $categoria = Categoria::find($id);
    return view('Categoria.edit', compact('categoria'));
}

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $categoria = Categoria::find($id);
    $categoria->update($request->all());
    return redirect('/categorias');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    Categoria::destroy($id);
    return redirect('/categorias');
}
}
