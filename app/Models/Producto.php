<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = ['nombre', 'precio', 'cantidad', 'codigo'];

    public function inventarioDiario(): HasMany
    {
        return $this->hasMany(InventarioDiario::class);
    }
}
