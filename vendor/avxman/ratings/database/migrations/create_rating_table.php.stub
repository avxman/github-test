<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingTable extends Migration
{

    /**
     * This variable is the table`s name
     *
     * @var string $name_table
     */
    protected string $name_table = 'rating';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable($this->name_table)) {
            Schema::create($this->name_table, function (Blueprint $table) {
                $table->id();
                $table->integer('model_id')->comment('ID строки указанной модели из поля model_class');
                $table->string('model_class')->comment('Модель класса на сайте');
                $table->boolean('enabled')->default(1)->comment('Вкл./Откл. рейтинг');
                $table->integer('rating')->default(0)->comment('Общая оценка');
                $table->integer('voted')->default(0)->comment('Количество пользователей проставленных оценку');
                $table->string('type')->default('like')->comment('Тип оценки');
            });
            Illuminate\Support\Facades\DB::statement("ALTER TABLE `" . $this->name_table ."` comment 'Таблица рейтингов'");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->name_table);
    }
}
