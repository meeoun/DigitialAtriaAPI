<?php
namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\ICriterion;

class Latest implements ICriterion
{


    public function apply($model)
    {
        return $model->latest();
    }
}
