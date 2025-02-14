<?php

namespace App\Filament\Resources\CourseModuleResource\Pages;

use Filament\Actions\Action; // ✅ Используем таблицы
use App\Filament\Resources\CourseResource;
use App\Filament\Resources\CourseModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Course;


class ListCourseModules extends ListRecords
{
    protected static string $resource = CourseModuleResource::class;



    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Назад')
                ->url(CourseResource::getUrl('index')) // ✅ Возвращаем к списку курсов
                ->icon('heroicon-o-arrow-left')
                ->color('primary'),

            Action::make('create')
                ->label('Создать')
                ->url(CourseModuleResource::getUrl('create', ['course' => request()->query('course')])) // ✅ Открывает форму создания
                ->action('create')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getSubheading(): ?string
    {
        $courseId = request()->query('course');
        $course = Course::find($courseId);

        return $course ? "Курс: {$course->title}" : "Выберите курс";
    }
}
