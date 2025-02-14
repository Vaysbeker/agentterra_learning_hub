<?php

namespace App\Filament\Resources\CourseLessonResource\Pages;

use App\Filament\Resources\CourseLessonResource;
use App\Models\CourseLesson;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCourseLesson extends CreateRecord
{
    protected static string $resource = CourseLessonResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Получаем course_module_id из запроса или устанавливаем значение по умолчанию
        $data['course_module_id'] = request()->query('course_module') ?? $data['course_module_id'] ?? 1; // ✅ Убедимся, что поле не NULL

        return CourseLesson::create($data);
    }

    protected function getRedirectUrl(): string
    {
        return CourseLessonResource::getUrl('edit', ['record' => $this->record->id]); // ✅ После создания редирект на страницу редактирования
    }
}
