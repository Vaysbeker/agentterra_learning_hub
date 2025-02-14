<?php

namespace App\Filament\Resources;

use App\Models\CourseBatch;
use App\Filament\Resources\CourseBatchResource\Pages;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use App\Models\Course;

class CourseBatchResource extends Resource
{
    protected static ?string $model = CourseBatch::class;
    protected static ?string $navigationLabel = 'Группы доступа';
    protected static ?string $navigationGroup = 'Обучение';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Select::make('course_id')
                ->label('Курс')
                ->options(Course::pluck('title', 'id'))
                ->searchable()
                ->required(),

            TextInput::make('name')
                ->label('Название группы')
                ->required(),

            DatePicker::make('start_date')
                ->label('Дата начала')
                ->required(),

            DatePicker::make('end_date')
                ->label('Дата окончания'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('course.title')->label('Курс')->searchable(),
                TextColumn::make('name')->label('Группа')->sortable(),
                TextColumn::make('start_date')->label('Начало')->sortable(),
                TextColumn::make('end_date')->label('Окончание')->sortable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourseBatches::route('/'),
            'create' => Pages\CreateCourseBatch::route('/create'),
            'edit' => Pages\EditCourseBatch::route('/{record}/edit'),
        ];
    }
}
