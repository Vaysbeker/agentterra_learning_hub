<?php

namespace App\Filament\Resources\CourseModuleResource\Pages;

use App\Filament\Resources\CourseModuleResource;
use App\Models\CourseModule; // ✅ Добавляем этот импорт!
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Filament\Resources\Pages\CreateRecord; // ✅ Добавляем этот импорт


class CreateCourseModule extends CreateRecord
{
    protected static string $resource = CourseModuleResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        try {
            Log::info('Попытка создания модуля:', $data);

            $module = CourseModule::create($data);

            Notification::make()
                ->title('Модуль успешно создан!')
                ->success()
                ->send();

            return $module;
        } catch (\Exception $e) {
            Log::error('Ошибка при создании модуля:', ['message' => $e->getMessage()]);

            Notification::make()
                ->title('Ошибка при создании модуля!')
                ->body($e->getMessage())
                ->danger()
                ->send();

            // Явно пробрасываем ошибку, чтобы Filament её показал
            throw ValidationException::withMessages([
                'title' => 'Ошибка: ' . $e->getMessage(),
            ]);
        }
    }

    public function getBreadcrumb(): string
    {
        $moduleId = request()->query('course_module');
        $module = CourseModule::find($moduleId);

        if ($module && $module->course) {
            return "Курсы / {$module->course->title} / {$module->title} / Новый урок";
        }

        return "Новый урок";
    }

    public function getTitle(): string
    {
        return $this->getBreadcrumb();
    }
}
