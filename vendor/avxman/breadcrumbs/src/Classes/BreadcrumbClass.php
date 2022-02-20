<?php

namespace Avxman\Breadcrumb\Classes;

use Avxman\Breadcrumb\Abstracts\BreadcrumbAbstract;
use Avxman\Breadcrumb\Interfaces\BreadcrumbAdminInterface;
use Avxman\Breadcrumb\Interfaces\BreadcrumbInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BreadcrumbClass extends BreadcrumbAbstract implements BreadcrumbInterface, BreadcrumbAdminInterface
{

    /**
     * Получаем список хлебных крошек
     * @param string $nameModel
     * @param int $id
     * @return BreadcrumbInterface
     */
    public function init(string $nameModel, int $id): self
    {
        if(class_exists($nameModel) !== false) {
            $this->getModel($nameModel, $id);
            $this->items = $this->getCollection();
        }
        return $this;
    }

    /**
     * Получаем список хлебных крошек все ссылки
     * @return self
    */
    public function all() : self{
        if($this->isHome) $this->addHome();
        return $this;
    }

    /**
     * Получаем список хлебных крошек кроме последней ссылки
     * @return self
     */
    public function exceptLast(): self
    {
        $count = $this->items->count();
        if($count) $this->items->forget($count-1);
        if($this->isHome) $this->addHome();
        return $this;
    }

    /**
     * Получаем список хлебных крошек первой и последней ссылки
     * @return self
     */
    public function onlyLast(): self
    {
        $count = $this->items->count();
        if($count) $this->items = $this->items->only($count-1);
        if($this->isHome) $this->addHome();
        return $this;
    }

    /**
     * Указываем свой шаблон для хлебных крошек
     * @param string $nameViewItems
     * @param string $nameViewItem
     * @return self
     */
    public function setView(string $nameViewItems = 'vendor.breadcrumbs.items', string $nameViewItem = 'vendor.breadcrumbs._item'): self
    {
        $this->nameViewItems = $nameViewItems;
        $this->nameViewItem = $nameViewItem;
        return $this;
    }

    /**
     * Выводить ссылку на главную страницу в хлебных крошках
     * @param bool $add = true
     * @return self
    */
    public function setAddHome(bool $add = true) : self{
        $this->isHome = $add;
        return $this;
    }

    /**
     * Конвертируем список хлебных крошек в коллекцию - вызов в последнюю очередь
     * @return Collection
     */
    public function toCollection(): Collection
    {
        return $this->items;
    }

    /**
     * Конвертируем список хлебных крошек в массив - вызов в последнюю очередь
     * @return array
     */
    public function toArray(): array
    {
        return $this->items->toArray();
    }

    /**
     * Конвертируем список хлебных крошек в json строку - вызов в последнюю очередь
     * @return string
     */
    public function toJson(): string
    {
        return $this->items->toJson();
    }

    /**
     * Конвертируем список хлебных крошек в HTML строку - вызов в последнюю очередь
     * @return string
     */
    public function toHtml(): string
    {
        return $this->convertToHtml();
    }

    /**
     * Сохраняем хлебные крошки (админка)
     * @param Collection $items
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function save(Collection $items, Model $model, array $data = []): bool
    {
        if (!$items->count() || !($model->id??false)) return false;
        $item = $this->getModel($model::class, $model->id);
        if($item && get_class($item) !== get_class($model)) {
            $item->breadcrumb = $this->convertToContext($items, true)[0];
            return $item->save();
        }
        return (bool)$this->model::create(collect($this->convertToModel($model))->merge($this->convertToContext($items))->toArray());
    }
}
