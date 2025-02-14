<?php

namespace App\Filament\Resources\CourseModuleResource\Pages;

use App\Filament\Resources\CourseLessonResource;
use App\Filament\Resources\CourseModuleResource;
use App\Models\CourseLesson;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseModule extends EditRecord
{
    protected static string $resource = CourseLessonResource::class;

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
                ->icon('heroicon-o-arrow-left'),

            Actions\Action::make('save')
                ->label('Сохранить')
                ->submit('save')
                ->icon('heroicon-o-check')

        ];
    }

    public function getBreadcrumb(): string
    {
        $lesson = CourseLesson::find($this->record->id);

        if ($lesson && $lesson->module && $lesson->module->course) {
            return "Курсы / {$lesson->module->course->title} / {$lesson->module->title} / {$lesson->title}";
        }

        return "Редактирование урока";
    }

    public function getTitle(): string
    {
        return $this->getBreadcrumb();
    }
}
