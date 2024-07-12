<?php

namespace App\Filament\Resources\ProductoResource\Pages;

use App\Filament\Resources\ProductoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\DetalleVenta; // Asegúrate de importar el modelo DetalleVenta
use Illuminate\Support\Facades\DB;

class ListProductos extends ListRecords
{
    protected static string $resource = ProductoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('deleteAllSalesAndProducts')
                ->label('Eliminar Ventas y Productos')
                ->action('deleteAllSalesAndProducts')
                ->requiresConfirmation()
                ->color('danger')
                ->icon('heroicon-o-trash'),
        ];
    }

    public function deleteAllSalesAndProducts()
    {
        DB::beginTransaction();
        try {
            // Desactivar temporariamente las restricciones de claves foráneas
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Eliminar registros en cascada
            DetalleVenta::truncate();
            Venta::truncate();
            Producto::truncate();

            // Confirmar la transacción
            DB::commit();

            // Notificar éxito
            $this->notify('success', 'Datos eliminados correctamente.');
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();

            // Notificar error
            $this->notify('error', 'Ocurrió un error al eliminar los datos.');
        } finally {
            // Reactivar las restricciones de claves foráneas
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
