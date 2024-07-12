<?php

// app/Filament/Resources/ReporteDiarioResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\ReporteDiarioResource\Pages;
use App\Filament\Resources\ReporteDiarioResource\RelationManagers;
use App\Models\ReporteDiario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReporteDiarioResource extends Resource
{
    protected static ?string $model = ReporteDiario::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Producto')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cantidad_inicial')
                    ->label('Cantidad Inicial')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cantidad_vendida')
                    ->label('Cantidad Vendida')
                    ->sortable(),
               
                Tables\Columns\TextColumn::make('cantidad_final')
                    ->label('Cantidad Final')
                    ->sortable(),
                    Tables\Columns\TextColumn::make('total_vendido')
                    ->label('Total Vendido')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                 
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReporteDiarios::route('/'),
            'create' => Pages\CreateReporteDiario::route('/create'),
            'view' => Pages\ViewReporteDiario::route('/{record}'),
            'edit' => Pages\EditReporteDiario::route('/{record}/edit'),
        ];
    }
}
