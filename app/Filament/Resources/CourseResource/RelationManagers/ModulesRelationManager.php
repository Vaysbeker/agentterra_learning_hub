<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use App\Models\CourseModule;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\CreateAction;

class ModulesRelationManager extends RelationManager
{
    protected static string $relationship = 'modules'; // 🔥 Должно совпадать с методом в модели Course
    protected static ?string $title = 'Модули курса';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('title')->label('Название модуля')->required(),
            TextInput::make('order')->label('Порядок')->numeric(),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Название модуля')->sortable(),
                TextColumn::make('order')->label('Порядок')->sortable(),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make()->label('Добавить модуль'),
            ])
            ->actions([
                EditAction::make()->label('Редактировать'),
                DeleteAction::make()->label('Удалить'),
            ]);
    }
}
