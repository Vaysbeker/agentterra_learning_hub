<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers\SaleItemsRelationManager;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use App\Models\Sale;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;
    protected static ?string $navigationLabel = 'Продажи';
    protected static ?string $navigationGroup = 'Продажи и финансы';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('id')
                ->label('№№ продажи')
                ->disabled(), // ✅ Поле заблокировано для редактирования

            Forms\Components\DatePicker::make('sale_date')
                ->label('Дата продажи')
                ->default(now())
                ->required(),

            Forms\Components\TextInput::make('total_amount')
                ->label('ИТОГО')
                ->disabled() // ✅ Запрещаем редактировать вручную
                ->numeric()
                ->default(fn ($record) => $record?->total_amount ?? 0), // ✅ Загружаем из БД

            Forms\Components\Select::make('status')
                ->label('Статус')
                ->options([
                    'waiting' => 'Ожидание',
                    'paid' => 'Оплачено',
                    'canceled' => 'Отменено',
                ])
                ->default('waiting')
                ->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('№№ продажи')
                    ->sortable()
                    ->disableClick(),

                Tables\Columns\TextColumn::make('sale_date')
                    ->label('Дата продажи')
                    ->sortable()
                    ->date(),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Сумма')
                    ->sortable()
                    ->money('RUB'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Статус')
                    ->colors([
                        'waiting' => 'gray',
                        'paid' => 'green',
                        'canceled' => 'red',
                    ])
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Посмотреть'),
                Tables\Actions\EditAction::make()->label('Редактировать'),
                Tables\Actions\DeleteAction::make()->label('Удалить'),
            ])
            ->recordUrl(null);
    }

    public static function getRelations(): array
    {
        return [
            SaleItemsRelationManager::class, // ✅ Позиции добавляются только через RelationManager
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
