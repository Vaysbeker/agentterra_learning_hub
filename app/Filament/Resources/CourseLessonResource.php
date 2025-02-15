<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseLessonResource\Pages;
use App\Models\CourseLesson;
use App\Models\Course;
use App\Models\CourseModule;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use App\Models\Test;
use Filament\Notifications\Notification;


class CourseLessonResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $model = CourseLesson::class;
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('title')
                ->label('Наименование урока')
                ->required()
                ->maxLength(255)
                ->live()
                ->afterStateUpdated(fn (callable $set) => $set('hasChanges', true)), // ✅ Обновляем флаг изменений

            Repeater::make('content')
                ->label('Содержание')
                ->default([])
                ->schema([
                    Select::make('type')
                        ->label('Тип блока')
                        ->options([
                            'text' => 'Текст',
                            'video' => 'Видео',
                            'audio' => 'Аудио',
                            'file' => 'Файл',
                        ])
                        ->required(),

                    RichEditor::make('text')
                        ->label('Текст')
                        ->visible(fn ($get) => $get('type') === 'text')
                        ->live()
                        ->afterStateUpdated(fn (callable $set) => $set('hasChanges', true)), // ✅ Отмечаем, что были изменения

                    TextInput::make('video_url')
                        ->label('Ссылка на видео')
                        ->visible(fn ($get) => $get('type') === 'video')
                        ->live()
                        ->afterStateUpdated(fn (callable $set) => $set('hasChanges', true)),

                    FileUpload::make('video_file')
                        ->label('Загрузка видео')
                        ->directory('lesson_videos')
                        ->visible(fn ($get) => $get('type') === 'video')
                        ->live()
                        ->afterStateUpdated(fn (callable $set) => $set('hasChanges', true)),
                ])
                ->reorderable()
                ->collapsible()
                ->addable()
                ->deletable()
                ->afterStateUpdated(fn (callable $set) => $set('hasChanges', true)), // ✅ Изменения фиксируются при редактировании контента
        ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourseLessons::route('/'),
            'create' => Pages\CreateCourseLesson::route('/create'),
            'edit' => Pages\EditCourseLesson::route('/{record}/edit'),
            'view' => Pages\ViewCourseLesson::route('/{record}/view'), // ✅ Теперь маршрут зарегистрирован
        ];
    }


    public static function shouldRegisterNavigation(): bool
    {
        return false; // ✅ Отключает отображение Breadcrumbs
    }

    public static function table(Tables\Table $table): Tables\Table {
        return $table
            ->columns([
                TextColumn::make('id')->label('№')->sortable(),
                TextColumn::make('course.title')->label('Курс')->sortable()->searchable(),
                TextColumn::make('module.title')->label('Модуль')->sortable()->searchable(),
                TextColumn::make('title')->label('Название урока')->sortable()->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                // ✅ Кнопка "Создать тест" или "Редактировать тест"
                Action::make('manage_test')
                    ->label(fn ($record) => $record->test ? 'Редактировать тест' : 'Создать тест')
                    ->icon(fn ($record) => $record->test ? 'heroicon-o-pencil' : 'heroicon-o-document-text')
                    ->action(function ($record) {
                        if (!$record->test) {
                            $test = Test::create(['lesson_id' => $record->id]);

                            Notification::make()
                                ->title('Тест создан!')
                                ->success()
                                ->send();

                            return redirect()->to(TestResource::getUrl('edit', ['record' => $test->id]));
                        } else {
                            return redirect()->to(TestResource::getUrl('edit', ['record' => $record->test->id]));
                        }
                    })
                    ->color(fn ($record) => $record->test ? 'primary' : 'success'),
            ]);
    }


    public static function getRelations(): array
    {
        return [];
    }

}
