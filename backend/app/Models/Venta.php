<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    public function detalles()
{
    return $this->hasMany(DetalleVenta::class);
}
}
