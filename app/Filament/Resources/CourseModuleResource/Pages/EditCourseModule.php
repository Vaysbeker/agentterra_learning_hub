<?php

namespace App\Filament\Resources\CourseModuleResource\Pages;

use App\Filament\Resources\CourseModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseModule extends EditRecord
{
    protected static string $resource = CourseModuleResource::class;

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
                ->disabled(fn () => !$this->getForm()->isDirty()), // ✅ Проверка изменений
        ];
    }
}
