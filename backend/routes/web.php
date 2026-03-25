<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IAController;

/* RUTA PRINCIPAL → redirige al login */
Route::get('/', fn() => redirect()->route('login'));

/* RUTAS PROTEGIDAS POR AUTENTICACIÓN */
Route::middleware(['auth'])->group(function () {

    // ADMIN y VENDEDOR → dashboard, ventas, clientes
    Route::middleware(['rol:admin,vendedor'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('ventas', VentaController::class);
        Route::resource('clientes', ClienteController::class);
    });

    // SOLO ADMIN → productos, lotes, reportes
    Route::middleware(['rol:admin'])->group(function () {
        Route::resource('lotes', LoteController::class);
        Route::resource('productos', ProductoController::class);
        Route::get('/reportes/ventas', [ReporteController::class, 'ventas'])->name('reportes.ventas');
        Route::get('/reportes/pdf', [ReporteController::class, 'exportarPDF'])->name('reportes.pdf');
    });

    // PERFIL (todos los autenticados)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Vista IA
    Route::middleware(['auth'])->get('/productos-list', function() {
    return response()->json(\App\Models\Producto::select('id', 'nombre')->get()); 
});
Route::middleware(['auth'])->prefix('ia')->group(function () {
    Route::get('/alertas',               [IAController::class, 'generarAlertas'])->name('ia.alertas');
    Route::get('/predecir/{productoId}', [IAController::class, 'predecirDemanda'])->name('ia.predecir');
    Route::get('/riesgo/{productoId}',   [IAController::class, 'analizarRiesgo'])->name('ia.riesgo');
    Route::get('/dashboard',             fn() => view('ia.dashboard'))->name('ia.dashboard');
});
});
/* AUTH (BREEZE) 🔥 NO BORRAR */
require __DIR__.'/auth.php';