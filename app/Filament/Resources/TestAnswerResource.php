<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestAnswerResource\Pages;
use App\Models\TestAnswer;
use App\Models\TestQuestion;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;

class TestAnswerResource extends Resource {
    protected static ?string $model = TestAnswer::class;

    public static function form(Forms\Form $form): Forms\Form {
        return $form->schema([
            Forms\Components\Select::make('question_id')
                ->label('Вопрос')
                ->relationship('question', 'question') // ✅ Привязываем к вопросу
                ->required(),

            Forms\Components\TextInput::make('answer_text')
                ->label('Ответ')
                ->required(),

            Forms\Components\Toggle::make('is_correct')
                ->label('Правильный ответ'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question.question')->label('Вопрос'),
                Tables\Columns\TextColumn::make('answer_text')->label('Ответ'),
                Tables\Columns\BooleanColumn::make('is_correct')->label('Правильный?'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListTestAnswers::route('/'),
            'create' => Pages\CreateTestAnswer::route('/create'),
            'edit' => Pages\EditTestAnswer::route('/{record}/edit'),
        ];
    }
}
