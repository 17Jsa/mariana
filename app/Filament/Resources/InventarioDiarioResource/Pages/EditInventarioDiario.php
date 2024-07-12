<?php

namespace App\Filament\Resources\InventarioDiarioResource\Pages;

use App\Filament\Resources\InventarioDiarioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInventarioDiario extends EditRecord
{
    protected static string $resource = InventarioDiarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
