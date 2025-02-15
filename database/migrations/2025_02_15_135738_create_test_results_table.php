<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('course_lessons')->onDelete('cascade');
            $table->integer('score');
            $table->boolean('passed');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('test_results');
    }
};
