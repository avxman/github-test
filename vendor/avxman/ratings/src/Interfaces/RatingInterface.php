<?php

namespace Avxman\Rating\Interfaces;

use Illuminate\Database\Eloquent\Collection as Collections;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RatingInterface
{

    // Первый уровень
    /**
     * Сброс параметров по умолчанию
     * @return self
    */
    public function reset() : self;

    /**
     * Перезапись свойства Вкл./Откл. рейтинг
     * @param bool $isEnabled = true
     * @return self
     */
    public function setEnabled(bool $isEnabled = true) : self;

    /**
     * Перезапись свойств шаблонов
     * @param string $list
     * @param string $item
     * @return self
     */
    public function setView(string $list, string $item) : self;

    /**
     * Перезапись свойства исключающих моделей, где рейтинг не будет включен
     * @param array $except
     * @return self
     */
    public function setExceptModel(array $except) : self;

    /**
     * Перезапись свойства тип рейтинга
     * @param string $type = 'like'
     * @return self
     */
    public function setType(string $type = 'like') : self;

    /**
     * Перезапись свойства рейтинговой модели
     * @param string $name
     * @return self
     */
    public function setModelName(string $name) : self;

    /**
     * Перезапись свойство рейтинга пользователя модели
     * @param string $name
     * @return self
     */
    public function setModelUserName(string $name) : self;

    /**
     * Перезапись свойства IP адреса посетителя
     * @param string $ip
     * @return self
     */
    public function setIp(string $ip) : self;

    /**
     * Перезапись свойства Юзер Агента посетителя
     * @param string $user_agent
     * @return self
     */
    public function setUserAgent(string $user_agent) : self;


    // Второй уровень
    /**
     * Инициализация рейтинга одиночной модели
     * @param Model|null $model
     * @return self
     */
    public function getOne(Model|null $model) : self;

    /**
     * Инициализация рейтинга множественных моделей
     * @param Collections|null $models
     * @param string $type = 'toHtml'
     * @return Collections
     */
    public function getMany(Collections|null $models, string $type = 'toHtml') : Collections;

    /**
     * Проверка на ошибку работы рейтинга
     * @return bool
     */
    public function isError() : bool;


    // Третий уровень
    /**
     * Конвертируем вид рейтинга в коллекцию - вызов в последнюю очередь
     * @return Collection
     */
    public function toCollection() : Collection;

    /**
     * Конвертируем вид рейтинга в массив - вызов в последнюю очередь
     * @return array
     */
    public function toArray() : array;

    /**
     * Конвертируем вид рейтинга в строку json формата - вызов в последнюю очередь
     * @return string
     */
    public function toJson() : string;

    /**
     * Конвертируем вид рейтинга в строку HTML формата - вызов в последнюю очередь
     * @return string
     */
    public function toHtml() : string;


}
