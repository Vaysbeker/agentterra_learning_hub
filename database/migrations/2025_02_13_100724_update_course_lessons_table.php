<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('course_lessons', function (Blueprint $table) {
            if (!Schema::hasColumn('course_lessons', 'course_module_id')) {
                $table->unsignedBigInteger('course_module_id')->after('id');
            }
            if (!Schema::hasColumn('course_lessons', 'content')) {
                $table->json('content')->nullable()->after('order');
            }
            if (!Schema::hasColumn('course_lessons', 'order')) {
                $table->integer('order')->after('title');
            }
        });
    }

    public function down(): void
    {
        Schema::table('course_lessons', function (Blueprint $table) {
            if (Schema::hasColumn('course_lessons', 'course_module_id')) {
                $table->dropColumn('course_module_id');
            }
            if (Schema::hasColumn('course_lessons', 'content')) {
                $table->dropColumn('content');
            }
            if (Schema::hasColumn('course_lessons', 'order')) {
                $table->dropColumn('order');
            }
        });
    }
};
