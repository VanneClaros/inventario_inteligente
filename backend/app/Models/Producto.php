<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function lotes()
    {
    return $this->hasMany(Lote::class);
    }
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'stock_minimo',
        'categoria_id'
    ];  
    
}