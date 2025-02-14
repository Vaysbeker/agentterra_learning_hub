<?php

namespace App\Filament\Resources\SaleResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Forms;
use App\Models\SaleItem;
use App\Models\Client;
use App\Models\Course;
use App\Models\CourseBatch;

class SaleItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items'; // ✅ Привязываем позиции к `Sale`
    protected static ?string $title = 'Позиции продажи';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('client.name')
                    ->label('ФИО клиента')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('course.title')
                    ->label('Курс')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('courseBatch.name') // ✅ Исправлено! `course_batch_id` → `courseBatch.name`
                ->label('Поток курса')
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->sortable()
                    ->money('RUB'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Добавить позицию')
                    ->form([
                        Forms\Components\Select::make('client_id')
                            ->label('Клиент')
                            ->options(Client::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('course_id')
                            ->label('Курс')
                            ->options(Course::pluck('title', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) =>
                            $set('course_batch_id', null) // ✅ Сбрасываем поток при смене курса
                            ),

                        Forms\Components\Select::make('course_batch_id')
                            ->label('Поток')
                            ->options(fn (callable $get) =>
                            CourseBatch::where('course_id', $get('course_id'))->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->placeholder('Выберите поток')
                            ->required(),

                        Forms\Components\TextInput::make('price')
                            ->label('Цена')
                            ->numeric()
                            ->required(),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Редактировать')
                    ->form([
                        Forms\Components\Select::make('client_id')
                            ->label('Клиент')
                            ->options(Client::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('course_id')
                            ->label('Курс')
                            ->options(Course::pluck('title', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) =>
                            $set('course_batch_id', null) // ✅ Сбрасываем поток при смене курса
                            ),

                        Forms\Components\Select::make('course_batch_id')
                            ->label('Поток')
                            ->options(fn (callable $get) =>
                            CourseBatch::where('course_id', $get('course_id'))->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->placeholder('Выберите поток')
                            ->required(),

                        Forms\Components\TextInput::make('price')
                            ->label('Цена')
                            ->numeric()
                            ->required(),
                    ])
                    ->after(fn ($record) => $record->sale->updateTotalAmount()), // ✅ Обновляем сумму после редактирования


                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
