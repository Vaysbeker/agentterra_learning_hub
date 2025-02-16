<?php

use App\Http\Controllers\TestResultController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Filament\Resources\CourseLessonResource\Pages\ViewCourseLesson;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\InstallerController;



Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/admin/course-lessons/{record}/view', [ViewCourseLesson::class, '__invoke'])
    ->name('filament.admin.resources.course-lessons.view');

Route::post('/lesson/{lessonId}/submit-test', [TestResultController::class, 'submitTest']);

// ✅ Правильная регистрация маршрутов для клиента
Route::prefix('client')->middleware(['auth'])->group(function () {
    Route::get('/{any}', function () {
        return view('client');
    })->where('any', '.*');
});

// Авторизация клиента
Route::prefix('client')->group(function () {
    Route::get('/login', [ClientAuthController::class, 'showLoginForm'])->name('client.login');
    Route::post('/login', [ClientAuthController::class, 'login']);
    Route::post('/logout', [ClientAuthController::class, 'logout'])->name('client.logout');
});

// Панель клиента (доступна только авторизованным пользователям)
Route::middleware(['auth:client'])->group(function () {
    Route::get('/client/dashboard', function () {
        return view('client.dashboard');
    })->name('client.dashboard');

    Route::middleware(['auth'])->group(function () {
        Route::get('/client/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    });

});

Route::middleware('guest')->group(function () {
    Route::get('/client/login', [ClientAuthController::class, 'showLoginForm'])->name('client.login');
    Route::post('/client/login', [ClientAuthController::class, 'login']);
});

Route::get('/install', [InstallerController::class, 'index'])->name('install.index');
Route::get('/install/step2', [InstallerController::class, 'step2'])->name('install.step2');
Route::post('/install', [InstallerController::class, 'install'])->name('install.process');
