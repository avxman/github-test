<?php

namespace Avxman\Breadcrumb\Models;

use Illuminate\Database\Eloquent\Model;

class BreadcrumbModel extends Model
{

    protected $table = 'breadcrumbs';
    protected $guarded = [];
    public $timestamps = true;

}
