<?php

namespace App\Filament\Resources\ReporteDiarioResource\Pages;

use App\Filament\Resources\ReporteDiarioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReporteDiario extends EditRecord
{
    protected static string $resource = ReporteDiarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
