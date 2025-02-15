<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use App\Filament\Resources\TestResource\Pages;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestAnswer;
use App\Models\CourseLesson;

class TestResource extends Resource
{
    protected static ?string $navigationGroup = "Обучение"; // Убираем из меню
    protected static ?string $navigationParentItem = 'Курсы';

    protected static ?string $navigationLabel = 'Тесты к урокам';

    protected static ?int $navigationSort = null; // Убираем из панели навигации
    protected static bool $shouldRegisterNavigation = true; // Полностью скрываем
    protected static ?string $model = Test::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Select::make('lesson_id')
                ->label('Наименование урока')
                ->options(CourseLesson::pluck('title', 'id'))
                ->searchable()
                ->disabled()
                ->dehydrated(false),

            Repeater::make('questions')
                ->relationship('questions')
                ->label('Вопросы')
                ->maxItems(10)
                ->schema([
                    Section::make(fn ($state) => isset($state['question_preview']) ? "Вопрос: {$state['question_preview']}" : "Новый вопрос") // ✅ Обновляем заголовок без сброса курсора
                    ->collapsible()
                        ->schema([
                            TextInput::make('question')
                                ->label('Текст вопроса')
                                ->required()
                                ->afterStateUpdated(fn ($state, callable $set) => $set('question_preview', $state)), // ✅ Обновляем заголовок после ввода

                            Repeater::make('answers')
                                ->relationship('answers')
                                ->label('Ответы')
                                ->minItems(4)
                                ->maxItems(4)
                                ->schema([
                                    TextInput::make('answer_text')
                                        ->label('Ответ')
                                        ->required(),

                                    Checkbox::make('is_correct')
                                        ->label('Верный')
                                        ->inline(false),
                                ])
                        ]),
                ])
                ->createItemButtonLabel('Добавить вопрос'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('lesson.title')->label('Урок')->sortable(),
                TextColumn::make('questions_count')->label('Вопросов')->sortable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTests::route('/'),
            'create' => Pages\CreateTest::route('/create'),
            'edit' => Pages\EditTest::route('/{record}/edit'),
        ];
    }
}

