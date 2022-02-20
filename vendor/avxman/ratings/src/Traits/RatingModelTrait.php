<?php

namespace Avxman\Rating\Traits;

use Avxman\Rating\Models\RatingModel;
use Avxman\Rating\Models\RatingUserModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait RatingModelTrait
{

    /**
     * Получаем рейтинг определённой модели привязанного к текущему трейту
     * @return HasOne
    */
    public function rating() : HasOne{
        return $this->hasOne(RatingModel::class, 'model_id', 'id')->where('model_class', self::class);
    }

    /**
     * Получаем список рейтингов проставленными пользователями определённой модели привязанного к текущему трейту
     * @return HasMany
    */
    public function ratingUser() : HasMany{
        return $this->hasMany(RatingUserModel::class, 'rating_id')->where('model_class', self::class);
    }

}
