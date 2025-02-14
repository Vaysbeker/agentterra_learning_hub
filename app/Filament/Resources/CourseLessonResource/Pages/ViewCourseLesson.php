<?php

namespace App\Filament\Resources\CourseLessonResource\Pages;

use App\Filament\Resources\CourseLessonResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use Filament\Actions;

class ViewCourseLesson extends ViewRecord
{
    protected static string $resource = CourseLessonResource::class;
    protected static string $view = 'filament.pages.view-course-lesson';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Назад')
                ->url(fn () => CourseLessonResource::getUrl('index'))
                ->icon('heroicon-o-arrow-left'), // ✅ Кнопка "Назад"
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make($this->record->title) // ✅ Заголовок урока в шапке
            ->schema(
                collect($this->record->content)->map(fn ($block) => match ($block['type']) {
                    'text' => TextColumn::make('content')->label('')->html()->state($block['text']),
                    'video' => TextColumn::make('content')->label('')->html()->state("<iframe width='560' height='315' src='{$block['video_url']}'></iframe>"),
                    'audio' => TextColumn::make('content')->label('')->html()->state("<audio controls><source src='{$block['audio_url']}' type='audio/mpeg'></audio>"),
                    'file' => TextColumn::make('content')->label('')->html()->state("<a href='{$block['file_url']}' target='_blank'>Скачать файл</a>"),
                    default => TextColumn::make('content')->label('Неизвестный блок'),
                })->toArray()
            ),
        ];
    }
    public function getHeading(): string
    {
        return ($this->record?->module?->course?->title ?? 'Без курса') . ' / ' .
            ($this->record?->module?->title ?? 'Без модуля') . ' / ' .
            ($this->record?->title ?? 'Без названия');
    }

}
