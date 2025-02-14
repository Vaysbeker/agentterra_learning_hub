<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Удаляем внешний ключ для course_id
            if (Schema::hasColumn('sales', 'course_id')) {
                $table->dropForeign('sales_course_id_foreign'); // ✅ Удаляем `foreign key`
                $table->dropColumn('course_id'); // ✅ Удаляем колонку
            }

            // Удаляем другие ненужные колонки, если они существуют
            if (Schema::hasColumn('sales', 'client_id')) {
                $table->dropColumn('client_id');
            }

            if (Schema::hasColumn('sales', 'course_batch_id')) {
                $table->dropColumn('course_batch_id');
            }

            if (Schema::hasColumn('sales', 'price')) {
                $table->dropColumn('price');
            }
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('course_batch_id')->nullable();
            $table->decimal('price', 10, 2)->nullable();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null'); // ✅ Восстанавливаем `foreign key`
        });
    }
};


