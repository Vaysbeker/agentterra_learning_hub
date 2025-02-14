<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title', 'order'];

    public function modules()
    {
        return $this->hasMany(CourseModule::class)->orderBy('order', 'asc');
    }
    public function course()
    {
        return $this->hasOneThrough(Course::class, CourseModule::class, 'id', 'id', 'course_module_id', 'course_id');
    }
}
