<?php

namespace App\Filament\Resources\InventarioDiarioResource\Pages;

use App\Filament\Resources\InventarioDiarioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInventarioDiarios extends ListRecords
{
    protected static string $resource = InventarioDiarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
