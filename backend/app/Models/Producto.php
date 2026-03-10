<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function detalles()
{
    return $this->hasMany(DetalleVenta::class);
    
}
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categorias_id'
    ];  
}