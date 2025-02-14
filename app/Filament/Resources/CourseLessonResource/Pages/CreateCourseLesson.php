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
        $data['course_module_id'] = request()->query('course_module');

        $lesson = CourseLesson::create($data);

        return $lesson;
    }

    protected function getRedirectUrl(): string
    {
        return CourseLessonResource::getUrl('edit', ['record' => $this->record->id]); // ✅ После создания редирект на страницу редактирования
    }
}
