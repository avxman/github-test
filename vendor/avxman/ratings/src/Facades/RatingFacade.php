<?php

namespace Avxman\Rating\Facades;

use Avxman\Rating\Providers\RatingServiceProvider;
use Illuminate\Support\Facades\Facade;

/**
 * Фасад рейтинга
 *
 * @method static \Avxman\Rating\Classes\RatingClass reset()
 * @method static \Avxman\Rating\Classes\RatingClass setEnabled(bool $isEnabled = true)
 * @method static \Avxman\Rating\Classes\RatingClass setView(string $list, string $item)
 * @method static \Avxman\Rating\Classes\RatingClass setExceptModel(array $except)
 * @method static \Avxman\Rating\Classes\RatingClass setType(string $type = 'like')
 * @method static \Avxman\Rating\Classes\RatingClass setModelName(string $name)
 * @method static \Avxman\Rating\Classes\RatingClass setModelUserName(string $name)
 * @method static \Avxman\Rating\Classes\RatingClass setIp(string $ip)
 * @method static \Avxman\Rating\Classes\RatingClass setUserAgent(string $user_agent)
 * @method static \Avxman\Rating\Classes\RatingClass getOne(\Illuminate\Database\Eloquent\Model|null $model)
 * @method static \Illuminate\Database\Eloquent\Collection getMany(\Illuminate\Database\Eloquent\Collection|null $models, string $type = 'toHtml')
 * @method static bool save(\Illuminate\Support\Collection|null $collection = null, bool $isPermission = false)
 * @method static bool isError()
 * @method static \Illuminate\Support\Collection toCollection()
 * @method static array toArray()
 * @method static string toJson()
 * @method static string toHtml()
 *
 * @see
 */
class RatingFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return RatingServiceProvider::class;
    }

}
