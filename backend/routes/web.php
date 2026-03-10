<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;

Route::resource('productos', ProductoController::class); //Crea rutas para CRUD de productos.
Route::resource('categorias', CategoriaController::class);
Route::resource('clientes', ClienteController::class);