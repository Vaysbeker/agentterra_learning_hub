<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\TestQuestion;
use App\Models\TestAnswer;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function startTest($lessonId)
    {
        $test = Test::where('lesson_id', $lessonId)->first();
        if (!$test) {
            return response()->json(['message' => 'Тест не найден'], 404);
        }

        return response()->json($test->questions()->with('answers')->get());
    }

    public function submitTest(Request $request, $lessonId)
    {
        $test = Test::where('lesson_id', $lessonId)->first();
        if (!$test) {
            return response()->json(['message' => 'Тест не найден'], 404);
        }

        $correctAnswers = 0;
        foreach ($request->answers as $questionId => $answerId) {
            $answer = TestAnswer::where('id', $answerId)->where('is_correct', true)->exists();
            if ($answer) {
                $correctAnswers++;
            }
        }

        $passed = $correctAnswers >= 8;
        TestResult::create([
            'user_id' => Auth::id(),
            'lesson_id' => $lessonId,
            'score' => $correctAnswers,
            'passed' => $passed,
        ]);

        if ($passed) {
            return response()->json(['message' => 'Тест пройден! Открывается следующий урок.']);
        }

        return response()->json(['message' => 'Тест не пройден! Нужно 8 правильных ответов.']);
    }
}
