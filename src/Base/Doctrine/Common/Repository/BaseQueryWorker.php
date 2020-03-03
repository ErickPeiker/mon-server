<?php

namespace App\Base\Doctrine\Common\Repository;

abstract class BaseQueryWorker
{
    public function getQuery()
    {
        return $this->queryBuilder->getQuery();
    }

    public function count()
    {
        return count($this->getResult());
    }

    public function toArray(array $options = [])
    {
        $array = [];

        foreach ($this->getResult() as $item) {
            if (method_exists($item, 'toArray')) {
                array_push($array, $item->toArray($options));
            } else {
                array_push($array, $item);
            }
        }

        return $array;
    }

    public function withFilters(array $filters = null)
    {
        foreach ($filters as $filter) {
            switch ($filter['type']) {
                case 'select':
                    $this->select($filter['fields']);
                    break;
                case 'andWhere':
                    $this->andWhere($filter['field'], $filter['operation'], $filter['value']);
                    break;
                case 'orWhere':
                    $this->orWhere($filter['field'], $filter['operation'], $filter['value']);
                    break;
                case 'groupBy':
                    $this->groupBy($filter['field']);
                    break;
                case 'orderBy':
                    $this->orderBy($filter['field'], $filter['order']);
                    break;
                case 'paginate':
                    $this->paginate($filter['limit'], isset($filter['page']) ? $filter['page'] : 0);
                    break;
                default:
                    abort(400, "Filter '{$filter['type']}' not recognized!");
            }
        }

        return $this;
    }
}
