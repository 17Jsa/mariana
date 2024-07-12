<?php

namespace App\Filament\Resources\VentaResource\Pages;

use App\Filament\Resources\VentaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVenta extends CreateRecord
{
    protected static string $resource = VentaResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        DB::transaction(function() use (&$data) {
            $productosVendidos = $data['productos_vendidos'];
            unset($data['productos_vendidos']);
            $venta = Venta::create($data);

            $totalVenta = 0;

            foreach ($productosVendidos as $productoVendido) {
                $producto = Producto::find($productoVendido['producto_id']);
                $cantidad = $productoVendido['cantidad'];
                $precioUnitario = $producto->precio;
                $subtotal = $cantidad * $precioUnitario;

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'subtotal' => $subtotal,
                ]);

                $inventario = InventarioDiario::where('producto_id', $producto->id)
                    ->where('fecha', $venta->fecha)
                    ->first();
                if ($inventario) {
                    $inventario->cantidad -= $cantidad;
                    $inventario->save();
                }

                $totalVenta += $subtotal;
            }

            $venta->total = $totalVenta;
            $venta->save();
        });

        return $data;
    }
}
