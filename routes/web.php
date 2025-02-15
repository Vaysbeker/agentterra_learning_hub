<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Filament\Resources\CourseModuleResource;
use Filament\Facades\Filament;
use App\Filament\Resources\CourseLessonResource\Pages\ViewCourseLesson;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/admin/course-lessons/{record}/view', [ViewCourseLesson::class, '__invoke'])
    ->name('filament.admin.resources.course-lessons.view');

Route::post('/lesson/{lessonId}/submit-test', [TestResultController::class, 'submitTest']);
