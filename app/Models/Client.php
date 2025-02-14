<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'password'];

    protected $hidden = ['password'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'sale_items', 'client_id', 'course_id')
            ->withPivot(['course_batch_id']); // ✅ Добавляем связь с потоками
    }

    public function courseBatches()
    {
        return $this->hasManyThrough(CourseBatch::class, SaleItem::class, 'client_id', 'id', 'id', 'course_batch_id');
    }



}
