<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestResult;
use Illuminate\Support\Facades\Auth;


class TestResultController extends Controller {
    public function submitTest(Request $request, $lessonId) {
        $user = Auth::user();
        $score = collect($request->answers)->sum(fn ($answer) => $answer['is_correct'] ? 1 : 0);
        $passed = $score >= 8;

        TestResult::create([
            'user_id' => $user->id,
            'lesson_id' => $lessonId,
            'score' => $score,
            'passed' => $passed,
        ]);

        return response()->json(['message' => $passed ? 'Тест пройден!' : 'Попробуйте снова', 'score' => $score]);
    }

    public function store(Request $request)
    {
        $result = TestResult::create([
            'user_id' => auth()->id(),
            'lesson_id' => $request->lesson_id,
            'score' => $request->score,
            'passed' => $request->score >= 8, // Если 8/10 — тест пройден
        ]);

        $result->checkPass(); // ✅ Проверяем, откроется ли следующий урок

        return response()->json(['message' => 'Результат сохранён']);
    }

}
