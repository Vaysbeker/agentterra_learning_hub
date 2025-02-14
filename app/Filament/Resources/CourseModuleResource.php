<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseModuleResource\Pages;
use App\Filament\Resources\CourseModuleResource\RelationManagers;
use App\Models\CourseModule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;



class CourseModuleResource extends Resource
{
    protected static ?string $model = CourseModule::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Модуль';
    protected static ?string $pluralLabel = 'Модули';
    protected static ?string $navigationLabel = 'Модули';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Hidden::make('course_id')
                ->default(fn () => request()->query('course'))
                ->required(),

            Forms\Components\TextInput::make('title')
                ->label('Название модуля')
                ->required(),

            Forms\Components\TextInput::make('order')
                ->label('Порядок')
                ->numeric(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('№№')
                    ->sortable()
                    ->searchable()
                    ->columnSpan(1), // ✅ 1/12

                TextColumn::make('title')
                    ->label('Название')
                    ->sortable()
                    ->searchable()
                    ->columnSpan(7), // ✅ 7/12

                TextColumn::make('lessons_count')
                    ->label('Кол-во уроков')
                    ->sortable()
                    ->columnSpan(1) // ✅ 1/12
                    ->counts('lessons'), // ✅ Подсчитываем количество уроков

            ])
            ->actions([
                EditAction::make()
                    ->label('Редактировать'),

                Action::make('content')
                    ->label('Содержание')
                    ->url(fn ($record) => route('filament.admin.resources.course-lessons.index', ['module' => $record->id])),


                DeleteAction::make()
                    ->label('Удалить'),
            ])
            ->bulkActions([]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false; // ✅ Отключает отображение Breadcrumbs
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\LessonRelationManager::class, // ✅ Должно быть здесь
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourseModules::route('/'),
            'create' => Pages\CreateCourseModule::route('/create'),
            'edit' => Pages\EditCourseModule::route('/{record}/edit'),
        ];
    }
}
