<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('course_lessons', function (Blueprint $table) {
            $table->dropForeign(['module_id']); // Удаляем внешний ключ
            $table->dropColumn('module_id'); // Удаляем колонку module_id
        });
    }

    public function down()
    {
        Schema::table('course_lessons', function (Blueprint $table) {
            $table->foreignId('module_id')->nullable()->constrained()->onDelete('cascade'); // Восстанавливаем поле
        });
    }
};
