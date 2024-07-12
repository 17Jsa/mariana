<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class InventarioDiario extends Model
{
    use HasFactory;
    
    protected $table = 'inventario_diario';

    protected $fillable = ['producto_id', 'cantidad', 'fecha'];

    public function Producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
