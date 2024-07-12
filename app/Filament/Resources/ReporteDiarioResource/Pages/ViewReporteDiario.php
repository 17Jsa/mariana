<?php

namespace App\Filament\Resources\ReporteDiarioResource\Pages;

use App\Filament\Resources\ReporteDiarioResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReporteDiario extends ViewRecord
{
    protected static string $resource = ReporteDiarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
