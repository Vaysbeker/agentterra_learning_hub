<?php

use Illuminate\Database\Eloquent\Model;
use App\Models\CourseLesson;

class TestResult extends Model
{
    protected $fillable = ['user_id', 'lesson_id', 'score', 'passed'];

    public function checkPass()
    {
        $totalQuestions = $this->lesson->test->questions()->count();
        $correctAnswers = $this->score;
        $passPercentage = ($correctAnswers / $totalQuestions) * 100;

        if ($passPercentage >= 80) {
            // Открываем следующий урок
            $nextLesson = CourseLesson::where('id', '>', $this->lesson_id)->orderBy('id')->first();
            if ($nextLesson) {
                $this->user->lessons()->attach($nextLesson->id);
            }
        }
    }
}
