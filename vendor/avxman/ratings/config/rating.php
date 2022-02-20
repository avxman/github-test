<?php

return [

    // Вкл./Откл. рейтинг на сайте
    'enabled' => env('RATING_ENABLED', true),

    // Вид рейтинга на сайте по умолчанию
    'type' =>env('RATING_TYPE', 'like'),

    // Список типов рейтинга на сайте, по умолчанию есть только 'like'=>2
    // 'four'=>4, 'thousand'=>100,
    'type_list'=>[
        'five'=>5,
        'ten'=>10
    ],

    // Шаблоны рейтинга
    'views'=> [
        'list'=>'vendor.rating.items',
        'item'=>'vendor.rating._item'
    ],

    // Модели рейтинга
    'model'=>[
        'rating'=>\Avxman\Rating\Models\RatingModel::class,
        'rating_user'=>\Avxman\Rating\Models\RatingUserModel::class,
    ],

    // Исключаем рейтинг для моделей
    'except_model'=>[
        //\App\Models\User::class
    ],

];
