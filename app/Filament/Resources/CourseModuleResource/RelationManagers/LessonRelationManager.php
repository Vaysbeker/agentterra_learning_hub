<?php

namespace App\Filament\Resources\CourseModuleResource\RelationManagers;


use Filament\Forms\Form; // ✅ Правильный импорт
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;
use App\Models\Course;
use App\Models\CourseModule;

class LessonRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';
    protected static ?string $title = 'Уроки';

    public function form(Form $form): Form // ✅ Теперь правильный тип
    {
        $module = $this->getOwnerRecord();
        $course = Course::find($module->course_id);

        return $form->schema([
            Hidden::make('course_module_id')
                ->default(fn () => $module->id)
                ->dehydrated()
                ->required(),

            TextInput::make('title')
                ->label('Наименование')
                ->required()
                ->maxLength(255)
                ->live()
                ->afterStateUpdated(fn (callable $set) => $set('hasChanges', true)),

            Section::make('Контент урока')
                ->description('Добавляйте текст, видео, аудио или файлы')
                ->collapsible()
                ->schema([
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
                                ->hidden(fn ($state) => $state['type'] !== 'text'),

                            TextInput::make('video_url')
                                ->label('Ссылка на видео')
                                ->hidden(fn ($state) => $state['type'] !== 'video'),

                            FileUpload::make('video_file')
                                ->label('Загрузка видео')
                                ->directory('lesson_videos')
                                ->hidden(fn ($state) => $state['type'] !== 'video'),

                            TextInput::make('audio_url')
                                ->label('Ссылка на аудио')
                                ->hidden(fn ($state) => $state['type'] !== 'audio'),

                            FileUpload::make('audio_file')
                                ->label('Загрузка аудио')
                                ->directory('lesson_audios')
                                ->hidden(fn ($state) => $state['type'] !== 'audio'),

                            TextInput::make('file_url')
                                ->label('Ссылка на файл')
                                ->hidden(fn ($state) => $state['type'] !== 'file'),

                            FileUpload::make('file_upload')
                                ->label('Загрузка файла')
                                ->directory('lesson_files')
                                ->hidden(fn ($state) => $state['type'] !== 'file'),
                        ])
                        ->reorderable()
                        ->collapsible()
                        ->addable()
                        ->deletable(),
                ]),
        ]);
    }
    public function table(Table $table): Table // ✅ Используем правильный импорт
    {
        return $table->columns([
            TextColumn::make('id')->label('№№')->sortable(),
            TextColumn::make('title')->label('Наименование')->sortable(),
            TextColumn::make('created_at')->label('Дата создания')->sortable(),
        ])
            ->reorderable('order')
            ->actions([
                ViewAction::make()->label('Просмотр'),
                EditAction::make()->label('Редактировать'),
                DeleteAction::make()->label('Удалить'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Добавить урок')
                    ->url(fn () => CourseLessonResource::getUrl('create', ['course_module' => $this->getOwnerRecord()->id])), // ✅ Передаём `course_module_id`
            ]);
    }




}
