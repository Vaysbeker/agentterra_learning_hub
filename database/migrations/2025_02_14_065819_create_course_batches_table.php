<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('course_batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id'); // Курс
            $table->string('name'); // Название потока (например, "Поток Январь 2025")
            $table->date('start_date'); // Дата старта группы
            $table->date('end_date')->nullable(); // Дата завершения (необязательно)
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_batches');
    }
};
