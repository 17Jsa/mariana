<?php

namespace App\Filament\Resources\NombreDelRecursoResource\Pages;

use App\Filament\Resources\NombreDelRecursoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNombreDelRecurso extends EditRecord
{
    protected static string $resource = NombreDelRecursoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
