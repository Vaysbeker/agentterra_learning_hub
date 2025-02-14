<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = ['sale_id', 'client_id', 'course_id', 'course_batch_id', 'price'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function courseBatch()
    {
        return $this->belongsTo(CourseBatch::class, 'course_batch_id');
    }
    protected static function booted()
    {
        static::created(function ($item) {
            $item->sale->updateTotalAmount(); // ✅ Обновляем сумму после создания позиции
        });

        static::updated(function ($item) {
            $item->sale->updateTotalAmount(); // ✅ Обновляем сумму после редактирования
        });

        static::deleted(function ($item) {
            $item->sale->updateTotalAmount(); // ✅ Обновляем сумму после удаления
        });
    }

}
