<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id'); // Клиент, совершивший покупку
            $table->unsignedBigInteger('course_id'); // Купленный курс
            $table->decimal('amount', 10, 2); // Сумма сделки
            $table->date('sale_date'); // Дата продажи
            $table->timestamps();

            // Внешние ключи
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
};

