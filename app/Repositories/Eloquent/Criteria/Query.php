<?php
namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\ICriterion;

class Query implements ICriterion
{
    protected $query;
    protected $operator;
    protected $column;
    protected $filter;
    protected $tableColumns;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function apply($model)
    {
        $this->tableColumns =  $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
        foreach ($this->query as $column=>$filter)
        {
            $this->column = str_replace(" ","",$column);
            $this->filter =$this->applyNull($filter);
            $this->determineOperator();
            if($this->column === "orderby" or $this->column == "orderby!")
            {
                $model = $this->applyOrderBy($model);
            }
            elseif ($this->column === "limit")
            {
                $model = $model->limit($this->filter);
            }
            else {
                if(in_array($this->column,$this->tableColumns))
                {
                    if($this->filter)
                    {
                        $model = $model->where($this->column, $this->operator, $this->filter);
                    }else{
                        if($this->operator === "=")
                        {
                            $model = $model->whereNull($this->column);
                        }else
                        {
                            $model = $model->whereNotNull($this->column);
                        }
                    }
                }
            }
        }
        return $model;
    }


    private function applyNull($value)
    {
        return ($value==="null") ? null : $value;
    }


    private function applyOrderBy($model)
    {
        if($this->operator === "=")
        {
            return $model->orderBy($this->filter);
        }
        else
        {
            return $model->orderBy($this->filter, 'desc');
        }
    }


    private function determineOperator()
    {
        if(str_contains($this->column, "!"))
        {
            $this->operator= "!=";
            $this->column = str_replace("!","",$this->column);
        }else{
            $this->operator = "=";
        }
    }

}
