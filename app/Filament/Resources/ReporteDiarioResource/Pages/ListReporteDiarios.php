<?php

namespace App\Filament\Resources\ReporteDiarioResource\Pages;

use App\Filament\Resources\ReporteDiarioResource;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\ListRecords;

class ListReporteDiarios extends ListRecords
{
    protected static string $resource = ReporteDiarioResource::class;

    protected function getTableQuery(): ?\Illuminate\Database\Eloquent\Builder
    {
        $fechaHoy = now()->toDateString();

        $inventarioInicialSubquery = DB::table('inventario_diario')
            ->select('producto_id', 'cantidad')
            ->where('fecha', $fechaHoy);

        $ventasDelDiaSubquery = DB::table('detalle_venta')
            ->join('ventas', 'detalle_venta.venta_id', '=', 'ventas.id')
            ->select('detalle_venta.producto_id', DB::raw('SUM(detalle_venta.cantidad) as cantidad_vendida'), DB::raw('SUM(detalle_venta.subtotal) as total_vendido'))
            ->whereDate('ventas.created_at', $fechaHoy)
            ->groupBy('detalle_venta.producto_id');

        return Producto::query()
            ->leftJoinSub($inventarioInicialSubquery, 'inventario_inicial', 'productos.id', '=', 'inventario_inicial.producto_id')
            ->leftJoinSub($ventasDelDiaSubquery, 'ventas_del_dia', 'productos.id', '=', 'ventas_del_dia.producto_id')
            ->select(
                'productos.id',
                'productos.nombre',
                'inventario_inicial.cantidad as cantidad_inicial',
                'ventas_del_dia.cantidad_vendida',
                'ventas_del_dia.total_vendido',
                DB::raw('COALESCE(inventario_inicial.cantidad, 0) - COALESCE(ventas_del_dia.cantidad_vendida, 0) as cantidad_final')
            );
    }
}
