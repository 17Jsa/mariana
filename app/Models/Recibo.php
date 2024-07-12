<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    protected $table="recibos";
    protected $fillable = ['id','cliente','fecha_venta','vendedor','total_a_pagar','total_descuentos','impuesto_consumo','total_iva'];

    use HasFactory;
}
