<?php

namespace Avxman\Rating\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait RatingTrait
{

    /**
     * Вкл./Откл. рейтинг для текущей модели(ей)
     * @var bool $enabled = true
    */
    protected bool $enabled = true;

    /**
     * Список типов рейтинга
     * @var array $type_list = ['like'=>2,'five'=>5,'ten'=>10]
    */
    protected array $type_list = [
        'like'=>2,
    ];

    /**
     * Шаблоны рейтинга list - общий, item - вывод звезды
     * @var array $view = ['list'=>'vendor.rating.items', 'item'=>'vendor.rating._item']
    */
    protected array $view = ['list'=>'vendor.rating.items', 'item'=>'vendor.rating._item'];

    /**
     * Список исключающих моделей в выводе рейтинга
     * @var array $except_model = []
    */
    protected array $except_model = [];

    /**
     * Имя типа рейтинга
     * @var string $type = ''
    */
    protected string $type = '';

    /**
     * Количество звезд в рейтинге
     * @var int $star_count = 0
    */
    protected int $star_count = 0;

    /**
     * Найдена ошибка в коде или отсутствует вывод рейтинга
     * @var bool $isError = false
    */
    protected bool $isError = false;

    /**
     * Имя модели рейтинга
     * @var string $modelName = ''
    */
    protected string $modelName = '';

    /**
     * Имя модели пользователя рейтинга
     * @var string $modelName = ''
     */
    protected string $modelUserName = '';

    /**
     * ID авторизированного пользователя
     * @var int $user_id = 0
    */
    protected int $user_id = 0;

    /**
     * Ip - адрес пользователя при проставлении рейтинга
     * @var string $ip = ''
    */
    protected string $ip = '';

    /**
     * User agent - браузер пользователя при проставлении рейтинга
     * @var string $user_agent = ''
    */
    protected string $user_agent = '';

    /**
     * Перезаписывали данные через методы set...()
     * @var array $setParams = ['enabled'=>false, 'type'=>false]
    */
    protected array $setParams = ['enabled'=>false, 'type'=>false];

    /**
     * Статус и сообщение рейтинга при сохранении
     * @var array $message = ['code'=>0, 'message'=>[]]
    */
    protected array $message = ['code'=>0, 'message'=>[]];

    /**
     * Модель рейтинга
     * @var Model|null $model
    */
    protected Model|null $model;

    /**
     * Результат всех данных рейтинга
     * @var Collection $items
    */
    protected Collection $items;

    /**
     * Результат рейтинга для HTML кода
     * @var Collection $result
    */
    protected Collection $result;

}
