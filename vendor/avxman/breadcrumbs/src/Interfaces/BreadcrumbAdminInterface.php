<?php

namespace Avxman\Breadcrumb\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BreadcrumbAdminInterface
{

    /**
     * Сохраняем хлебные крошки (админка)
     * @param Collection $items
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function save(Collection $items, Model $model, array $data = []) : bool;

}
