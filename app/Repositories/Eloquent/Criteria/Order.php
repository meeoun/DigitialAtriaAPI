<?php
namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\ICriterion;

class Order implements ICriterion
{
    protected $column, $direction;

    public function __construct($column, $direction)
    {
        $this->column = $column;
        if($direction)
        {
            $this->direction = $direction;
        }else{
            $this->direction = 'desc';
        }


    }


    public function apply($model)
    {

        return $model->orderBy($this->column, $this->direction);


    }
}
