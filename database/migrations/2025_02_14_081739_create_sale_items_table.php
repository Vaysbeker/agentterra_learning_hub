<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id'); // Привязка к продажам
            $table->unsignedBigInteger('client_id'); // Клиент
            $table->unsignedBigInteger('course_id'); // Курс
            $table->unsignedBigInteger('course_batch_id')->nullable(); // Поток
            $table->decimal('price', 10, 2); // Цена продажи
            $table->timestamps();

            // Внешние ключи
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('course_batch_id')->references('id')->on('course_batches')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_items');
    }
};
