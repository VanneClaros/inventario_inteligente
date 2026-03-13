<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;

Route::resource('productos', ProductoController::class); //Crea rutas para CRUD de productos.
Route::resource('categorias', CategoriaController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('ventas', VentaController::class);
Route::get('/ventas/{id}', [VentaController::class, 'show'])->name('ventas.show'); //Ruta para mostrar detalles de una venta específica.
Route::get('/ventas', [VentaController::class, 'index']);
Route::delete('/ventas/{id}', [VentaController::class, 'destroy']);