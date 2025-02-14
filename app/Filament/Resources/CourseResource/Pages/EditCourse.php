<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseModuleResource;
use App\Filament\Resources\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourse extends EditRecord
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Назад')
                ->url(fn () => CourseModuleResource::getUrl('index'))
                ->icon('heroicon-o-arrow-left'), // ✅ Кнопка "Назад"

            Actions\Action::make('save')
                ->label('Сохранить')
                ->submit('save')
                ->icon('heroicon-o-check')
        ];
    }
}
