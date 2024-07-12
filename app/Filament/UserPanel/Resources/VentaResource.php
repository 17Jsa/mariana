<?php
namespace App\Filament\UserPanel\Resources;

use App\Filament\UserPanel\Resources\VentaResource\Pages;
use App\Models\Venta;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar Auth para obtener el ID del usuario autenticado



class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('fecha')
                    ->required(),
                Forms\Components\Repeater::make('detalles')
                    ->relationship('detalles') // Ensure the relationship name matches your model
                    ->schema([
                        Forms\Components\TextInput::make('codigo')
                            ->label('Código del Producto')
                            ->reactive()
                            ->required()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $producto = Producto::where('codigo', $state)->first();
                                if ($producto) {
                                    $set('producto_id', $producto->id);
                                    $set('nombre_producto', $producto->nombre);
                                    $set('precio_unitario', $producto->precio);
                                } else {
                                    $set('producto_id', null);
                                    $set('nombre_producto', null);
                                    $set('precio_unitario', null);
                                }
                            }),
                        Forms\Components\Hidden::make('producto_id')
                            ->label('Producto ID')
                            ->required(),
                        Forms\Components\TextInput::make('nombre_producto')
                            ->label('Nombre del Producto')
                            ->disabled(),
                        Forms\Components\TextInput::make('cantidad')
                            ->numeric()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set, callable $get) => $set('subtotal', $state * $get('precio_unitario'))),
                        Forms\Components\TextInput::make('precio_unitario')
                            ->numeric()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set, callable $get) => $set('subtotal', $state * $get('cantidad'))),
                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->disabled()
                            ->default(0),
                    ])
                    ->minItems(1)
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) => $set('total', array_reduce($get('detalles') ?? [], fn ($carry, $item) => $carry + ($item['subtotal'] ?? 0), 0))),
                Forms\Components\TextInput::make('total')
                    ->numeric()
                    ->disabled()
                    ->default(0)
                    ->required(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('created_at')
                ->date()
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('total')
                ->getStateUsing(fn (Venta $record) => $record->detalles->sum('subtotal'))
                ->searchable(),
            Tables\Columns\TextColumn::make('detalles.producto.nombre')
                ->label('Producto')
                ->searchable(),
            Tables\Columns\TextColumn::make('detalles.cantidad')
                ->label('Cantidad'),
            Tables\Columns\TextColumn::make('detalles.precio_unitario')
                ->label('Precio Unitario'),
            Tables\Columns\TextColumn::make('detalles.subtotal')
                ->label('Subtotal'),
        ])
        ->defaultSort('created_at', 'desc')
        ->filters([
            Tables\Filters\Filter::make('fecha')
                ->form([
                    Forms\Components\DatePicker::make('fecha'),
                ])
                ->query(function ($query, array $data) {
                    return $query->when($data['fecha'], fn ($query, $date) => $query->whereDate('created_at', $date));
                }),
    
            ])
            ->actions([
                EditAction::make(),
                Action::make('imprimir')
                    ->label('Imprimir')
                    ->icon('heroicon-o-printer')
                    ->action(function (Venta $record) {
                        $ventaId = $record->id;
                        $userId = Auth::id(); // Obtener el ID del usuario autenticado
                        return redirect()->route('recibos.imprimir', ['id' => $ventaId, 'id_user' => $userId]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function ($records) {
                        $records->each->forceDelete();
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVentas::route('/'),
            'create' => Pages\CreateVenta::route('/create'),
            'edit' => Pages\EditVenta::route('/{record}/edit'),
        ];
    }
}
