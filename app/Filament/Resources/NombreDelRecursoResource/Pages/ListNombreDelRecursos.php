<?php

namespace App\Filament\Resources\NombreDelRecursoResource\Pages;

use App\Filament\Resources\NombreDelRecursoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNombreDelRecursos extends ListRecords
{
    protected static string $resource = NombreDelRecursoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
