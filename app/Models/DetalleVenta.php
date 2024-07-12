<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';

    protected $fillable = ['venta_id', 'producto_id', 'cantidad', 'precio_unitario', 'subtotal'];

    protected $casts = [
        'cantidad' => 'float',
        'precio_unitario' => 'float',
        'subtotal' => 'float',
    ];

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    protected static function booted()
    {
        static::creating(function ($detalleVenta) {
            $detalleVenta->subtotal = $detalleVenta->cantidad * $detalleVenta->precio_unitario;
        });

        static::created(function ($detalleVenta) {
            $producto = $detalleVenta->producto;
        });
    }
}
