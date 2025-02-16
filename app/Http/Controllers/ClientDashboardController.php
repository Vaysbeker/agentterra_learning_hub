<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use App\Models\Lesson;
use App\Models\Module;

class ClientDashboardController extends Controller
{
    /**
     * Отображение клиентского дашборда.
     */
    public function index()
    {
        $user = Auth::user();

        // Получаем доступные курсы для пользователя
        $courses = Course::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['modules.lessons'])->get();

        return view('client.dashboard', compact('user', 'courses'));
    }

    /**
     * Отображение детальной информации о курсе.
     */
    public function showCourse($courseId)
    {
        $user = Auth::user();

        $course = Course::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['modules.lessons'])->findOrFail($courseId);

        return view('client.course_detail', compact('user', 'course'));
    }

    /**
     * Отображение урока.
     */
    public function showLesson($lessonId)
    {
        $user = Auth::user();

        $lesson = Lesson::whereHas('module.course.users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->findOrFail($lessonId);

        return view('client.lesson_detail', compact('user', 'lesson'));
    }
}
