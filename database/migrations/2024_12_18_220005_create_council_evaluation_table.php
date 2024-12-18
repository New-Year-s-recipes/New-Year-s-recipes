<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('council_evaluation', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор
            $table->foreignId('users_id')->constrained()->onDelete('cascade'); // Внешний ключ
            $table->integer('rating'); // Оценка
            $table->foreignId('tips_id')->constrained()->onDelete('cascade'); // Внешний ключ
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('council_evaluation');
    }
};
