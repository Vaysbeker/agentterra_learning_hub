<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model {
    use HasFactory;

    protected $fillable = ['lesson_id'];


    public function test() {
        return $this->hasOne(Test::class, 'lesson_id');
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(CourseLesson::class, 'lesson_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(TestQuestion::class, 'test_id');
    }


}
