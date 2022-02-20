<?php

namespace Avxman\Breadcrumb\Interfaces;

use Illuminate\Support\Collection;

interface BreadcrumbInterface
{

    /**
     * Получаем список хлебных крошек
     * @param string $nameModel
     * @param int $id
     * @return self
     */
    public function init(string $nameModel, int $id) : self;

    /**
     * Получаем список хлебных крошек все ссылки
     * @return self
     */
    public function all() : self;

    /**
     * Получаем список хлебных крошек кроме последней ссылки
     * @return self
     */
    public function exceptLast() : self;

    /**
     * Получаем список хлебных крошек первой и последней ссылки
     * @return self
     */
    public function onlyLast() : self;

    /**
     * Указываем свой шаблон для хлебных крошек
     * @param string $nameViewItems
     * @param string $nameViewItem
     * @return self
     */
    public function setView(string $nameViewItems = 'vendor.breadcrumb.items', string $nameViewItem = 'vendor.breadcrumb._item') : self;

    /**
     * Выводить ссылку на главную страницу в хлебных крошках
     * @param bool $add = true
     * @return self
     */
    public function setAddHome(bool $add = true) : self;

    /**
     * Конвертируем список хлебных крошек в коллекцию - вызов в последнюю очередь
     * @return Collection
     */
    public function toCollection() : Collection;

    /**
     * Конвертируем список хлебных крошек в массив - вызов в последнюю очередь
     * @return array
     */
    public function toArray() : array;

    /**
     * Конвертируем список хлебных крошек в json строку - вызов в последнюю очередь
     * @return string
     */
    public function toJson() : string;

    /**
     * Конвертируем список хлебных крошек в HTML строку - вызов в последнюю очередь
     * @return string
     */
    public function toHtml() : string;

}
