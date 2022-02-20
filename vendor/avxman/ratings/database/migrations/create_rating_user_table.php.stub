<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingUserTable extends Migration
{

    /**
     * This variable is the table`s name
     *
     * @var string $name_table
     */
    protected string $name_table = 'rating_user';

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
                $table->bigInteger('rating_id')->unsigned()->index()->comment('ID рейтинга таблицы rating');
                $table->bigInteger('user_id')->nullable()->unsigned()->index()->comment('Оценку сделал зарегистрированный пользователь');
                $table->smallInteger('status')->comment('Проставлена оценка 0 или 999');
                $table->string('browser')->comment('Кто поставил оценку');
                $table->timestamp('created_at')->useCurrent()->comment('Дата создания');
                $table->timestamp('updated_at')->nullable()->comment('Дата обновления');
                $table->foreign('rating_id')->references('id')->on('rating')->onDelete('cascade')->onUpdate('cascade');
            });
            Illuminate\Support\Facades\DB::statement("ALTER TABLE `" . $this->name_table ."` comment 'Таблица фиксирование рейтингов по браузерам'");
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
