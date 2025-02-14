<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseBatch extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'name', 'start_date', 'end_date']; // ✅ Добавили `course_id`

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'course_batch_clients');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
