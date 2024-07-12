<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibos');
    }

    public function up()
{
    Schema::create('recibos', function (Blueprint $table) {
        $table->id();
        $table->string('cliente');
        $table->date('fecha_venta');
        $table->string('vendedor');
        $table->decimal('total_a_pagar', 8, 2);
        $table->decimal('total_descuentos', 8, 2)->default(0);
        $table->decimal('impuesto_consumo', 8, 2);
        $table->decimal('total_iva', 8, 2)->default(0);
        $table->timestamps();
    });
}
};
