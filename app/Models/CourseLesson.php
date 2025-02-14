<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLesson extends Model
{
    use HasFactory;

    protected $fillable = ['course_module_id', 'course_id', 'title', 'content', 'order'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lesson) {
            $lesson->content = $lesson->content ?? []; // ✅ Убеждаемся, что `content` всегда массив
        });
    }

    public function module()
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id'); // ✅ Добавляем связь с курсом
    }

    protected $casts = [
        'content' => 'array', // 🔥 Преобразуем JSON в массив
    ];
}
