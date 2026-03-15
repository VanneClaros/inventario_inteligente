<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $fillable = [
        'producto_id',
        'cantidad',
        'fecha_ingreso',
        'fecha_vencimiento'
        ];

    public function producto()
    {
    return $this->belongsTo(Producto::class);
    }
}
