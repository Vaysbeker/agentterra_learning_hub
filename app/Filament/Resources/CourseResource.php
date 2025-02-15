<?php

namespace App\Filament\Resources;


use App\Models\Course;
use App\Filament\Resources\CourseResource\Pages;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Query\Builder;




class CourseResource extends Resource
{
    protected static ?string $navigationLabel = 'Курсы';
    protected static ?string $model = Course::class;
    protected static ?string $navigationGroup = 'Обучение';

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('title')
                ->label('Название курса')
                ->required()
                ->live(), // ✅ Отслеживает изменения в форме

            Textarea::make('description')
                ->label('Описание курса')
                ->live(),

            TextInput::make('price')
                ->label('Цена')
                ->numeric()
                ->live(),
        ]);
    }


    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Название курса')->sortable()->searchable(),
                TextColumn::make('order')->label('Порядок')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Редактировать')
                    ->modalHeading('Редактирование курса'),

                Action::make('Содержание')
                    ->label('Содержание')
                    ->url(fn ($record) => CourseModuleResource::getUrl('index', ['course' => $record->id]))
                    ->openUrlInNewTab(false),

                Action::make('Потоки')
                    ->label('Потоки')
                    ->url(fn ($record) => CourseBatchResource::getUrl('index', ['course_id' => $record->id]))
                    ->openUrlInNewTab(false),
            ]);
    }


    public static function canViewAny(): bool
    {
        return auth()->user()->can('edit_courses');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('edit_courses');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit_courses');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('edit_courses');
    }



    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
