<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('course_lessons', function (Blueprint $table) {
            // ✅ Удаляем внешний ключ перед удалением колонки
            $table->dropForeign('course_lessons_ibfk_1');

            // ✅ Теперь можно удалить колонку
            $table->dropColumn('module_id');
        });
    }

    public function down(): void
    {
        Schema::table('course_lessons', function (Blueprint $table) {
            $table->foreignId('module_id')->nullable()->constrained('course_modules')->cascadeOnDelete();
        });
    }
};
