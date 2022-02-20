<?php

namespace Avxman\Breadcrumb\Facades;

use Avxman\Breadcrumb\Providers\BreadcrumbServiceProvider;
use Illuminate\Support\Facades\Facade;

/**
 * Фасад Хлебных крошек
 * @method static \Avxman\Breadcrumb\Classes\BreadcrumbClass init(string $nameModel, int $id)
 * @method static \Avxman\Breadcrumb\Classes\BreadcrumbClass all()
 * @method static \Avxman\Breadcrumb\Classes\BreadcrumbClass exceptLast()
 * @method static \Avxman\Breadcrumb\Classes\BreadcrumbClass onlyLast()
 * @method static \Avxman\Breadcrumb\Classes\BreadcrumbClass setView(string $nameViewItems = 'vendor.breadcrumbs.items', string $nameViewItem = 'vendor.breadcrumbs._item')
 * @method static \Avxman\Breadcrumb\Classes\BreadcrumbClass setAddHome(bool $add = true)
 * @method static \Illuminate\Support\Collection toCollection()
 * @method static array toArray()
 * @method static string toJson()
 * @method static string toHtml()
 * @method static bool save(\Illuminate\Support\Collection $items, \Illuminate\Database\Eloquent\Model $model, array $data = [])
 *
 *
 * @see \Avxman\Breadcrumb\Classes\BreadcrumbClass
 */
class BreadcrumbFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BreadcrumbServiceProvider::class;
    }

}
