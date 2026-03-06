<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto; //Importa el modelo Producto para interactuar con la base de datos.

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all(); //Obtiene todos los productos de la base de datos.
        return view('Producto.index', compact('productos')); //Retorna la vista index.blade.php con la variable productos.
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Producto.create');//Retorna la vista create.blade.php para mostrar el formulario de creación de un nuevo producto.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
