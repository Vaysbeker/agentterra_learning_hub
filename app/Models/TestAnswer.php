<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestAnswer extends Model {
    use HasFactory;

    protected $fillable = ['question_id', 'answer_text', 'is_correct'];

    public function question() {
        return $this->belongsTo(TestQuestion::class, 'question_id');
    }

}
