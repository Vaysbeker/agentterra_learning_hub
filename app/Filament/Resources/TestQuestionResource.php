<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestQuestionResource\Pages;
use App\Models\TestQuestion;
use App\Models\Test;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;

class TestQuestionResource extends Resource {
    protected static ?string $model = TestQuestion::class;

    public static function form(Forms\Form $form): Forms\Form {
        return $form->schema([
            Forms\Components\Select::make('test_id')
                ->label('Тест')
                ->relationship('test', 'lesson.title') // ✅ Привязываем к уроку!
                ->required(),

            Forms\Components\Textarea::make('question')
                ->label('Текст вопроса')
                ->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('test.lesson.title')->label('Урок'),
                Tables\Columns\TextColumn::make('question')->label('Вопрос'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListTestQuestions::route('/'),
            'create' => Pages\CreateTestQuestion::route('/create'),
            'edit' => Pages\EditTestQuestion::route('/{record}/edit'),
        ];
    }
}
