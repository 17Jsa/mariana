<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venta extends Model
{
    protected $fillable = ['fecha', 'total'];

    protected $casts = [
        'total' => 'float',
    ];

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleVenta::class);
    }

    protected static function booted()
    {
        static::saving(function ($venta) {
            $venta->total = $venta->detalles->sum('subtotal');
        });
    }
}
