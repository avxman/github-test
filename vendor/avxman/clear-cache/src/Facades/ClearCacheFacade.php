<?php

namespace Avxman\ClearCache\Facades;

use Avxman\ClearCache\Providers\ClearCacheServiceProvider;
use Illuminate\Support\Facades\Facade;
use Avxman\ClearCache\Classes\ClearCacheClass;

/**
 * Фасад вкл./откл. очистка кэша сайта (приложения)
 *
 * @method static ClearCacheClass setEnabled(bool $enabled = true)
 * @method static ClearCacheClass setLaravelLocalization(bool $enabled = false)
 * @method static array getMessage()
 * @method static ClearCacheClass cache()
 * @method static ClearCacheClass config()
 * @method static ClearCacheClass route()
 * @method static ClearCacheClass view()
 * @method static ClearCacheClass all()
 *
 * @see ClearCacheClass
 */
class ClearCacheFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ClearCacheServiceProvider::class;
    }

}
