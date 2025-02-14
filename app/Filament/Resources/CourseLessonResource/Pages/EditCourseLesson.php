<?php

namespace App\Filament\Resources\CourseLessonResource\Pages;

use App\Filament\Resources\CourseLessonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseLesson extends EditRecord
{
    protected static string $resource = CourseLessonResource::class;

    protected function getFormActions(): array
    {

        return [
            Actions\Action::make('back')
                ->label('Назад')
                ->url(fn () => CourseLessonResource::getUrl('index'))
                ->icon('heroicon-o-arrow-left'), // ✅ Кнопка "Назад"

            Actions\Action::make('save')
                ->label('Сохранить')
                ->submit('save')
                ->icon('heroicon-o-check'),


            Actions\Action::make('add_block')
                ->label('Добавить блок')
                ->action('addBlock') // ✅ Кнопка "Добавить блок"
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getHeading(): string
    {
        return ($this->record?->module?->course?->title ?? 'Без курса') . ' / ' .
            ($this->record?->module?->title ?? 'Без модуля') . ' / ' .
            ($this->record?->title ?? 'Без названия');
    }
}
