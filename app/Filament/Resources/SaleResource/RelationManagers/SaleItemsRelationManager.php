<?php
namespace App\Filament\Resources\SaleResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use App\Models\SaleItem;
use App\Models\Client;
use App\Models\Course;
use App\Models\CourseBatch;

class SaleItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items'; // ✅ Связь с `SaleItem`
    protected static ?string $title = 'Детали продажи';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\SelectColumn::make('client_id')
                    ->label('ФИО клиента')
                    ->options(Client::pluck('name', 'id'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\SelectColumn::make('course_id')
                    ->label('Курс')
                    ->options(Course::pluck('title', 'id'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\SelectColumn::make('course_batch_id')
                    ->label('Поток / Без потока')
                    ->options(fn () => CourseBatch::pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Без потока'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->sortable(),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Добавить позицию'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
