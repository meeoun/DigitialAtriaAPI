<?php
namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\ICriterion;

class Paginate implements ICriterion
{
    protected $limit;

    public function __construct($limit)
    {
        $this->limit = $limit;
    }


    public function apply($model)
    {

        return $model->paginate($this->limit);


    }
}
