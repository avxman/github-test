<?php

namespace Avxman\Breadcrumb\Abstracts;

use Avxman\Breadcrumb\Models\BreadcrumbModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BreadcrumbAbstract
{
    /**
     * Храним список хлебных крошек
     * @var Collection $items
     */
    protected Collection $items;

    /**
     * Храним список ссылок хлебных крошек для HTML вывода
     * @var Collection $result
     */
    protected Collection $result;

    /**
     * Моделька хлебных крошек
     * @var BreadcrumbModel $model
     */
    protected BreadcrumbModel $model;

    /**
     * Результат из модельки хлебных крошек
     * @var Model $modelItem
     */
    protected Model $modelItem;

    /**
     * Вывод ссылки главной страницы
     * @var bool $isHome
     */
    protected bool $isHome = true;

    /**
     * Хлебные крошки не пустые
     * @var bool $isFind
     */
    protected bool $isFind = false;

    /**
     * Шаблон списка
     * @var string $nameViewItems
     */
    protected string $nameViewItems = 'vendor.breadcrumbs.items';

    /**
     * Шаблон ссылки
     * @var string $nameViewItem
     */
    protected string $nameViewItem = 'vendor.breadcrumbs._item';

    /**
     * Конвертируем строку в коллекцию из таблицы
     * @return Collection
     */
    protected function getCollection() : Collection{
        try {
            $collection = collect(unserialize($this->modelItem->breadcrumb));
            $this->isFind = true;
        }
        catch (\Exception $ex){
            $collection = collect();
            $this->isFind = false;
        }
        return $collection;
    }

    /**
     * Получаем выборку из таблицы и получаем одинчную запись
     */
    protected function getModel(string $nameModel, int $id) : Model{
        $model = $this->model::whereModelClass($nameModel)->whereModelId($id)->first();
        return $this->modelItem = $model?:new $nameModel;
    }

    /**
     * Добавление ссылки главной страницы
     * @return void
     */
    protected function addHome() : void{
        $this->items->prepend(['url'=>config()->get('app.url'), 'name'=>'Home']);
    }

    /**
     * Конвертируем в HTML код
     * @return string
     */
    protected function convertToHtml() : string{
        $viewItems = view($this->nameViewItems);
        $viewItem = view($this->nameViewItem);
        $this->items->each(function ($item) use ($viewItem){
            if($item) $this->result->push($viewItem->with($item)->render());
        });
        return $viewItems->with(['items'=>$this->result->join('')])->render();
    }

    /**
     *
    */
    protected function convertToModel(Model $model) : array{
        return ['enabled'=>1, 'model_class'=>$model::class, 'model_id'=>$model->id, 'breadcrumb'=>''];
    }

    /**
     *
    */
    protected function convertToContext(Collection $items, bool $isOnlyBreadcrumb = false) : array{
        return $isOnlyBreadcrumb ? [serialize($items->toArray())] : ['breadcrumb'=>serialize($items->toArray())];
    }

    /**
     * Конструктор
     * @param BreadcrumbModel $model
     */
    public function __construct(BreadcrumbModel $model)
    {
        $this->items = $this->result = collect();
        $this->model = $model;
    }

}
