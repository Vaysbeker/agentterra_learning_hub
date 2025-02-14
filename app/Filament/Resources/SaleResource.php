<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\RelationManagers\SaleItemsRelationManager;
use App\Filament\Resources\SaleResource\Pages;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Models\Sale;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('№№ продажи')->sortable(),
                Tables\Columns\TextColumn::make('sale_date')->label('Дата продажи')->sortable(),
                Tables\Columns\TextColumn::make('total_amount')->label('Сумма продажи')->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\CreateAction::make()
                    ->url(fn () => self::getUrl('create')) // ✅ Открывает новую страницу
                    ->modal(false), // ✅ Отключаем модальное окно
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            SaleItemsRelationManager::class, // ✅ Подключаем менеджер отношений
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'), // ✅ Добавляем маршрут для создания
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
