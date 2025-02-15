<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('course_lessons')->onDelete('cascade'); // 👈 Привязываем к уроку!
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tests');
    }
};

