<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\HasMany;



class CourseModule extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($model) {
            Log::info('Создаётся модуль:', $model->toArray());
        });
    }

    protected $fillable = ['course_id', 'title', 'order'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function lessons()
    {
        return $this->hasMany(CourseLesson::class, 'course_module_id');
    }

}

