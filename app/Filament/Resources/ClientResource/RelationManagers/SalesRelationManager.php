<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use App\Models\Sale;

class SalesRelationManager extends RelationManager
{
    protected static string $relationship = 'sales';
    protected static ?string $title = 'Покупки';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('№№ покупки')->sortable(),
                Tables\Columns\TextColumn::make('sale_date')->label('Дата')->sortable()->date(),
                Tables\Columns\TextColumn::make('total_amount')->label('Сумма')->money('RUB')->sortable(),
                Tables\Columns\BadgeColumn::make('status')->label('Статус')
                    ->colors([
                        'waiting' => 'gray',
                        'paid' => 'green',
                        'canceled' => 'red',
                    ])
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }
}
