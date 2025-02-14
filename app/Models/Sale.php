<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['sale_date', 'total_amount', 'status'];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function updateTotalAmount()
    {
        $total = $this->items()->sum('price'); // ✅ Считаем сумму всех позиций
        $this->update(['total_amount' => $total]); // ✅ Сохраняем сумму в БД
    }


}
