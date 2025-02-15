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
    protected static ?string $navigationGroup = 'Обучение';
    protected static ?string $navigationLabel = 'Поток курсов';
    protected static ?string $navigationParentItem = 'Курсы';

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
            ->query(fn () => CourseBatch::query()->when(request()->has('course_id'), function ($query) {
                $query->where('course_id', request('course_id'));
            }))
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('course.title')->label('Курс')->searchable(),
                Tables\Columns\TextColumn::make('name')->label('Группа')->sortable(),
                Tables\Columns\TextColumn::make('start_date')->label('Начало')->sortable(),
                Tables\Columns\TextColumn::make('end_date')->label('Окончание')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
    protected function getHeaderActions(): array
    {
        return request()->has('course_id')
            ? [
                Tables\Actions\Action::make('back')
                    ->label('Назад к курсам')
                    ->url(fn () => CourseResource::getUrl('index'))
                    ->icon('heroicon-o-arrow-left'),
            ]
            : [];
    }

}
