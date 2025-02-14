<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('course_batch_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_batch_id'); // Группа курса
            $table->unsignedBigInteger('client_id'); // Клиент
            $table->timestamps();

            $table->foreign('course_batch_id')->references('id')->on('course_batches')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_batch_clients');
    }
};
