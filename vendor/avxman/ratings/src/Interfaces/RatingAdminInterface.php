<?php

namespace Avxman\Rating\Interfaces;

use Illuminate\Support\Collection;

interface RatingAdminInterface
{

    // Второй уровень
    /**
     * Сохраняем рейтинг модели
     * @param Collection|null $collection = null | ['model'=>App\User\Model,'model_id'=>1,'rating'=>1]
     * @param bool $isPermission = false
     * @return bool
     */
    public function save(Collection|null $collection = null, bool $isPermission = false) : bool;

}
