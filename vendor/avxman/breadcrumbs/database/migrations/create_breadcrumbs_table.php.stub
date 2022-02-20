<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreadcrumbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breadcrumbs', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(1)->comment('Показывать/Не показывать хлебную крошку');
            $table->string('model_class')->comment('Модель класса');
            $table->integer('model_id')->comment('ID Модели');
            $table->text('breadcrumb')->comment('Коллекция ссылок и текстов хлебных крошек');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('breadcrumbs');
    }
}
